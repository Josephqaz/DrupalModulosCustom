<?php

namespace Drupal\encuestas_interactivas\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Encuesta Block' block.
 *
 * @Block(
 *   id = "encuesta_block",
 *   admin_label = @Translation("Encuesta Block"),
 * )
 */
class EncuestaBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new EncuestaBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $encuesta_id = $config['encuesta_id'] ?? NULL;

    if ($encuesta_id) {
      // Renderiza el formulario de votación de la encuesta.
      $encuesta = \Drupal::entityTypeManager()->getStorage('encuesta')->load($encuesta_id);
      $form = \Drupal::formBuilder()->getForm('Drupal\encuestas_interactivas\Form\ParticiparForm', $encuesta);
      return $form;
    }

    return [
      '#markup' => $this->t('No se ha configurado una encuesta específica.'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['encuesta_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ID de la Encuesta'),
      '#description' => $this->t('Ingrese el ID de la encuesta que desea mostrar.'),
      '#default_value' => $config['encuesta_id'] ?? '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $this->setConfigurationValue('encuesta_id', $form_state->getValue('encuesta_id'));
  }

}
