<?php
/**
 * @file
 * Required by role plugin.
 */

$plugin = array(
  'label' => t('By role'),
  'handler' => array(
    'class' => 'RequiredByRole',
  ),
);

class RequiredByRole extends RequiredPlugin {

  protected $roles;
  protected $user_roles;

  /**
   * IsRequired method implementation.
   */
  public function isRequired() {

    $this->setConfiguration();

    $match = array_intersect(array_keys($this->user_roles), $this->roles);
    $is_required = !empty($match);

    return $is_required;
  }

  /**
   * Provides a form element to configure the plugin options.
   */
  protected function formElement() {

    $roles = user_roles();
    unset($roles[DRUPAL_AUTHENTICATED_RID]);

    $header = array(
      'name' => t('Role'),
    );

    foreach ($roles as $rid => $role) {
      $options[$rid] = array(
        'name' => $role,
      );
    }

    $element = array(
      '#title' => t('Roles'),
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $options,
      '#empty' => t('No roles available.'),
    );

    return $element;

  }

  /**
   * Helper method.
   */
  protected function setConfiguration() {

    $settings = $this->getSettings();

    $this->user_roles = $this->account->roles;
    $this->roles = $settings['required_plugin_options'];
  }
}
