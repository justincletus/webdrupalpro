<?php

/**
 * @file
 * Contains \Drupal\uc_tax\TaxRateInterface.
 */

namespace Drupal\uc_tax;

use Drupal\Core\Config\Entity\ConfigEntityInterface;


/**
 * Defines a interface for a tax rate configuration entity.
 */
interface TaxRateInterface extends ConfigEntityInterface {

  /**
   * The tax rate ID.
   *
   * @return string
   */
  public function getId();

  /**
   * The tax rate ID.
   *
   * @param string $id
   *
   * @return $this
   */
  public function setId($id);

  /**
   * The tax rate label.
   *
   * @return string
   */
  public function getLabel();

  /**
   * The tax rate label.
   *
   * @param string $label
   *
   * @return $this
   */
  public function setLabel($label);

  /**
   * The tax rate.
   *
   * @return float
   */
  public function getRate();

  /**
   * The tax rate.
   *
   * @param float $rate
   *
   * @return $this
   */
  public function setRate($rate);

  /**
   * The taxing authority jurisdiction.
   *
   * @return string
   */
  public function getJurisdiction();

  /**
   * The taxing authority jurisdiction.
   *
   * @param string $jurisdiction
   *
   * @return $this
   */
  public function setJurisdiction($jurisdiction);

  /**
   * Product item types subject to this tax rate.
   *
   * @return array
   */
  public function getProductTypes();

  /**
   * Product item types subject to this tax rate.
   *
   * @param array $product_types
   *
   * @return $this
   */
  public function setProductTypes(array $product_types);

  /**
   * Line item types subject to this tax rate.
   *
   * @return array
   */
  public function getLineItemTypes();

  /**
   * Line item types subject to this tax rate.
   *
   * @param array $line_item_types
   *
   * @return $this
   */
  public function setLineItemTypes(array $line_item_types);

  /**
   * The tax rate weight.
   *
   * @return int
   */
  public function getWeight();

  /**
   * The tax rate weight.
   *
   * @param int $weight
   *
   * @return $this
   */
  public function setWeight($weight);

  /**
   * Whether to display prices including tax.
   *
   * @return bool
   */
  public function isIncludedInPrice();

  /**
   * Whether to display prices including tax.
   *
   * @param bool $included
   *
   * @return $this
   */
  public function setIncludedInPrice($included);

  /**
   * The text to display next to prices if tax is included.
   *
   * @return string
   */
  public function getInclusionText();

  /**
   * The text to display next to prices if tax is included.
   *
   * @param string $inclusion_text
   *
   * @return $this
   */
  public function setInclusionText($inclusion_text);

  /**
   * If the tax applies only to shippable products.
   *
   * @return bool
   */
  public function isForShippable();

  /**
   * If the tax applies only to shippable products.
   *
   * @param bool $shippable
   *
   * @return $this
   */
  public function setForShippable($shippable);

}
