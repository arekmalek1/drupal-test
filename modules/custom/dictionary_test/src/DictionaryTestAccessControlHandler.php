<?php

declare(strict_types=1);

namespace Drupal\dictionary_test;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

class DictionaryTestAccessControlHandler extends EntityAccessControlHandler {

	protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account)
	{
		switch ($operation) {
			case 'view':
			return AccessResult::allowedIfHasPermission($account, 'view dictionary test');
			
			case 'update':
				$permissionName = sprintf(DynamicPermissions::PERMISSION_NAME, $entity->bundle());
				
			return AccessResult::allowedIfHasPermissions(
				$account,
				[
					'edit dictionary test',
					'administer dictionary test',
					$permissionName
				],
				'OR'
			);
			
			case 'delete':
			return AccessResult::allowedIfHasPermissions($account, ['delete dictionary test', 'administer dictionary test'], 'OR');
			
			default:
			// No opinion.
			return AccessResult::neutral();
		}
	
	}

	protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL)
	{
		return AccessResult::allowedIfHasPermissions($account, ['create dictionary test', 'administer dictionary test'], 'OR');
	}

}
