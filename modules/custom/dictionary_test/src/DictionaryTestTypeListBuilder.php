<?php

namespace Drupal\dictionary_test;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of dictionary test type entities.
 *
 * @see \Drupal\dictionary_test\Entity\DictionaryTestType
 */
class DictionaryTestTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['title'] = $this->t('Label');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['title'] = [
      'data' => $entity->label(),
      'class' => ['menu-label'],
    ];

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No dictionary test types available. <a href=":link">Add dictionary test type</a>.',
      [':link' => Url::fromRoute('entity.dictionary_test_type.add_form')->toString()]
    );

    return $build;
  }

}
