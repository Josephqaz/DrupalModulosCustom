<?php

namespace Drupal\encuestas_interactivas\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Respuestas Block' block.
 *
 * @Block(
 *   id = "respuestas_block",
 *   admin_label = @Translation("Respuestas Block"),
 * )
 */
class RespuestasBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new RespuestasBlock instance.
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
      // Render the results of the survey.
      $encuesta = \Drupal::entityTypeManager()->getStorage('encuesta')->load($encuesta_id);
      $query = \Drupal::database()->select('respuestas', 'r')
        ->fields('r', ['respuesta'])
        ->condition('encuesta_id', $encuesta_id, '=');
      $results = $query->execute()->fetchAll();

      $result_count = [];
      $total_votes = 0;
      foreach ($results as $result) {
        if (!isset($result_count[$result->respuesta])) {
          $result_count[$result->respuesta] = 0;
        }
        $result_count[$result->respuesta]++;
        $total_votes++;
      }

      $percentages = [];
      if ($total_votes > 0) {
        foreach ($result_count as $respuesta => $count) {
          $percentages[$respuesta] = ($count / $total_votes) * 100;
        }
      }

      return [
        '#theme' => 'respuestas_block',
        '#encuesta_title' => $encuesta->get('title')->value,
        '#result_count' => $result_count,
        '#percentages' => $percentages,
      ];
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
      '#description' => $this->t('Ingrese el ID de la encuesta cuyas respuestas desea mostrar.'),
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
