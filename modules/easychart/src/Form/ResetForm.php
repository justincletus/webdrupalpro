<?php

/**
 * @file
 * Contains \Drupal\easychart\ResetForm
 */

namespace Drupal\easychart\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class ResetForm extends ConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'easychart_reset_confirm_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to reset the default values ?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('easychart.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory()->getEditable('easychart.settings')
      ->clear('options')
      ->clear('templates')
      ->clear('presets')
      ->set('url_update_frequency', 3600)
      ->save();
    drupal_set_message($this->t('The configuration options have been reset to their default values.'));
    $form_state->setRedirectUrl($this->getCancelUrl());
  }
}
