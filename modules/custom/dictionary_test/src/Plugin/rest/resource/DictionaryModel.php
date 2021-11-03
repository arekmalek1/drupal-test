<?php

namespace Drupal\dictionary_test\Plugin\rest\resource;

use Drupal\dictionary_test\Entity\DictionaryTest;

class DictionaryModel
{
  private string $id;
  private string $type;
  private string $title;
  private string $word;
  private int $createdAt;

  public function __construct(
      string $id,
      string $type,
      string $title,
      string $word,
      int $createdAt
    ){
    $this->id = $id;
    $this->type = $type;
    $this->title = $title;
    $this->word = $word;
    $this->createdAt = $createdAt;
  }

  public static function fromEntity(DictionaryTest $dictionary): self
  {
      return new self(
	      $dictionary->id(),
	      $dictionary->bundle(),
	      $dictionary->getTitle(),
	      $dictionary->get('field_wyraz')->value,
	      $dictionary->getCreatedTime()
      );
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id,
      'type' => $this->type,
      'title' => $this->title,
      'word' => $this->word,
      'createdAt' => $this->createdAt,
    ];
  }
}

