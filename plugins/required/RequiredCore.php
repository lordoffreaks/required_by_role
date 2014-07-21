<?php
/**
 * @file
 * RequiredCore plugin class.
 */

class RequiredCore extends RequiredPlugin {

  /**
   * IsRequired method implementation.
   */
  public function isRequired($context) {

    $settings = $this->getSettings();
    return $this->context['delta'] == 0 && $settings['required_plugin_options'];
  }

  /**
   * Provides a form element to configure the plugin options.
   */
  protected function formElement() {
    return array(
      '#type' => 'checkbox',
      '#title' => t('Required field'),
      '#weight' => -10,
    );
  }
}
