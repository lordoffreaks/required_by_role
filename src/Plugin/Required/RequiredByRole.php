<?php
/**
 * @file
 * Contains \Drupal\required_by_role\Plugin\Required\RequiredByRole.
 */

namespace Drupal\required_by_role\Plugin\Required;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\required_api\Annotation\Required;
use Drupal\required_api\Plugin\Required\RequiredBase;

/**
 *
 * @Required(
 *   id = "required_by_role",
 *   label = @Translation("Required by role"),
 *   description = @Translation("Required based on current user roles.")
 * )
 */
class RequiredByRole extends RequiredBase {

  /**
   * Determines wether a field is required or not.
   *
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field
   *   An field instance object.
   *
   * @param \Drupal\user\Entity\User $account
   *   An account object.
   *
   * @return bool
   *   TRUE on required. FALSE otherwise.
   */
  public function isRequired(FieldDefinitionInterface $field, AccountInterface $account) {

    $is_required = $this->getMatches($account->getRoles(), $field->getSetting('required_plugin_options'));
    return $is_required;
  }

  /**
   * Helper method to test if the role exists into the allowed ones.
   *
   * @param array $user_roles
   *   Roles belonging to the user.
   *
   * @param array $roles
   *   Roles that are required for this field.
   *
   * @return bool
   *   Wether or not the user have a required role.
   */
  public function getMatches($user_roles, $roles) {

    $required_roles = $roles ? $roles : array();
    $user_roles = $user_roles ? $user_roles : array();

    $match = array_intersect($user_roles, $required_roles);

    return !empty($match);
  }

  /**
   * Form element to build the required property.
   *
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field
   *   The field instance
   *
   * @return array
   *   Form element
   */
  public function requiredFormElement(FieldDefinitionInterface $field) {

    $roles = user_roles();
    $default_value = $field->getSetting('required_plugin_options') ?: array();

    unset($roles[DRUPAL_AUTHENTICATED_RID]);

    $options = array();

    foreach ($roles as $role) {
      $options[$role->id()] = array(
        'name' => $role->label(),
      );
    }

    $header = array(
      'name' => array('data' => t('Role')),
    );

    $element = array(
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $options,
      '#default_value' => $default_value,
      '#js_select' => TRUE,
      '#multiple' => TRUE,
      '#empty' => t('No roles available.'),
      '#attributes' => array(
        'class' => array('tableselect-required-by-role'),
      ),
    );

    return $element;
  }

}
