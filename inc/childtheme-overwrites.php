<?php

/*
 * This is a cleanup file to get rig of some default Parent Theme functions.
 */


// Remove stuff
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

add_action( 'after_setup_theme', 'do_after_theme_setup', 100 );
function do_after_theme_setup() {
  remove_theme_support( 'wc-product-gallery-zoom' );
}


// deregister sidebars
function remove_storefront_widgets() {
  unregister_sidebar( 'sidebar-1' );
}
add_action( 'widgets_init', 'remove_storefront_widgets', 11 );

// register new sidebars
function register_childtheme_sidebars() {
  $args = array(
    'name'          => __( 'Fullscreen menu', 'storefront' ),
    'id'            => 'fullscreen-menu-widgets',    // ID should be LOWERCASE  ! ! !
    'description'   => '',
    'class'         => '',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget'  => '</li>',
    'before_title'  => '<h2 class="widgettitle">',
    'after_title'   => '</h2>',
  );
  register_sidebar( $args );
}
add_action('widgets_init', 'register_childtheme_sidebars', 5);

// unregister menu locations
function unregister_storefront_menus() {
  unregister_nav_menu( 'primary' );
  unregister_nav_menu( 'handheld' );
  unregister_nav_menu( 'secondary' );
}
add_action( 'after_setup_theme', 'unregister_storefront_menus', 11 );

// register new navs
function register_childtheme_navs() {
  $args = array(
    'header-burger' => 'Header burger menu',
    'primary' => 'Header shop menu',
    'footer' => 'Footer menu',
  );
  register_nav_menus( $args );
}
add_action( 'after_setup_theme', 'register_childtheme_navs', 12 );
