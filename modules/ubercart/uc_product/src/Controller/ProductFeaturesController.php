<?php

/**
 * @file
 * Contains \Drupal\uc_product\Controller\ProductFeaturesController.
 */

namespace Drupal\uc_product\Controller;

use Drupal\Core\Access\AccessInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller routines for product feature routes.
 */
class ProductFeaturesController extends ControllerBase {

  /**
   * Displays the product features tab on a product node edit form.
   */
  public function featuresOverview(NodeInterface $node) {
    $header = array($this->t('Type'), $this->t('Description'), $this->t('Operations'));
    $rows = [];

    $features = uc_product_feature_load_multiple($node->id());
    foreach ($features as $feature) {
      $operations = array(
        'edit' => array('title' => $this->t('Edit'), 'url' => Url::fromRoute('uc_product.feature_edit', ['node' => $node->id(), 'fid' => $feature->fid, 'pfid' => $feature->pfid])),
        'delete' => array('title' => $this->t('Delete'), 'url' => Url::fromRoute('uc_product.feature_delete', ['node' => $node->id(), 'fid' => $feature->fid, 'pfid' => $feature->pfid])),
      );
      $rows[] = array(
        array('data' => uc_product_feature_data($feature->fid, 'title')),
        array('data' => array('#markup' => $feature->description)),
        array('data' => array(
          '#type' => 'operations',
          '#links' => $operations,
        )),
      );
    }

    $build['features'] = array(
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => array('class' => array('uc-product-features')),
      '#empty' => $this->t('No features found for this product.'),
    );

    $build['add_form'] = $this->formBuilder()->getForm('Drupal\uc_product\Form\ProductFeatureAddForm', $node);

    return $build;
  }

  /**
   * Displays the add feature form.
   */
  public function featureAdd(NodeInterface $node, $fid) {
    $func = uc_product_feature_data($fid, 'callback');
    $form_state = new FormState();
    $form_state->setBuildInfo(array('args' => array($node, NULL)));
    return $this->formBuilder()->buildForm($func, $form_state);
  }

  /**
   * Displays the edit feature form.
   */
  public function featureEdit(NodeInterface $node, $fid, $pfid) {
    $func = uc_product_feature_data($fid, 'callback');
    $form_state = new FormState();
    $form_state->setBuildInfo(array('args' => array($node, uc_product_feature_load($pfid))));
    return $this->formBuilder()->buildForm($func, $form_state);
  }

  /**
   * Checks access for the feature routes.
   */
  public function checkAccess(Request $request) {
    $node = $request->get('node');

    if (uc_product_is_product($node) && $node->getType() != 'product_kit') {
      if ($this->currentUser()->hasPermission('administer product features')) {
        return AccessInterface::ALLOW;
      }

      if ($this->currentUser()->hasPermission('administer own product features') && $this->currentUser()->id() == $node->getAuthorId()) {
        return AccessInterface::ALLOW;
      }
    }

    return AccessInterface::DENY;
  }

}
