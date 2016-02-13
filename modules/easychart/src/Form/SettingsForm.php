<?php

/**
 * @file
 * Contains \Drupal\easychart\Form\SettingsForm
 */

namespace Drupal\easychart\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class SettingsForm extends ConfigFormBase {


  /**
  +   * {@inheritdoc}
  +   */
  public function getDefaults() {
    return [
      'options',
      'templates',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'easychart_admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'easychart.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('easychart.settings');
    $load_defaults = FALSE;

    // Get defaults.
    foreach (($this->getDefaults()) as $default) {
      // Verify default options.
      $default_value = $config->get($default);
      if (empty($default_value)) {
        // Set flag to true.
        $load_defaults = TRUE;
        $form['#attached']['drupalSettings']['easychart'][$default] = TRUE;
      }

    }

    if ($load_defaults) {
      $form['#attached']['library'][] = 'easychart/easychart.defaults';
      $form['#attached']['library'][] = 'easychart/lib.easycharts.full';
    }

    $options = $config->get('options');
    $form['options'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Available options'),
      '#description' => $this->t('These Highcharts options will be configurable in the Easychart interface when creating/editing a chart. See <a href="@url" target="_blank">http://api.highcharts.com/highcharts</a> for all available options.', array('@url' => Url::fromUri('http://api.highcharts.com/highcharts')->toUriString())),
      '#default_value' => $options,
      '#attributes' => array('class' => array('easychart-options')),
      '#rows' => 15,
    ];

    $form['templates'] = [
      '#type' => 'textarea',
      '#title' => t('Available templates'),
      '#default_value' => $config->get('templates'),
      '#description' => t("These templates will be selectable in the Easychart interface when creating/editing a chart."),
      '#attributes' => array('class' => array('easychart-templates')),
      '#rows' => 15,
    ];

    $form['presets'] = [
      '#type' => 'textarea',
      '#title' => t('Presets'),
      '#default_value' => $config->get('presets'),
      '#description' => $this->t('Presets for every Easychart chart. If these preset are also mentioned in the available options, they will be shown, but not editable.'),
      '#attributes' => array('class' => array('easychart-presets')),
      '#rows' => 10,
    ];

    $interval = array(3600, 10800, 21600, 32400, 43200, 86400, 172800);
    $form['url_update_frequency'] = [
      '#type' => 'select',
      '#title' => t('Update frequency'),
      '#options' => array(0 => t('Never')) + array_map([\Drupal::service('date.formatter'), 'formatInterval'], array_combine($interval, $interval)),
      '#default_value' => $config->get('url_update_frequency'),
      '#description' => $this->t('When to update the data for charts using a CSV URL.'),
      '#rows' => 10,
    ];

    $form['actions']['reset'] = [
      '#type' => 'submit',
      '#value' => t('Reset to defaults'),
      '#submit' => array('::resetForm'),
      '#limit_validation_errors' => array(),
      '#weight' => 100,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('easychart.settings')
      ->set('options', $values['options'])
      ->set('templates', $values['templates'])
      ->set('presets', $values['presets'])
      ->set('url_update_frequency', $values['url_update_frequency'])
      ->save();
  }

  /**
   * Redirect to reset form.
   *
   * @param array $form
   *   The form.
   * @param FormStateInterface $form_state
   *   The form state.
   */
  public function resetForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('easychart.reset_form');
  }
}
