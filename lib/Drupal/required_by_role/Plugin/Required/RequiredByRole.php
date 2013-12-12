<?php
/**
 * @file
 * Contains \Drupal\required_by_role\Plugin\Required\RequiredByRole.
 */

namespace Drupal\required_by_role\Plugin\Required;

use Drupal\Core\Annotation\Translation;
use Drupal\field\Entity\FieldInstance;
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
   * @param array $context
   *   An array of contexts provided by the implementation.
   *
   * @param \Drupal\field\Entity\FieldInstance $field
   *   An image file object.
   *
   * @return bool
   *   TRUE on required. FALSE otherwise.
   */
  public function isRequired(FieldInstance $field, $account){

    $match = array_intersect($account->getRoles(), $field->required);
    $isRequired = !empty($match);

    return $isRequired;
  }


  public function requiredFormElement(FieldInstance $field){

    $field_name = $field->getName();
    $roles = user_roles();

    unset($roles[DRUPAL_AUTHENTICATED_RID]);

    $label = t('Required field');
    $description = t('Select this if you want this field to be required for ALL ROLES, otherwise choose specific roles in the checkboxes, below, under %name' , array('%name' => 'Required by role'));

    $header = array(
      'name' => t('Role'),
    );

    $options = array();

    foreach($roles as $role){
      $options[$role->id()] = array(
        'name' => $role->label(),
      );
    }

    $module_path = drupal_get_path('module', 'required_by_role');

    // Js add, needed because STATES API behaves unproperly
    // in this context hidding required option.
    $attached = array(
      'js' => array(
        $module_path . '/required_by_role.js',
      ),
    );

    $default_value = isset($field->required) ? $field->required : array();

    $element = array(
      '#prefix' => '<label>' . $label . '</label>',
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $options,
      '#default_value' => $default_value,
      '#attached' => $attached,
      '#empty' => t('No roles available.'),
      '#attributes' => array(
        'id' => array('tableselect-required-by-role'),
      ),
      '#description' => $description,
    );

    return $element;

  }

}
