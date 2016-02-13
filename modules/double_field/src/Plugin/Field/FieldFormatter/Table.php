<?php

/**
 * @file
 * Contains \Drupal\double_field\Plugin\Field\FieldFormatter\Table.
 */

namespace Drupal\double_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementations for 'table' formatter.
 *
 * @FieldFormatter(
 *   id = "double_field_table",
 *   label = @Translation("Table"),
 *   field_types = {"double_field"}
 * )
 */
class Table extends Base {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'number_column' => FALSE,
      'number_column_label' => '№',
      'first_column_label' => '',
      'second_column_label' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $settings = $this->getSettings();

    $element['number_column'] = array(
      '#type' => 'checkbox',
      '#title' => t('Enable row number column'),
      '#default_value' => $settings['number_column'],
      // @TODO: Remove this.
      '#attributes' => array('id' => 'number_column'),
    );
    $element['number_column_label'] = array(
      '#type' => 'textfield',
      '#title' => t('Number column label'),
      '#size' => 30,
      '#default_value' => $settings['number_column_label'],
      '#states' => array(
        'visible' => array('#number_column' => array('checked' => TRUE)),
      ),
    );
    foreach (array('first', 'second') as $subfield) {
      $element[$subfield . '_column_label'] = array(
        '#type' => 'textfield',
        '#title' => $subfield == 'first' ? t('First column label') : t('Second column label'),
        '#size' => 30,
        '#default_value' => $settings[$subfield . '_column_label'],
      );
    }

    return $element + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();

    $summary[] = t('Enable row number column: %number_column', ['%number_column' => $settings['number_column'] ? t('yes') : t('no')]);
    if ($settings['number_column']) {
      $summary[] = t('Number column label: %number_column_label', ['%number_column_label' => $settings['number_column_label']]);
    }

    $summary[] = t('First column label: %first_column_label', ['%first_column_label' => $settings['first_column_label']]);
    $summary[] = t('Second column label: %second_column_label', ['%second_column_label' => $settings['second_column_label']]);

    return array_merge($summary, parent::settingsSummary());
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $settings = $this->getSettings();
    $this->prepareItems($items);

    $table = ['#type' => 'table'];
    $table['#attributes']['class'][] = 'double-field-table';

    if ($settings['first_column_label'] || $settings['second_column_label']) {
      if ($settings['number_column']) {
        $header[] = $settings['number_column_label'];
      }
      $header[] = $settings['first_column_label'];
      $header[] = $settings['second_column_label'];
      $table['#header'] = $header;
    }

    foreach ($items as $delta => $item) {

      $row = [];
      if ($settings['number_column']) {
        $row[]['#markup'] = $delta + 1;
      }

      foreach (['first', 'second'] as $subfield) {

        if ($settings[$subfield]['hidden']) {
          $row[]['#markup'] = '';
        }
        else {
          $row[] = [
            '#theme' => 'double_field_subfield',
            '#settings' => $settings,
            '#subfield' => $item->{$subfield},
            '#index' => $subfield,
          ];
        }
      }

      $table[$delta] = $row;

    }

    return [$table];

  }

}
