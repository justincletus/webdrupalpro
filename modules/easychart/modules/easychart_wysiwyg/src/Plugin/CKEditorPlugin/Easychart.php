<?php

/**
 * @file
 * Contains \Drupal\easychart_wysiwyg\Plugin\CKEditorPlugin\Easychart.
 */

namespace Drupal\easychart_wysiwyg\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginConfigurableInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "easychart" plugin.
 *
 * @CKEditorPlugin(
 *   id = "easychart",
 *   label = @Translation("Easychart"),
 *   module = "ckeditor"
 * )
 */
class Easychart extends CKEditorPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'easychart_wysiwyg') . '/js/plugins/easychart/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getLibraries(Editor $editor) {
    return array(
      'easychart_wysiwyg/easychart_wysiwyg.popup',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return array(
      'easychart_dialogTitleAdd' => t('Insert chart'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return array(
      'Easychart' => array(
        'label' => t('Easychart'),
        'image' => drupal_get_path('module', 'easychart_wysiwyg') . '/js/plugins/easychart/chart.png',
      ),
    );
  }



}
