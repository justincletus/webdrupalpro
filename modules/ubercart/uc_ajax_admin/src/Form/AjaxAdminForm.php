<?php

/**
 * @file
 * Contains \Drupal\uc_ajax_admin\Form\AjaxAdminForm.
 */

namespace Drupal\uc_ajax_admin\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Configures Ajax behaviours on the Ubercart checkout page.
 */
class AjaxAdminForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'uc_ajax_admin_form';
  }

  /**
   * {@inheritdoc}
   *
   * @param string $target_form
   *   The form for which ajax behaviors are to be administered. Currently only
   *   'checkout' is supported.
   */
  public function buildForm(array $form, FormStateInterface $form_state, $target_form = 'checkout') {
    module_load_include('inc', 'uc_store', 'includes/uc_ajax_attach');
    switch ($target_form) {
      case 'checkout':
        $triggers = _uc_ajax_admin_checkout_trigger_options(_uc_ajax_admin_build_checkout_form());
        $panes = \Drupal::service('plugin.manager.uc_cart.checkout_pane')->getDefinitions();
        $wrappers = array();
        foreach ($panes as $id => $pane) {
          $wrappers["$id-pane"] = $pane['title'];
        }
        break;

      default:
        throw new NotFoundHttpException();
    }
    $form['#uc_ajax_target'] = $target_form;
    $config = $this->config('uc_cart.settings')->get('ajax.' . $target_form);
    $form['#uc_ajax_config'] = $config ?: _uc_ajax_defaults($target_form);

    $form['table'] = uc_ajax_admin_table($triggers, $wrappers, $form['#uc_ajax_config']);
    $form['actions'] = array(
      '#type' => 'actions',
      'submit' => array(
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
      ),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $form['#uc_ajax_config'];
    foreach ($form_state->getValue('table') as $index => $entry) {
      $key = $entry['key'];
      if ($index === '_new') {
        if (!empty($key) && !empty($entry['panes'])) {
          $config[$key] = $entry['panes'];
        }
      }
      elseif ($entry['remove'] || empty($entry['panes'])) {
        unset($config[$key]);
      }
      else {
        $config[$key] = $entry['panes'];
      }
    }
    $this->configFactory()->getEditable('uc_cart.settings')
      ->set('ajax.' . $form['#uc_ajax_target'], $config)
      ->save();
    drupal_set_message($this->t('Your changes have been saved.'));
  }

}
