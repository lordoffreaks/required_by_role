<?php
/**
 * @file
 * Core method to work out the required property.
 */

$plugin = array(
  'label' => t('Core'),
  'handler' => array(
    'class' => 'RequiredCore',
  ),
);

class RequiredCore extends RequiredPlugin {

  /**
   * IsRequired method implementation.
   */
  public function isRequired() {

    $this->setConfiguration();
    $settings = $this->context['instance']['settings'];

    return $this->delta == 0 && $settings['required_plugin_options'];
  }

  /**
   * Helper method.
   */
  protected function setConfiguration() {
    $this->delta = $this->context['element']['#delta'];
    $this->instance = $this->context['instance'];;
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
