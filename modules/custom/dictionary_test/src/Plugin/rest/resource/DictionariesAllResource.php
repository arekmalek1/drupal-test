<?php

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
 *   id = "dictionary_resource",
 *   label = @Translation("Dictionary - lista słowników + wpisy"),
 *   uri_paths = {
 *     "canonical" = "/dictionary_rest_api/dictionaries-all"
 *   }
 * )
 */
class DictionariesAllResource extends ResourceBase
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

    public function get(): ResourceResponse
    {
        $list = $this->entityStorage->loadByProperties();

        $groups = [];
        /** @var DictionaryTest $item */
        foreach ($list as $item) {
            $groups[$item->bundle()][] = DictionaryModel::fromEntity($item)->toArray();
        }

        return new ResourceResponse($groups);
    }
}
