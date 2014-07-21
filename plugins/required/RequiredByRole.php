<?php
/**
 * @file
 * Required by role plugin class.
 */

class RequiredByRole extends RequiredPlugin {

  protected $roles;
  protected $user_roles;

  /**
   * IsRequired method implementation.
   */
  public function isRequired($context) {

    $this->context = $context;

    $this->setConfiguration();

    $match = array_intersect($this->getUserRoles(), $this->getRequiredRoles());
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
   * Getter function.
   */
  public function getUserRoles() {
    return array_keys($this->user_roles);
  }

  /**
   * Getter function.
   */
  public function getRequiredRoles() {
    return $this->roles;
  }

  /**
   * Setter function.
   */
  public function setUserRoles($roles) {
    $this->user_roles = $roles;
    return $this;
  }

  /**
   * Setter function.
   */
  public function setRequiredRoles($roles) {
    $this->roles = $roles;
    return $this;
  }

  /**
   * Helper method.
   */
  protected function setConfiguration() {

    $settings = $this->getSettings();
    $account = $this->getAccount();

    $this->setUserRoles($account->roles);
    $this->setRequiredRoles($settings['required_plugin_options']);

  }
}
