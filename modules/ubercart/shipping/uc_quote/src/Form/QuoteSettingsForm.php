<?php

/**
 * @file
 * Contains \Drupal\uc_quote\Form\QuoteSettingsForm.
 */

namespace Drupal\uc_quote\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\uc_store\Address;

/**
 * Default shipping settings form.
 *
 * Sets the default shipping location of the store. Allows the user to
 * determine which quoting methods are enabled and which take precedence over
 * the others. Also sets the default quote and shipping types of all products
 * in the store. Individual products may be configured differently.
 */
class QuoteSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'uc_quote_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'uc_quote.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $quote_config = $this->config('uc_quote.settings');
    $address = $quote_config->get('store_default_address');

    $form['uc_quote_display_debug'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Display debug information to administrators.'),
      '#default_value' => $quote_config->get('display_debug'),
    );
    $form['uc_quote_require_quote'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Prevent the customer from completing an order if a shipping quote is not selected.'),
      '#default_value' => $quote_config->get('require_quote'),
    );

    $form['default_address'] = array(
      '#type' => 'details',
      '#title' => $this->t('Default pickup address'),
      '#description' => $this->t("When delivering products to customers, the original location of the product must be known in order to accurately quote the shipping cost and set up a delivery. This form provides the default location for all products in the store. If a product's individual pickup address is blank, Ubercart uses the store's default pickup address specified here."),
    );
    $form['default_address']['address'] = array(
      '#type' => 'uc_address',
      '#default_value' => $form_state->getValues() ?: $address,
      '#required' => FALSE,
    );

    $shipping_types = uc_quote_shipping_type_options();
    if (is_array($shipping_types)) {
      $form['uc_quote_type_weight'] = array(
        '#type' => 'details',
        '#title' => $this->t('List position'),
        '#description' => $this->t('Determines which shipping methods are quoted at checkout when products of different shipping types are ordered. Larger values take precedence.'),
        '#tree' => TRUE,
      );
      $weight = $quote_config->get('type_weight');
      $shipping_methods = \Drupal::moduleHandler()->invokeAll('uc_shipping_method');
      $method_types = array();
      foreach ($shipping_methods as $method) {
        // Get shipping method types from shipping methods that provide quotes
        if (isset($method['quote'])) {
          $method_types[$method['quote']['type']][] = $method['title'];
        }
      }
      if (isset($method_types['order']) && is_array($method_types['order'])) {
        $count = count($method_types['order']);
        $form['uc_quote_type_weight']['#description'] .= $this->formatPlural($count, '<br />The %list method is compatible with any shipping type.', '<br />The %list methods are compatible with any shipping type.', ['%list' => implode(', ', $method_types['order'])]);
      }
      foreach ($shipping_types as $id => $title) {
        $form['uc_quote_type_weight'][$id] = array(
          '#type' => 'weight',
          '#title' => $title . (isset($method_types[$id]) && is_array($method_types[$id]) ? ' (' . implode(', ', $method_types[$id]) . ')' : ''),
          '#delta' => 5,
          '#default_value' => isset($weight[$id]) ? $weight[$id] : 0,
        );
      }
    }
    $form['uc_store_shipping_type'] = array(
      '#type' => 'select',
      '#title' => $this->t('Default order fulfillment type for products'),
      '#options' => $shipping_types,
      '#default_value' => $quote_config->get('shipping_type'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $address = new Address();
    $address->first_name = $form_state->getValue('first_name');
    $address->last_name = $form_state->getValue('last_name');
    $address->company = $form_state->getValue('company');
    $address->phone = $form_state->getValue('phone');
    $address->street1 = $form_state->getValue('street1');
    $address->street2 = $form_state->getValue('street2');
    $address->city = $form_state->getValue('city');
    $address->zone = $form_state->getValue('zone');
    $address->postal_code = $form_state->getValue('postal_code');
    $address->country = $form_state->getValue('country');

    $quote_config = $this->config('uc_quote.settings');
    $quote_config
      ->set('store_default_address', (array) $address)
      ->set('display_debug', $form_state->getValue('uc_quote_display_debug'))
      ->set('require_quote', $form_state->getValue('uc_quote_require_quote'))
      ->set('pane_description', $form_state->getValue(['uc_quote_pane_description', 'text']))
      ->set('error_message', $form_state->getValue(['uc_quote_error_message', 'text']))
      ->set('type_weight', $form_state->getValue('uc_quote_type_weight'))
      ->set('shipping_type', $form_state->getValue('uc_store_shipping_type'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
