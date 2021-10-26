<?php

namespace Drupal\dictionary_test\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the dictionary test entity edit forms.
 */
class DictionaryTestForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New dictionary test %label has been created.', $message_arguments));
      $this->logger('dictionary_test')->notice('Created new dictionary test %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The dictionary test %label has been updated.', $message_arguments));
      $this->logger('dictionary_test')->notice('Updated new dictionary test %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.dictionary_test.canonical', ['dictionary_test' => $entity->id()]);
  }

}
