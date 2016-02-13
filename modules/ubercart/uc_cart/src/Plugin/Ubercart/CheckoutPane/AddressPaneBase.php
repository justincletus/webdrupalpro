<?php

/**
 * @file
 * Contains \Drupal\uc_cart\Plugin\Ubercart\CheckoutPane\AddressPaneBase.
 */

namespace Drupal\uc_cart\Plugin\Ubercart\CheckoutPane;

use Drupal\Core\Form\FormStateInterface;
use Drupal\uc_cart\CheckoutPanePluginBase;
use Drupal\uc_order\OrderInterface;
use Drupal\uc_store\Address;

/**
 * Provides a generic address pane that can be extended as required.
 */
abstract class AddressPaneBase extends CheckoutPanePluginBase {

  /**
   * Source pane for "copy address" checkbox.
   */
  protected static $sourcePaneId;

  /**
   * Returns additional text to display as a description.
   *
   * @return string
   *   The fieldset description.
   */
  abstract protected function getDescription();

  /**
   * Returns text to display for the 'copy address' field.
   *
   * @return string
   *   The text to display.
   */
  abstract protected function getCopyAddressText();

  /**
   * {@inheritdoc}
   */
  public function view(OrderInterface $order, array $form, FormStateInterface $form_state) {
    $user = \Drupal::currentUser();
    $pane = $this->pluginDefinition['id'];
    $source = $this->sourcePaneId();

    $contents['#description'] = $this->getDescription();

    if ($source != $pane) {
      $contents['copy_address'] = array(
        '#type' => 'checkbox',
        '#title' => $this->getCopyAddressText(),
        '#default_value' => $this->configuration['default_same_address'],
        '#ajax' => array(
          'callback' => array($this, 'ajaxRender'),
          'wrapper' => $pane . '-address-pane',
          'progress' => array(
            'type' => 'throbber',
          ),
        ),
      );
    }

    if ($user->isAuthenticated() && $addresses = uc_select_addresses($user->id(), $pane)) {
      $contents['select_address'] = array(
        '#type' => 'select',
        '#title' => $this->t('Saved addresses'),
        '#options' => $addresses['#options'],
        '#ajax' => array(
          'callback' => array($this, 'ajaxRender'),
          'wrapper' => $pane . '-address-pane',
          'progress' => array(
            'type' => 'throbber',
          ),
        ),
        '#states' => array(
          'invisible' => array(
            'input[name="panes[' . $pane . '][copy_address]"]' => array('checked' => TRUE),
          ),
        ),
      );
    }

    $contents['address'] = array(
      '#type' => 'uc_address',
      '#default_value' => $order->getAddress($pane),
      '#parents' => ['panes', $pane],
      '#prefix' => '<div id="' . $pane . '-address-pane">',
      '#suffix' => '</div>',
    );

    if ($form_state->hasValue(['panes', $pane, 'copy_address'])) {
      $contents['address']['#hidden'] = !$form_state->isValueEmpty(['panes', $pane, 'copy_address']);
    }
    elseif (isset($contents['copy_address'])) {
      $contents['address']['#hidden'] = $this->configuration['default_same_address'];
    }

    if ($element = $form_state->getTriggeringElement()) {
      $input = $form_state->getUserInput();

      if ($element['#name'] == "panes[$pane][copy_address]") {
        $address = &$form_state->getValue(['panes', $source]);
        foreach ($address as $field => $value) {
          if (substr($field, 0, strlen($source)) == $source) {
            $field = str_replace($source, $pane, $field);
            $input['panes'][$pane][$field] = $value;
            $order->$field = $value;
          }
        }
      }

      if ($element['#name'] == "panes[$pane][select_address]") {
        $address = $addresses[$element['#value']];
        foreach ($address as $field => $value) {
          $input['panes'][$pane][$pane . '_' . $field] = $value;
          $order->{$pane . '_' . $field} = $value;
        }
      }

      $form_state->setUserInput($input);
    }

    return $contents;
  }

  /**
   * {@inheritdoc}
   */
  public function process(OrderInterface $order, array $form, FormStateInterface $form_state) {
    $pane = $this->pluginDefinition['id'];
    $source = $this->sourcePaneId();

    $address = new Address();
    $panes = &$form_state->getValue('panes');
    foreach ($panes[$pane] as $field => $value) {
      if (isset($address->$field)) {
        if (!empty($panes[$pane]['copy_address'])) {
          $address->$field = $panes[$source][$field];
        }
        else {
          $address->$field = $value;
        }
      }
    }
    $order->setAddress($pane, $address);
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function review(OrderInterface $order) {
    $pane = $this->pluginDefinition['id'];
    $address = $order->getAddress($pane);
    $review[] = array('title' => $this->t('Address'), 'data' => array('#markup' => $address));
    if (uc_address_field_enabled('phone') && !empty($address->phone)) {
      $review[] = array('title' => $this->t('Phone'), 'data' => array('#plain_text' => $address->phone));
    }
    return $review;
  }

  /**
   * Returns the ID of the source (first) address pane for copying.
   */
  protected function sourcePaneId() {
    if (!isset(self::$sourcePaneId)) {
      self::$sourcePaneId = $this->pluginDefinition['id'];
    }
    return self::$sourcePaneId;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm() {
    if ($this->sourcePaneId() != $this->pluginDefinition['id']) {
      $form['default_same_address'] = array(
        '#type' => 'checkbox',
        '#title' => $this->t('Use the same address for billing and delivery by default.'),
        '#default_value' => $this->configuration['default_same_address'],
      );
      return $form;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'default_same_address' => FALSE,
    ];
  }

  /**
   * Ajax callback to re-render the full address element.
   */
  public function ajaxRender(array $form, FormStateInterface $form_state) {
    $element = &$form;
    $triggering_element = $form_state->getTriggeringElement();
    foreach (array_slice($triggering_element['#array_parents'], 0, -1) as $field) {
      $element = &$element[$field];
    }
    return $element['address'];
  }

}
