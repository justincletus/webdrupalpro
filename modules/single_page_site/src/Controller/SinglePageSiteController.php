<?php

/**
 * @file
 * Contains \Drupal\single_page_site\Controller\SinglePageSiteController.
 */

namespace Drupal\single_page_site\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerResolverInterface;
use Drupal\Core\Render\Renderer;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * SinglePageSiteController.
 */
class SinglePageSiteController extends ControllerBase {

  protected $http_kernel;
  protected $settings;
  protected $dispatcher;
  protected $resolver;
  protected $renderer;
  protected $requestStack;

  public function __construct(HttpKernelInterface $http_kernel, ConfigFactoryInterface $config_factory, EventDispatcherInterface $dispatcher, ControllerResolverInterface $resolver, Renderer $renderer, RequestStack $requestStack = null) {
    $this->settings = $config_factory->get('single_page_site.config');
    $this->httpKernel = $http_kernel;
    $this->dispatcher = $dispatcher;
    $this->resolver = $resolver;
    $this->renderer = $renderer;
    $this->requestStack = $requestStack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('http_kernel'), $container->get('config.factory'),
        $container->get('event_dispatcher'),
        $container->get('controller_resolver'), $container->get('renderer'),
        $container->get('request_stack')
    );
  }

  /**
   * Returns title.
   */
  public function setTitle() {
    if (empty($this->settings->get('title'))) {
      return 'Single page site';
    }

    return $this->t($this->settings->get('title'));
  }

  /**
   * Loads single page.
   * @return type
   */
  public function load() {
    if (empty($this->settings->get('menu'))) {
      // If settings aren't set.
      return array(
        '#markup' => $this->t('You have to !configure single page before you can use it.',
            array('!configure' => \Drupal::l(t('configure'),
              Url::fromRoute('single_page_site.config')))),
      );
    }

    $items = array();
    $current_item_count = 1;
    $messages = drupal_get_messages();

    $menu_name = $this->settings->get('menu');
    $tree = _single_page_site_get_menu_children($menu_name);

    foreach ($tree as $object) {
      $output = NULL;
      // Check if menu item has to be rendered.
      $render_menu_item = FALSE;
      $itemPluginDefinition = $object->link->getPluginDefinition();
      if ($itemPluginDefinition['route_name'] != '<front>') {
        if (empty($this->settings->get('class'))) {
          // If class is empty => all menu items.
          $render_menu_item = TRUE;
        }
        // TODO: if menu attributes is ported, add check if class hide is applied.
      }

      if ($render_menu_item) {
        // Collect generated messages.
        $messages += drupal_get_messages();
        // Get params.
        $params = $itemPluginDefinition['route_parameters'];
        // Generate href.
        $href = Url::fromRoute($itemPluginDefinition['route_name'], $params)->toString();
        // Filter href.
        $anchor = _single_page_site_generate_anchor($href);
        $item_title = $itemPluginDefinition['title'];
        $item_tag = $this->settings->get('tag');

        // Handle sub request.
        $render = $this->handleSubRequest($href);
        $output = is_array($render) ? $this->renderer->render($render) : $render;
        // Let other modules makes changes to $output.
        \Drupal::moduleHandler()->alter('single_page_site_output', $output, $current_item_count);

        // Build renderable array.
        $item = array(
          'output' => $output,
          'anchor' => $anchor,
          'title' => $item_title,
          'tag' => $item_tag,
        );
        $items[] = $item;
        $current_item_count++;
      }
    }
    // Reinject the messages.
    foreach ($messages as $type => $data) {
      foreach ($data as $message) {
        drupal_set_message($message, $type);
      }
    }


    // Render output and attach JS files.
    $js_settings = array(
      'menuClass' => $this->settings->get('menuclass'),
      'distanceUp' => $this->settings->get('up'),
      'distanceDown' => $this->settings->get('down'),
      'updateHash' => $this->settings->get('updatehash'),
      'offsetSelector' => $this->settings->get('offsetselector'),
    );

    $page_content = array(
      '#theme' => 'single_page_site',
      '#items' => $items,
      '#title' => $this->setTitle(),
      '#attached' => array(
        'library' => array(
          'single_page_site/single_page_site.scrollspy',
        ),
      ),
    );

    if ($this->settings->get('smoothscrolling')) {
      // Add smotth scrolling.
      $page_content['#attached']['library'][] = 'single_page_site/single_page_site.scroll';
    }

    $page_content['#attached']['drupalSettings']['singlePage'] = $js_settings;



    return $page_content;
  }

  /**
   * Mimic the rendering of page content.
   * @param Request $request
   * @param type $type
   * @return type
   * @throws NotFoundHttpException
   */
  private function handleSubRequest($href) {
    $type = HttpKernelInterface::SUB_REQUEST;
    $request = Request::create($href, 'GET');
    //$this->requestStack->push($request);
    // request
    $event = new GetResponseEvent($this->httpKernel, $request, $type);
    $this->dispatcher->dispatch(KernelEvents::REQUEST, $event);

    if ($event->hasResponse()) {
      return $this->filterResponse($event->getResponse(), $request, $type);
    }
    // load controller
    if (false === $controller = $this->resolver->getController($request)) {
      throw new NotFoundHttpException(sprintf('Unable to find the controller for path "%s". The route is wrongly configured.',
          $request->getPathInfo()));
    }

    $event = new FilterControllerEvent($this->httpKernel, $controller, $request,
        $type);
    $this->dispatcher->dispatch(KernelEvents::CONTROLLER, $event);
    $controller = $event->getController();

    // controller arguments
    $arguments = $this->resolver->getArguments($request, $controller);
    // call controller
    $response = call_user_func_array($controller, $arguments);

    return $response;
  }

}
