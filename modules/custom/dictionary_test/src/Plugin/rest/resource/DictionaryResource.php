<?php

declare(strict_types=1);

namespace Drupal\dictionary_test\Plugin\rest\resource;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\dictionary_test\Entity\DictionaryTest;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Demo Resource
 *
 * @RestResource(
 *   id = "dictionary_resource_type",
 *   label = @Translation("Dictionary - lista wpisów danym w słowniku"),
 *   uri_paths = {
 *     "canonical" = "/dictionary_rest_api/{dictionary}"
 *   }
 * )
 */
class DictionaryResource extends ResourceBase
{
    private EntityStorageInterface $entityStorage;

    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        array $serializer_formats,
        LoggerInterface $logger,
        EntityStorageInterface $entityStorage
    ) {
      parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
      $this->entityStorage = $entityStorage;
    }

    public static function create(
        ContainerInterface $container,
        array $configuration,
        $plugin_id,
        $plugin_definition
    ) {
      return new static(
          $configuration,
          $plugin_id,
          $plugin_definition,
          $container->getParameter('serializer.formats'),
          $container->get('logger.factory')->get('rest'),
          $container->get('entity_type.manager')->getStorage('dictionary_test')
      );
    }

    public function get(string $dictionary): ResourceResponse
    {
        $list = $this->entityStorage
            ->loadByProperties([
                'bundle' => $dictionary,
            ])
        ;

        $result = [];
        /** @var DictionaryTest $item */
        foreach ($list as $item) {
            $result[] = DictionaryModel::fromEntity($item)->toArray();
        }

        return new ResourceResponse(['data' => $result]);
    }
}
