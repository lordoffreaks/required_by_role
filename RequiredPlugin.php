<?php
/**
 * @file
 * Base required class.
 */

abstract class RequiredPlugin implements RequiredInterface {

  protected $context;

  /**
   * Provides a form element to configure the plugin options.
   */
  protected function formElement() {
    return array();
  }

  /**
   * Provides a form element to configure the plugin options.
   */
  public function form($value) {

    $default_value = !empty($value) ? $value : NULL;

    $element = array(
      '#prefix' => '<div id="required-ajax-wrapper">',
      '#suffix' => '</div>',
      '#default_value' => $default_value,
    ) + $this->formElement();

    return $element;
  }

  /**
   * Helper function to get the plugin settings.
   */
  protected function getAccount() {
    return $this->context['account'];
  }

  /**
   * Helper function to get the plugin settings.
   */
  protected function getSettings() {
    return $this->context['instance']['settings'];
  }
}
