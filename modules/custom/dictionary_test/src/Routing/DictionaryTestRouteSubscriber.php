<?php

declare(strict_types=1);

namespace Drupal\dictionary_test\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class DictionaryTestRouteSubscriber extends RouteSubscriberBase
{
	protected function alterRoutes(RouteCollection $collection)
	{
		if ($route = $collection->get('entity.dictionary_test.edit_form')) {
			$route->setRequirement(
				'_mycustom_access_check',
				'\Drupal\dictionary_test\Access\MyCustomAccessCheck::access'
			);
		}
	}
}