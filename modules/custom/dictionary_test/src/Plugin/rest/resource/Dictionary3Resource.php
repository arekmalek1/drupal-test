<?php

namespace Drupal\dictionary_test\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Provides a Demo Resource
 *
 * @RestResource(
 *   id = "dictionary_resource_type_entry",
 *   label = @Translation("Dictionary - test"),
 *   uri_paths = {
 *     "canonical" = "/dictionary_rest_api/{dictionary}}"
 *   }
 * )
 */
class Dictionary3Resource extends ResourceBase
{
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
  public function get(string $dictionary): ResourceResponse
  {
      return new ResourceResponse([]);
  }
}
