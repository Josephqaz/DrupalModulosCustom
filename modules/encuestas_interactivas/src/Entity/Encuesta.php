<?php

namespace Drupal\encuestas_interactivas\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Encuesta entity.
 *
 * @ContentEntityType(
 *   id = "encuesta",
 *   label = @Translation("Encuesta"),
 *   base_table = "encuestas",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *   },
 * )
 */
class Encuesta extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setRequired(TRUE);

    $fields['options'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Options (one per line)'))
      ->setRequired(TRUE);

    return $fields;
  }

}
