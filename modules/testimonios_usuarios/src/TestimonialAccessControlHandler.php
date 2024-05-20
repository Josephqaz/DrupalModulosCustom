<?php

namespace Drupal\testimonios_usuarios;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the Testimonio entity.
 *
 * @ingroup testimonios_usuarios
 */
class TestimonialAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\testimonios_usuarios\Entity\Testimonio $entity */
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view testimonios');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit testimonios');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete testimonios');
    }
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add testimonios');
  }
}
