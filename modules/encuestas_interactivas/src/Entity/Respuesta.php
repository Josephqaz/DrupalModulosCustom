<?php

namespace Drupal\encuestas_interactivas\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Respuesta entity.
 *
 * @ContentEntityType(
 *   id = "respuesta",
 *   label = @Translation("Respuesta"),
 *   base_table = "respuestas",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "encuesta_id",
 *   },
 * )
 */
class Respuesta extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['encuesta_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Encuesta'))
      ->setSetting('target_type', 'encuesta')
      ->setRequired(TRUE);

    $fields['respuesta'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Respuesta'))
      ->setRequired(TRUE);

    return $fields;
  }

}
