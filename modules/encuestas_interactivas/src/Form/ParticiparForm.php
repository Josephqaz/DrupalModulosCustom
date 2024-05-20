<?php

namespace Drupal\encuestas_interactivas\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ParticiparForm.
 */
class ParticiparForm extends FormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new ParticiparForm.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'participar_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $encuesta = NULL) {
    if (!$encuesta) {
      return [];
    }

    // Attach the necessary libraries
    $form['#attached']['library'][] = 'encuestas_interactivas/bootstrap';
    $form['#attached']['library'][] = 'encuestas_interactivas/encuestas_interactivas';

    $form['#attributes']['class'][] = 'form-horizontal'; // Clase de Bootstrap para formularios horizontales

    $form['encuesta_title'] = [
      '#type' => 'markup',
      '#markup' => '<h2>' . $encuesta->get('title')->value . '</h2>',
      '#prefix' => '<div class="form-group">',
      '#suffix' => '</div>',
    ];

    $options = explode("\n", $encuesta->get('options')->value);

    // Contenedor para las opciones de la encuesta
    $form['options_fieldset'] = [
      '#type' => 'radios',
      '#title' => $this->t('Options'),
      '#options' => array_combine($options, $options),
      '#prefix' => '<div id="options-wrapper" class="mt-3">',
      '#suffix' => '</div>',
      '#attributes' => ['class' => ['form-check']],
    ];

    // Contenedor para el botón de votación
    $form['submit_container'] = [
      '#type' => 'container',
      '#attributes' => ['class' => ['form-group mt-4']], // Añadimos mt-4 para margen superior
    ];

    $form['submit_container']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Vote'),
      '#attributes' => ['class' => ['btn btn-primary']],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validación personalizada si es necesario.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    try {
      $encuesta_id = $form_state->getBuildInfo()['args'][0]->id();
      $respuesta = $form_state->getValue('options_fieldset');

      if ($respuesta) {
        $storage = $this->entityTypeManager->getStorage('respuesta');
        if ($storage) {
          $respuesta_entity = $storage->create([
            'encuesta_id' => $encuesta_id,
            'respuesta' => $respuesta,
          ]);
          $respuesta_entity->save();

          \Drupal::messenger()->addMessage($this->t('Thank you for your vote.'));
        } else {
          \Drupal::messenger()->addMessage($this->t('Error: could not find storage for respuestas.'), 'error');
        }
      } else {
        \Drupal::messenger()->addMessage($this->t('Please select an option.'), 'error');
      }
    } catch (\Exception $e) {
      \Drupal::messenger()->addMessage($this->t('An error occurred: @message', ['@message' => $e->getMessage()]), 'error');
    }
  }

}
