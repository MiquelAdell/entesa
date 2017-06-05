<?php
/**
* Plugin Name: Gravity Forms Bootstrapizer
* Plugin URI: https://miquelladell.com
* Description: Add Bootstrap Styling to your Gravity Form's forms
* Version: 1.0.0
* Author: Miquel Adell
* Author URI: http://miqueladell.com
* License: GPL v3
*/
add_filter( 'gform_field_container', 'add_bootstrap_container_class', 10, 6 );
function add_bootstrap_container_class( $field_container, $field, $form, $css_class, $style, $field_content ) {
  $id = $field->id;
  $field_id = is_admin() || empty( $form ) ? "field_{$id}" : 'field_' . $form['id'] . "_$id";
  return '<li id="' . $field_id . '" class="' . $css_class . ' form-group">{FIELD_CONTENT}</li>';
}
?>
