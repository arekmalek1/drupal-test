<?php

declare(strict_types=1);

namespace Drupal\Tests\dictionary_test\Functional;

use Drupal\Core\Url;
use Drupal\dictionary_test\Entity\DictionaryTest as DictionaryTestEntity;

trait DictionaryEntityTrait
{
	protected function assertNormalizationEdgeCases($method, Url $url, array $request_options) {}
	
	protected function getExpectedUnauthorizedAccessMessage($method) {}
	
	protected function getExpectedUnauthorizedAccessCacheability() {}
	
	private function createEntity(int $id, string $bundle)
	{
		$dict = DictionaryTestEntity::create(
			[
				'id' => $id,
				'label' => 'label '.$id,
				'revision' => true,
				'title' => 'title '.$id,
				'description' => 'desc '.$id,
				'field_wyraz' => 'field_wyraz',
				'bundle' => $bundle,
			]
		);
		$dict->save();
	}
}