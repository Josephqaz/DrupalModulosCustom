<?php

namespace Drupal\encuestas_interactivas\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a block to display an encuesta form.
 *
 * @Block(
 *   id = "encuesta_block",
 *   admin_label = @Translation("Encuesta Block"),
 * )
 */
class EncuestaBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $encuesta = \Drupal::entityTypeManager()->getStorage('encuesta')->loadLatest();
    if ($encuesta) {
      return \Drupal::formBuilder()->getForm('Drupal\encuestas_interactivas\Form\ParticiparForm', $encuesta);
    }
    else {
      return [
        '#markup' => $this->t('No surveys available.'),
      ];
    }
  }

}
