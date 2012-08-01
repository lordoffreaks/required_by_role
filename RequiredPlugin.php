<?php
/**
 * @file
 * Base required class.
 */

abstract class RequiredPlugin implements RequiredInterface {

  protected $context;
  protected $account;

  /**
   * Save arguments locally.
   */
  public function setContexts($account, $context) {
    $this->context = $context;
    $this->account  = $account;

    return $this;
  }

  /**
   * Core function, determines wether or not a field widget is required.
   */
  public function isRequired() {}

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
  protected function getSettings() {
    return $this->context['instance']['settings'];
  }

  /**
   * Helper function to set the configuration.
   */
  protected function setConfiguration() {}

}
