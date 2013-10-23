<?php

/**
 * @file
 * Date hooks
 */

/**
 * Implements hook_date_text_process_alter().
 *
 * This hook lets us make changes to the date_select widget.
 */
function required_by_role_date_text_process_alter(&$element, &$form_state, $context) {
  global $user;

  $account = $user;
  $settings = $element['#instance']['settings'];
  $field = $element['#field'];

  $old_required = required_by_role_get_required_property_value($element, $field);
  $is_required = required_by_role_is_required($old_required, $account, $settings, $field);

  $element['#required'] = $element['date']['#required'] = $is_required;

}

/**
 * Implements hook_date_select_process_alter().
 *
 * This hook lets us make changes to the date_select widget.
 */
function required_by_role_date_select_process_alter(&$element, &$form_state, $context) {
  global $user;

  $account = $user;
  $settings = $element['#instance']['settings'];
  $field = $element['#field'];

  $old_required = required_by_role_get_required_property_value($element, $field);
  $is_required = required_by_role_is_required($old_required, $account, $settings, $field);

  $granularity = date_format_order($element['#date_format']);

  foreach($granularity as $key){
    $element[$key]['#required'] = $is_required;
  }

}

/**
 * Implements hook_date_date_popup_process_alter().
 *
 * This hook lets us make changes to the date_select widget.
 */
function required_by_role_date_popup_process_alter(&$element, &$form_state, $context) {

  global $user;

  $account = $user;
  $settings = $element['#instance']['settings'];
  $field = $element['#field'];

  $old_required = required_by_role_get_required_property_value($element, $field);
  $is_required = required_by_role_is_required($old_required, $account, $settings, $field);

  $granularity = date_format_order($element['#date_format']);
  $has_time = date_has_time($granularity);

  $element['#required'] = $element['date']['#required'] = $is_required;

  if($has_time){
    $element['time']['#required'] = $is_required;
  }
}

/**
 * Implements hook_date_combo_process_alter().
 *
 * This hook lets us make changes to the date_select widget.
 */
function required_by_role_date_combo_process_alter(&$element, &$form_state, $context) {

}

