<?php

namespace Drupal\encuestas_interactivas\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class EncuestaController.
 */
class EncuestaController extends ControllerBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new EncuestaController.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(Connection $database, EntityTypeManagerInterface $entity_type_manager) {
    $this->database = $database;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * Resultados de la encuesta.
   */
  public function resultados($encuesta) {
    // Load the encuesta entity.
    $encuesta_entity = $this->entityTypeManager->getStorage('encuesta')->load($encuesta);
    if (!$encuesta_entity) {
      throw new NotFoundHttpException();
    }

    // Get the encuesta title.
    $encuesta_title = $encuesta_entity->get('title')->value;

    // Fetch the results.
    $query = $this->database->select('respuestas', 'r')
      ->fields('r', ['respuesta'])
      ->condition('encuesta_id', $encuesta, '=');
    $results = $query->execute()->fetchAll();

    // Process the results.
    $result_count = [];
    $total_votes = 0;
    foreach ($results as $result) {
      if (!isset($result_count[$result->respuesta])) {
        $result_count[$result->respuesta] = 0;
      }
      $result_count[$result->respuesta]++;
      $total_votes++;
    }

    // Calculate percentages.
    $percentages = [];
    if ($total_votes > 0) {
      foreach ($result_count as $respuesta => $count) {
        $percentages[$respuesta] = ($count / $total_votes) * 100;
      }
    }

    // Render the template with results.
    return [
      '#theme' => 'encuestas_interactivas_resultados',
      '#encuesta_title' => $encuesta_title,
      '#result_count' => $result_count,
      '#percentages' => $percentages,
    ];
  }

}
