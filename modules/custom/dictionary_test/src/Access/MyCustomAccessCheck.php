<?php

declare(strict_types=1);

namespace Drupal\dictionary_test\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\dictionary_test\DynamicPermissions;
use Drupal\dictionary_test\Entity\DictionaryTest;

class MyCustomAccessCheck implements AccessInterface
{
	private EntityTypeManagerInterface $entityTypeManager;
	
	public function __construct(EntityTypeManagerInterface $entityTypeManager)
	{
		$this->entityTypeManager = $entityTypeManager;
	}
	
	public function appliesTo(): string
	{
		return '_mycustom_access_check';
	}
	
	public function access(string $dictionary_test, AccountInterface $account)
	{
		/** @var DictionaryTest $dictionary */
		$dictionary = $this->entityTypeManager
			->getStorage('dictionary_test')
			->load($dictionary_test)
		;

		$permissionName = sprintf(DynamicPermissions::PERMISSION_NAME, $dictionary->bundle());

		if ($account->hasPermission($permissionName)) {
			return AccessResult::allowed();
		}

		return AccessResult::forbidden();
	}
}