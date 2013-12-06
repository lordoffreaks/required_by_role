<?php

/**
 * @file
 * Contains \Drupal\required_by_role\Annotation\RequiredByRoleBase.
 */

namespace Drupal\required_by_role;

use Drupal\Core\Plugin\PluginBase;
use Drupal\field\Entity\FieldInstance;
use Drupal\required_by_role\RequiredByRoleInterface;

/**
 * Provides a base class for required_by_role.
 */
abstract class RequiredByRoleBase extends PluginBase implements RequiredByRoleInterface {

  /**
   * The image effect ID.
   *
   * @var string
   */
  protected $uuid;

  /**
   * The weight of the image effect.
   *
   * @var int|string
   */
  protected $weight = '';

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, array $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    //$this->setConfiguration($configuration);
  }

  public function isRequired(&$element, FieldInstance $field){}

  /**
   * {@inheritdoc}
   */
  public function transformDimensions(array &$dimensions) {
    $dimensions['width'] = $dimensions['height'] = NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getSummary() {
    return array(
      '#markup' => '',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function label() {
    return $this->pluginDefinition['label'];
  }

  /**
   * {@inheritdoc}
   */
  public function getUuid() {
    return $this->uuid;
  }

  /**
   * {@inheritdoc}
   */
  public function setWeight($weight) {
    $this->weight = $weight;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getWeight() {
    return $this->weight;
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return array(
      'uuid' => $this->getUuid(),
      'id' => $this->getPluginId(),
      'weight' => $this->getWeight(),
      'data' => $this->configuration,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration) {

    dsm($configuration, 'configuration');

    $configuration += array(
      'data' => array(),
      'uuid' => '',
      'weight' => '',
    );
    $this->configuration = $configuration['data'] + $this->defaultConfiguration();
    $this->uuid = $configuration['uuid'];
    $this->weight = $configuration['weight'];
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array();
  }

}
