<?php

namespace Drupal\encuestas_interactivas\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EncuestaForm.
 */
class EncuestaForm extends FormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new EncuestaForm.
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
    return 'encuesta_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attributes']['class'][] = 'form-horizontal'; // Clase de Bootstrap para formularios horizontales

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#required' => TRUE,
      '#attributes' => ['class' => ['form-control']],
      '#prefix' => '<div class="form-group">',
      '#suffix' => '</div>',
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#required' => TRUE,
      '#attributes' => ['class' => ['form-control']],
      '#prefix' => '<div class="form-group">',
      '#suffix' => '</div>',
    ];

    if (empty($form_state->get('num_options'))) {
      $form_state->set('num_options', 1);
    }

    $num_options = $form_state->get('num_options');

    $form['options_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Options'),
      '#prefix' => '<div id="options-wrapper">',
      '#suffix' => '</div>',
    ];

    for ($i = 0; $i < $num_options; $i++) {
      $form['options_fieldset']['option_' . $i] = [
        '#type' => 'textfield',
        '#title' => $this->t('Option @number', ['@number' => $i + 1]),
        '#attributes' => ['class' => ['form-control']],
        '#prefix' => '<div class="form-group">',
        '#suffix' => '</div>',
      ];
    }

    $form['options_fieldset']['add_option'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add another option'),
      '#submit' => ['::addOne'],
      '#ajax' => [
        'callback' => '::addmoreCallback',
        'wrapper' => 'options-wrapper',
      ],
      '#attributes' => ['class' => ['btn btn-secondary']],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#attributes' => ['class' => ['btn btn-primary']],
    ];

    return $form;
  }

  /**
   * Ajax callback for the "add option" button.
   */
  public function addmoreCallback(array &$form, FormStateInterface $form_state) {
    return $form['options_fieldset'];
  }

  /**
   * Submit handler for the "add option" button.
   */
  public function addOne(array &$form, FormStateInterface $form_state) {
    $num_options = $form_state->get('num_options');
    $form_state->set('num_options', $num_options + 1);
    $form_state->setRebuild(TRUE);
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
    $title = $form_state->getValue('title');
    $description = $form_state->getValue('description');
    $options = [];

    foreach ($form_state->getValues() as $key => $value) {
      if (strpos($key, 'option_') === 0) {
        $options[] = $value;
      }
    }

    $options = implode("\n", $options);

    $encuesta = $this->entityTypeManager->getStorage('encuesta')->create([
      'title' => $title,
      'description' => $description,
      'options' => $options,
    ]);
    $encuesta->save();

    \Drupal::messenger()->addMessage($this->t('Encuesta saved.'));
  }

}
