<?php

declare(strict_types=1);

namespace Drupal\Tests\dictionary_test\Functional;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;
use Drupal\dictionary_test\Entity\DictionaryTest as DictionaryTestEntity;
use Drupal\dictionary_test\Entity\DictionaryTestType;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;

trait DictionaryEntityTrait
{
	protected function assertNormalizationEdgeCases($method, Url $url, array $request_options) {}
	
	protected function getExpectedUnauthorizedAccessMessage($method) {}
	
	protected function getExpectedUnauthorizedAccessCacheability() {}
	
	private function loadDefaultData(): void
	{
		$fieldStorage = $this->createField('field_wyraz');
		
		$bundle1 = 'bundle1';
		$this->createBundle($fieldStorage, $bundle1);
		$this->createDictionaryTestEntity($bundle1, 'słowo 1');
		$this->createDictionaryTestEntity($bundle1, 'słowo 2');
		
		$bundle2 = 'bundle2';
		$this->createBundle($fieldStorage, $bundle2);
		$this->createDictionaryTestEntity($bundle2, 'słowo 3');
		$this->createDictionaryTestEntity($bundle2, 'słowo 4');
		
		$bundle3 = 'bundle3';
		$this->createBundle($fieldStorage, $bundle3);
		$this->createDictionaryTestEntity($bundle3, 'słowo 5');
	}
	
	private function createField(string $fieldName): EntityInterface
	{
		$fieldStorage = FieldStorageConfig::create([
			'field_name' => $fieldName,
			'entity_type' => 'dictionary_test',
			'type' => 'string',
		]);
		$fieldStorage->save();
		
		return $fieldStorage;
	}
	
	private function createBundle(EntityInterface $fieldStorage, string $bundle): void
	{
		DictionaryTestType::create([
			'id' => $bundle,
			'label' => $bundle,
			'type' => $bundle,
			'name' => $bundle,
			'revision' => true,
		])->save();
		
		FieldConfig::create([
			'field_storage' => $fieldStorage,
			'bundle' => $bundle,
			'title' => $bundle,
			'required' => TRUE,
		])->save();
	}
	
	private function createDictionaryTestEntity(string $bundle, string $word): EntityInterface
	{
		$dict = DictionaryTestEntity::create([
			'label' => 'label',
			'bundle' => $bundle,
			'title' => 'title',
			'field_wyraz' => $word
		]);
		$dict->save();
		
		return $dict;
	}
}