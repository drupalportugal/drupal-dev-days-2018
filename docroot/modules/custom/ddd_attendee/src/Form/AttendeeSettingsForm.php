<?php

namespace Drupal\ddd_attendee\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AttendeeSettingsForm.
 */
class AttendeeSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ddd_attendee.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'attendee_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ddd_attendee.settings');
    $form['webhook_security_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Webhook security token.'),
      '#description' => $this->t('The ti.to webhook security token. Leave empty if you want to allow all requests.'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('webhook_security_token'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('ddd_attendee.settings')
      ->set('webhook_security_token', $form_state->getValue('webhook_security_token'))
      ->save();
  }

}
