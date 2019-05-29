<?php
function add_bootstrap_input_classes( $args, $key, $value = null ) {

  /* This is not meant to be here, but it serves as a reference
  of what is possible to be changed.

  $defaults = array(
    'type'        => 'text',
    'label'      => '',
    'description'    => '',
    'placeholder'    => '',
    'maxlength'    => false,
    'required'      => false,
    'id'        => $key,
    'class'      => array(),
    'label_class'    => array(),
    'input_class'    => array(),
    'return'      => false,
    'options'      => array(),
    'custom_attributes' => array(),
    'validate'      => array(),
    'default'      => '',
  ); */

  // Start field type switch case
  switch ( $args['type'] ) {

    case "select" :  /* Targets all select input type elements, except the country and state select input types */
      $args['class'][] = 'form-group'; // Add a class to the field's html element wrapper - woocommerce input types (fields) are often wrapped within a <p></p> tag
      $args['input_class'] = array('custom-select'); // Add a class to the form input itself
      //$args['custom_attributes']['data-plugin'] = 'select2';
      $args['label_class'] = array('');
      // $args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  ); // Add custom data attributes to the form input itself
    break;

    case 'country' : /* By default WooCommerce will populate a select with the country names - $args defined for this specific input type targets only the country select element */
      $args['class'][] = 'form-group single-country';
      $args['input_class'] = array('custom-select');
      $args['label_class'] = array('');
    break;

    case "state" : /* By default WooCommerce will populate a select with state names - $args defined for this specific input type targets only the country select element */
      $args['class'][] = 'form-group'; // Add class to the field's html element wrapper
      $args['input_class'] = array('custom-select'); // add class to the form input itself
      //$args['custom_attributes']['data-plugin'] = 'select2';
      $args['label_class'] = array('');
      $args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  );
    break;


    case "password" :
    case "text" :
    case "email" :
    case "tel" :
    case "number" :
      $args['class'][] = 'form-group';
      //$args['input_class'][] = 'form-control input-lg'; // will return an array of classes, the same as bellow
      $args['input_class'] = array('form-control');
      $args['label_class'] = array('');
    break;

    case 'textarea' :
      $args['input_class'] = array('form-control');
      $args['label_class'] = array('');
    break;

    case 'checkbox' :
    break;

    case 'radio' :
    break;

    default :
      $args['class'][] = 'form-group';
      $args['input_class'] = array('form-control');
      $args['label_class'] = array('');
    break;
  }

  return $args;
}
add_filter('woocommerce_form_field_args','add_bootstrap_input_classes', 10, 3);
