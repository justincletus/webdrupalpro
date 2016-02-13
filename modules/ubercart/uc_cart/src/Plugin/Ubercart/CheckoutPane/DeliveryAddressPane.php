<?php

/**
 * @file
 * Contains \Drupal\uc_cart\Plugin\Ubercart\CheckoutPane\DeliveryAddressPane.
 */

namespace Drupal\uc_cart\Plugin\Ubercart\CheckoutPane;

/**
 * Gets the user's delivery information.
 *
 * @CheckoutPane(
 *   id = "delivery",
 *   title = @Translation("Delivery information"),
 *   weight = 3,
 *   shippable = TRUE
 * )
 */
class DeliveryAddressPane extends AddressPaneBase {

  /**
   * {@inheritdoc}
   */
  protected function getDescription() {
    return $this->t('Enter your delivery address and information here.');
  }

  /**
   * {@inheritdoc}
   */
  protected function getCopyAddressText() {
    return $this->t('My delivery information is the same as my billing information.');
  }

}
