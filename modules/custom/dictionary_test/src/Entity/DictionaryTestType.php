<?php

namespace Drupal\dictionary_test\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Dictionary Test type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "dictionary_test_type",
 *   label = @Translation("Dictionary Test type"),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\dictionary_test\Form\DictionaryTestTypeForm",
 *       "edit" = "Drupal\dictionary_test\Form\DictionaryTestTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\dictionary_test\DictionaryTestTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer dictionary test types",
 *   bundle_of = "dictionary_test",
 *   config_prefix = "dictionary_test_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/dictionary_test_types/add",
 *     "edit-form" = "/admin/structure/dictionary_test_types/manage/{dictionary_test_type}",
 *     "delete-form" = "/admin/structure/dictionary_test_types/manage/{dictionary_test_type}/delete",
 *     "collection" = "/admin/structure/dictionary_test_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class DictionaryTestType extends ConfigEntityBundleBase {

  /**
   * The machine name of this dictionary test type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the dictionary test type.
   *
   * @var string
   */
  protected $label;

}
