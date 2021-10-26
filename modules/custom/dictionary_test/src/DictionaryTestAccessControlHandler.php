<?php

namespace Drupal\dictionary_test;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the dictionary test entity type.
 */
class DictionaryTestAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view dictionary test');

      case 'update':
        return AccessResult::allowedIfHasPermissions($account, ['edit dictionary test', 'administer dictionary test'], 'OR');

      case 'delete':
        return AccessResult::allowedIfHasPermissions($account, ['delete dictionary test', 'administer dictionary test'], 'OR');

      default:
        // No opinion.
        return AccessResult::neutral();
    }

  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions($account, ['create dictionary test', 'administer dictionary test'], 'OR');
  }

}
