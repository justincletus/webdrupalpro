<?php

/**
 * @file
 * Contains \Drupal\autofloat\Form\AutofloatSettingsForm.
 */

namespace Drupal\autofloat\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class AutofloatSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'autofloat_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['autofloat.settings',];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->configFactory->get('autofloat.settings');

    $form['autofloat_start'] = array(
      '#type' => 'radios',
      '#title' => t('Start with the first image on the..'),
      '#options' => array(
        0 => t('right'),
        1 => t('left (swaps "odd" and "even" classes)'),
      ),
      '#default_value' => $config->get('start'),
      '#description' => t('Re-save existing content to apply changes.'),
    );
    $form['autofloat_css'] = array(
      '#type' => 'checkbox',
      '#title' => t('Use autofloat.css'),
      '#default_value' => $config->get('css'),
      '#description' => t('Uncheck to take care of the floating and margins yourself in custom css.'),
    );
    $form['target_settings'] = array(
      '#type' => 'fieldset',
      '#title' => t('Selector/rejector settings'),
      '#description' => t('Images will float unless they have the class "nofloat". Re-save existing content to apply changes. Avoid adding classes manually by defining classes here added by other modules/filters. Use your browser inspector to find them.'),
    );
    $form['target_settings']['autofloat_span'] = array(
      '#type' => 'textfield',
      '#title' => t('Additional span classes to float'),
      '#default_value' => $config->get('span'),
      '#description' => t('A "span" with the class "float" will float all containing content, e.g. the image with a caption under it. Optionally define others. Maximum two, divided by a comma. Example: "caption".'),
    );
    $form['target_settings']['autofloat_div'] = array(
      '#type' => 'textfield',
      '#title' => t('Additional div classes to ignore'),
      '#default_value' => $config->get('div'),
      '#description' => t('Images nested within any element with the class "nofloat" will NOT float, e.g. a set of thumbnails. Optionally define others. Maximum two, divided by a comma. Example: "flickr-photoset".'),
    );

    return parent::buildForm($form, $form_state);
}

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Accept maximum two class value for the selector field.
    $limit = $form_state->getValue('autofloat_span');
    if ((substr_count($limit, ',') > 1)) {
      $form_state->setErrorByName('autofloat_span', $this->t('Not more than two values.'));
    }
    // Accept maximum two class value for the rejector field.
    $limit = $form_state->getValue('autofloat_div');
    if ((substr_count($limit, ',') > 1)) {
      $form_state->setErrorByName('autofloat_div', $this->t('Not more than two values.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable('autofloat.settings');

    $config
      ->set('start', $form_state->getValue('autofloat_start'))
      ->set('css', $form_state->getValue('autofloat_css'))
      ->set('span', $form_state->getValue('autofloat_span'))
      ->set('div', $form_state->getValue('autofloat_div'));

    $config->save();

    drupal_flush_all_caches();

    parent::submitForm($form, $form_state);
  }

}

