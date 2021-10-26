<?php

namespace Drupal\dictionary_test;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a dictionary test entity type.
 */
interface DictionaryTestInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the dictionary test title.
   *
   * @return string
   *   Title of the dictionary test.
   */
  public function getTitle();

  /**
   * Sets the dictionary test title.
   *
   * @param string $title
   *   The dictionary test title.
   *
   * @return \Drupal\dictionary_test\DictionaryTestInterface
   *   The called dictionary test entity.
   */
  public function setTitle($title);

  /**
   * Gets the dictionary test creation timestamp.
   *
   * @return int
   *   Creation timestamp of the dictionary test.
   */
  public function getCreatedTime();

  /**
   * Sets the dictionary test creation timestamp.
   *
   * @param int $timestamp
   *   The dictionary test creation timestamp.
   *
   * @return \Drupal\dictionary_test\DictionaryTestInterface
   *   The called dictionary test entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the dictionary test status.
   *
   * @return bool
   *   TRUE if the dictionary test is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets the dictionary test status.
   *
   * @param bool $status
   *   TRUE to enable this dictionary test, FALSE to disable.
   *
   * @return \Drupal\dictionary_test\DictionaryTestInterface
   *   The called dictionary test entity.
   */
  public function setStatus($status);

}
