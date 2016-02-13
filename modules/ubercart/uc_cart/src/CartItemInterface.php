<?php

/**
 * @file
 * Contains \Drupal\uc_cart\CartItemInterface.
 */

namespace Drupal\uc_cart;

use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining a Ubercart cart item entity.
 */
interface CartItemInterface extends ContentEntityInterface, EntityChangedInterface {

}
