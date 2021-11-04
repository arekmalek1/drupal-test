<?php

declare(strict_types=1);

namespace Drupal\dictionary_test;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DynamicPermissions implements ContainerInjectionInterface
{
	public const PERMISSION_NAME = 'dictionary_test edit %s';
	
	private EntityStorageInterface $entityStorage;
	
	public function __construct(EntityStorageInterface $entityStorage)
	{
		$this->entityStorage = $entityStorage;
	}
	
	public static function create(ContainerInterface $container)
	{
		return new static($container->get('entity_type.manager')->getStorage('dictionary_test'));
	}
	
	public function permissions(): array
	{
		$permissions = [];
		
		$list = $this->entityStorage->loadByProperties();
		
		$groups = [];
		foreach ($list as $item) {
			$groups[] = $item->bundle();
		}
		
		$groups = array_unique($groups);
		
		foreach ($groups as $group) {
			$permissions[sprintf(self::PERMISSION_NAME, $group)] = [
				'title' => 'Edycja: '.$group,
				'description' => 'Edycja słownika: '.$group,
			];
		}
		
		return $permissions;
	}
}