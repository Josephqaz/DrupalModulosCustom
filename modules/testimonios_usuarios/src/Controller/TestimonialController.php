<?php

namespace Drupal\testimonios_usuarios\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

/**
 * Controlador para gestionar testimonios.
 */
class TestimonialController extends ControllerBase {

  /**
   * La conexión a la base de datos.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   La conexión a la base de datos.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * Página de administración de testimonios.
   *
   * @return array
   *   Un render array.
   */
  public function adminPage() {
    $header = [
      'id' => $this->t('ID'),
      'uid' => $this->t('Usuario'),
      'testimonio' => $this->t('Testimonio'),
      'created' => $this->t('Creado'),
    ];

    $query = $this->database->select('testimonio', 't')
      ->fields('t', ['id', 'uid', 'testimonio', 'created']);
    $results = $query->execute()->fetchAllAssoc('id');

    $rows = [];
    foreach ($results as $result) {
      $rows[] = [
        'id' => $result->id,
        'uid' => $result->uid,
        'testimonio' => $result->testimonio,
        'created' => date('Y-m-d H:i:s', $result->created),
      ];
    }

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No hay testimonios disponibles.'),
    ];
  }

}
