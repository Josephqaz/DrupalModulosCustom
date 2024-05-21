<?php

namespace Drupal\newsletters_integration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure newsletter settings for this site.
 */
class NewsletterSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'newsletters_integration_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['newsletters_integration.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('newsletters_integration.settings');

    $form['mailchimp_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('MailChimp API Key'),
      '#default_value' => $config->get('mailchimp_api_key'),
    ];

    $form['sendinblue_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Sendinblue API Key'),
      '#default_value' => $config->get('sendinblue_api_key'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('newsletters_integration.settings')
      ->set('mailchimp_api_key', $form_state->getValue('mailchimp_api_key'))
      ->set('sendinblue_api_key', $form_state->getValue('sendinblue_api_key'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
