<?php

namespace Drupal\testimonios_usuarios\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Formulario para enviar testimonios.
 */
class TestimonialForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'formulario_testimonio';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['testimonio'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Testimonio'),
      '#required' => TRUE,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Enviar'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = Database::getConnection();
    $connection->insert('testimonio')
      ->fields([
        'uid' => \Drupal::currentUser()->id(),
        'testimonio' => $form_state->getValue('testimonio'),
        'created' => \Drupal::time()->getRequestTime(),
      ])
      ->execute();
    \Drupal::messenger()->addMessage($this->t('Tu testimonio ha sido enviado.'));
  }

}
