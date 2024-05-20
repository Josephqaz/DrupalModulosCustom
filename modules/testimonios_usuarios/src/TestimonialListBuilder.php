<?php

namespace Drupal\testimonios_usuarios;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Provides a list controller for the Testimonio entity.
 *
 * @ingroup testimonios_usuarios
 */
class TestimonialListBuilder extends EntityListBuilder {
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['testimonio'] = $this->t('Testimonio');
    $header['user_id'] = $this->t('Usuario');
    $header['created'] = $this->t('Creado');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\testimonios_usuarios\Entity\Testimonio $entity */
    $row['id'] = $entity->id();
    $row['testimonio'] = Link::createFromRoute(
      $entity->label(),
      'entity.testimonio.canonical',
      ['testimonio' => $entity->id()]
    );
    $row['user_id'] = $entity->getOwner()->getDisplayName();
    $row['created'] = date('Y-m-d H:i:s', $entity->getCreatedTime());
    return $row + parent::buildRow($entity);
  }
}
