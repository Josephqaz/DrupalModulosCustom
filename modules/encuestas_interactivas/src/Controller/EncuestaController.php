<?php

namespace Drupal\encuestas_interactivas\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controlador para Encuestas Interactivas.
 */
class EncuestaController extends ControllerBase {

  /**
   * Construye la respuesta.
   */
  public function build() {
    $build = [
      '#markup' => $this->t('El módulo de Encuestas Interactivas está funcionando.'),
    ];
    return $build;
  }

}
