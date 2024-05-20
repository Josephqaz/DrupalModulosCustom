<?php

namespace Drupal\encuestas_interactivas\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the Respuesta entity.
 *
 * @ContentEntityType(
 *   id = "respuesta",
 *   label = @Translation("Respuesta"),
 *   base_table = "respuestas",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "respuesta",
 *   },
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *   }
 * )
 */
class Respuesta extends ContentEntityBase implements ContentEntityInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE)
      ->setSetting('auto_increment', TRUE);

    $fields['encuesta_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Encuesta ID'))
      ->setRequired(TRUE);

    $fields['respuesta'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Respuesta'))
      ->setRequired(TRUE);

    return $fields;
  }

}
