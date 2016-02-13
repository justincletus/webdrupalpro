<?php

/**
 * @file
 * Contains \Drupal\easychart\Plugin\Field\FieldWidget\EasychartFormatter.
 */

namespace Drupal\easychart\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Provides a default Easychart formatter.
 *
 * @FieldFormatter(
 *   id = "easychart_default",
 *   module = "easychart",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "easychart"
 *   },
 *   quickedit = {
 *     "editor" = "disabled"
 *   }
 * )
 */
class EasychartFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    // Unique distinction by $entity_id & $delta.
    $entity_id = $items->getEntity()->id();
    $element = [];

    foreach ($items as $delta => $item) {
      if ($output = $output = $this->easychartPrintChart($item, $entity_id, $delta)) {
        $element[$delta] = array('#markup' => $output['markup']);
        $element['#attached']['drupalSettings']['easychart'][$entity_id][$delta] = array(
          'config' => $output['config'],
          'csv' => $output['csv'],
        );
      }
    }

    if (!empty($element)) {
      $element['#attached']['library'][] = 'easychart/easychart.render';
      $element['#attached']['library'][] = 'easychart/lib.highcharts';
      $element['#attached']['library'][] = 'easychart/lib.easycharts.minimal';
    }

    return $element;
  }

  /**
   * Helper function to print the actual chart.
   *
   * @param $item \Drupal\Core\Field\FieldItemInterface
   *   The field item
   * @param int $entity_id
   *   The entity id
   * @param int $delta
   *   The delta
   *
   * @return string $output
   *   The field output.
   */
  public function easychartPrintChart(FieldItemInterface $item, $entity_id, $delta) {

    $values = $item->getValue();
    $output = [];

    // Verify csv being given.
    if (empty($values['csv'])) {
      return FALSE;
    }
    // Add JS for each instance when config is set.
    else {
      // Print a div for js to pick up & render chart.
      $output['markup'] = '<div class="easychart-embed--' . $entity_id . '-' . $delta . '"></div>';
      // Add config to output.
      $output['config'] = $values['config'];
      // Add csv to output.
      $output['csv'] = (!empty($values['csv'])) ? $values['csv'] : '';
    }

    return $output;
  }
}
