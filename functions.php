<?php

// Remove stuff
add_action( 'after_setup_theme', 'do_after_theme_setup', 100 );

function do_after_theme_setup() {
  remove_theme_support( 'wc-product-gallery-zoom' );
}

// Register Custom stuff
require_once get_stylesheet_directory() . '/inc/class-wp-bootstrap-navwalker.php';
require_once get_stylesheet_directory() . '/inc/bootstrap-woocommerce-input-field-class.php';

function child_theme_scripts()
{
    // Bootstrap 4
  wp_enqueue_script('modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array(), '', true);
  wp_enqueue_script('boot1', '//code.jquery.com/jquery-3.3.1.slim.min.js', array('jquery'), '', true);
  wp_enqueue_script('boot2', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'), '', true);
  wp_enqueue_script('boot3', '//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array('jquery'), '', true);
  wp_enqueue_style('bootstrap4', '//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css', array('storefront-style','storefront-woocommerce-style'));

    // Child Theme Style
  $style_cache_buster = date("YmdHi", filemtime(get_stylesheet_directory() . '/assets/css/style.css'));
  wp_enqueue_style('storefront-child-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array('storefront-style','storefront-woocommerce-style'), $style_cache_buster, 'all');
}
add_action('wp_enqueue_scripts', 'child_theme_scripts', 20);

/**
 * Footer Navigation declaration
 *
 * @since  1.0.0
 * @return void
 */
add_action('after_setup_theme', 'register_footer_nav');
function register_footer_nav()
{
  register_nav_menu('footer', __('Footer Navigation', 'storefront'));
}

/**
 * Header
 *
 * @see  storefront_site_branding()
 * @see  storefront_primary_navigation()
 */
add_action('storefront_child_header', 'storefront_site_branding', 5);
add_action('storefront_child_header', 'storefront_primary_navigation', 10);

// Branding
function storefront_site_branding()
{
  ?>
  <div class="col col-auto"><div id="site-branding"> <?php storefront_site_title_or_logo(); ?> </div></div>
  <?php
}

// Cart
function render_cart_in_header() {
  if ( storefront_is_woocommerce_activated() ) {
    if ( is_cart() ) {
      $class = 'current-menu-item';
    } else {
      $class = '';
    }
    ?>
    <div id="site-header-cart" class="site-header-cart menu">
      <div class="cart_short <?php echo esc_attr( $class ); ?>">
        <?php storefront_cart_link(); ?>
      </div>
      <div class="cart_drawer">
        <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
      </div>
    </div>
    <?php
  }
}

// Custom menu
function clean_custom_menu($theme_location) {
  if (($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location])) {
    $menu       = get_term($locations[$theme_location], 'nav_menu');
    $menu_items = wp_get_nav_menu_items($menu->term_id);
    $menu_list = '<nav class="row align-items-center justify-content-end top-nav">' . "\n";
    $count   = 0;
    $submenu = false;

    foreach ($menu_items as $menu_item) {
      $link  = $menu_item->url;
      $title = $menu_item->title;

      if (!$menu_item->menu_item_parent) {
        $menu_list .= '<div class="col-auto cl-effect-19a">' . "\n";
        $menu_list .= '<a id="menu-' . $menu_item->ID . '" href="' . $link . '"><span data-hover="' . $title . '">' . $title . '</span></a>' . "\n";
        $menu_list .= '</div>' . "\n";
      }
      $count++;
    }
    $menu_list .= '</nav>' . "\n";
  } else {
    $menu_list = '<!-- no menu defined in location "' . $theme_location . '" -->';
  }
  echo $menu_list;
}

// Render primary navigation
function storefront_primary_navigation()
{
  ?>
  <div class="col">
    <div class="row justify-content-end">
      <div class="col-auto"><?php clean_custom_menu('primary'); ?></div>
      <div class="col-auto"><?php render_cart_in_header(); ?></div>
    </div>
  </div>
  <?php
}


/**
 * Breadcrumbs
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'change_breadcrumbs', 20);
function change_breadcrumbs( $defaults ) {
  $defaults['delimiter']   = '<div class="dot-separator"><span class="dot"></span><span class="dot"></span><span class="dot"></span></div>';
  $defaults['wrap_before'] = '<div class="storefront-breadcrumb"><div class="container"><nav class="d-flex justify-content-start woocommerce-breadcrumb">';
  $defaults['wrap_after']  = '</nav></div></div>';
  $defaults['after']       = '</div>';
  $defaults['before']      = '<div class="breadcrumb-item">';

  return $defaults;
}

/**
 * Footer
 *
 * @see  storefront_footer_widgets()
 * @see  storefront_footer_navigation()
 */
add_action('storefront_child_footer', 'storefront_footer_widgets', 10);
add_action('storefront_child_footer', 'storefront_footer_navigation', 20);

// Footer navigation
function storefront_footer_navigation() {
  ?>
  <div class="row justify-content-between">
    <div class="col-4">
      <span class="site-info"><?php echo esc_html(apply_filters('storefront_copyright_text', $content = '&copy; ' . get_bloginfo('name') . ' ' . date('Y'))); ?></span>
    </div>
    <?php
    if (has_nav_menu('footer')) {
      ?>
      <div class="col">
        <nav id="footer-navigation" role="navigation" aria-label="<?php esc_html_e('Footer Navigation', 'storefront');?>">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'footer',
              'container'      => '',
              'menu_class'     => 'nav',
              'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
              'walker'         => new WP_Bootstrap_Navwalker(),
            )
          );
          ?>
        </nav>
      </div>
    </div>
    <?php
  }
}


/**
 * My Account Page
 */
// Save VAT
function iconic_save_account_fields($customer_id) {
  if (isset($_POST['account_vat'])) {
    if ($customer_id) {
      update_field('vat_number', $_POST['account_vat'], $customer_id);
    }
  }
}
add_action('woocommerce_save_account_details', 'iconic_save_account_fields'); // edit WC account
