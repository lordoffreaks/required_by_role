<?php
/**
 * @file
 * Contains \Drupal\required_by_role\Plugin\RequiredByRole\TextFieldRequiredByRole.
 */

namespace Drupal\required_by_role\Plugin\RequiredByRole;

use Drupal\Core\Annotation\Translation;
use Drupal\field\Entity\FieldInstance;
use Drupal\required_by_role\Annotation\RequiredByRole;
use Drupal\required_by_role\RequiredByRoleInterface;
use Drupal\required_by_role\RequiredByRoleBase;

/**
 * Checks required by role in textfields.
 *
 * @RequiredByRole(
 *   id = "text_textfield",
 *   label = @Translation("Textfield"),
 *   description = @Translation("Implements required by role for textfields.")
 * )
 */
class TextFieldRequiredByRole extends RequiredByRoleBase implements RequiredByRoleInterface {

  /**
   * Determines wether a field is required or not.
   *
   * @param \Drupal\field\Entity\FieldInstance $field
   *   An image file object.
   *
   * @return bool
   *   TRUE on success. FALSE if unable to perform the image effect on the image.
   */
  public function isRequired(&$element, FieldInstance $field){

    $element['#required'] = TRUE;

    if (!empty($element['value'])) {
      $element['value']['#required'] = $element['#required'];
    }

    dsm($element, 'element');
    dsm($field, 'field');
  }


  /**
   * {@inheritdoc}
   */
  public function applyEffect(FieldInstance $image) {
    list($x, $y) = explode('-', $this->configuration['anchor']);
    $x = image_filter_keyword($x, $image->getWidth(), $this->configuration['width']);
    $y = image_filter_keyword($y, $image->getHeight(), $this->configuration['height']);
    if (!$image->crop($x, $y, $this->configuration['width'], $this->configuration['height'])) {
      watchdog('image', 'Image crop failed using the %toolkit toolkit on %path (%mimetype, %dimensions)', array('%toolkit' => $image->getToolkitId(), '%path' => $image->getSource(), '%mimetype' => $image->getMimeType(), '%dimensions' => $image->getWidth() . 'x' . $image->getHeight()), WATCHDOG_ERROR);
      return FALSE;
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getSummary() {
    return array(
      '#theme' => 'image_crop_summary',
      '#data' => $this->configuration,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + array(
      'anchor' => 'center-center',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getForm() {
    $form = parent::getForm();
    $form['anchor'] = array(
      '#type' => 'radios',
      '#title' => t('Anchor'),
      '#options' => array(
        'left-top' => t('Top') . ' ' . t('Left'),
        'center-top' => t('Top') . ' ' . t('Center'),
        'right-top' => t('Top') . ' ' . t('Right'),
        'left-center' => t('Center') . ' ' . t('Left'),
        'center-center' => t('Center'),
        'right-center' => t('Center') . ' ' . t('Right'),
        'left-bottom' => t('Bottom') . ' ' . t('Left'),
        'center-bottom' => t('Bottom') . ' ' . t('Center'),
        'right-bottom' => t('Bottom') . ' ' . t('Right'),
      ),
      '#theme' => 'image_anchor',
      '#default_value' => $this->configuration['anchor'],
      '#description' => t('The part of the image that will be retained during the crop.'),
    );
    return $form;
  }

}
