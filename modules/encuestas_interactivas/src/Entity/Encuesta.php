<?php

namespace Drupal\encuestas_interactivas\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

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
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *   }
 * )
 */
class Encuesta extends ContentEntityBase implements ContentEntityInterface {
  use StringTranslationTrait;

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

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE);

    $fields['options'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Options'))
      ->setRequired(TRUE);

    return $fields;
  }
}
