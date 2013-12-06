<?php

/**
 * @file
 * Contains \Drupal\required_by_role\RequiredByRoleInterface.
 */

namespace Drupal\required_by_role;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\field\Entity\FieldInstance;

/**
 * Defines the interface for image effects.
 */
interface RequiredByRoleInterface extends PluginInspectionInterface, ConfigurablePluginInterface {

  /**
   * Determines wether a field is required or not.
   *
   * @param \Drupal\field\Entity\FieldInstance $field
   *   An image file object.
   *
   * @return bool
   *   TRUE on success. FALSE if unable to perform the image effect on the image.
   */
  public function isRequired(&$element, FieldInstance $field);

}
