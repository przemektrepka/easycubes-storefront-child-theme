<?php
/**
 * Header
 *
 * @see  storefront_site_branding()
 * @see  shop_primary_navigation()
 */

$site_type = 'detail';

add_action( 'storefront_child_burgermenu', 'header_burger_navigation', 100 );

add_action( 'storefront_child_header', 'header_burger_trigger', 5 );
add_action( 'storefront_child_header', 'storefront_site_branding', 10 );
add_action( 'storefront_child_header', 'shop_primary_navigation', 15 );


/*
 * Header burger navigation
 */
function header_burger_trigger() {
	?>
	<div class="col-1">
		<button id="screenMenuTrigger" class="burger-toggle" type="button" data-toggle="collapse" data-target="#burgerMenu .collapse" aria-controls="burgerMenu" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button>
	</div>

	<script>
		var $ = jQuery;
		$(document).ready(function () {

			$('#screenMenuTrigger').click(function () {
				$('#burgerMenu').fadeIn('fast').toggleClass('present');
			});

			$('#screenMenuHide').click(function () {
				$('#burgerMenu').fadeOut('fast').toggleClass('present');
			});
		});
	</script>
	<?php
}

function header_burger_navigation(){
	?>
	<div id="burgerMenu" class="fs-menu">
		<div class="container fs-menu-header">
			<div class="row no-gutters align-items-center">
				<div class="col col-1">
					<button id="screenMenuHide" class="burger-toggle" type="button" data-toggle="collapse" data-target="#burgerMenu .collapse" aria-controls="burgerMenu" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-times"></i></button>
				</div>
				<div class="col col-auto"><div id="site-branding"> <?php storefront_site_title_or_logo(); ?> </div></div>
			</div>
		</div>
		<div class="container fs-menu-contents collapse">
			<div class="row">
				<div class="col col-4">
					<?php wp_nav_menu( array( 'theme_location' => 'header-burger' ) ); ?>
				</div>
				<div class="col">
				</div>
			</div>
		</div>
		<div class="container fs-menu-footer">
			<div class="row justify-content-between">
				<div class="col">
					<?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?>
				</div>
				<div class="col col-auto">
					<?php is_active_sidebar( 'fullscreen-menu-widgets' ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/*
 * Custom Branding
 */
function storefront_site_branding() {
	?>
	<div class="col col-auto"><div id="site-branding"> <?php storefront_site_title_or_logo(); ?> </div></div>
	<?php
}



/*
 * Cart in header
 */
function render_cart_in_header($variant = 'detail') {
	if ($variant == 'wholesale') {
		?>
		<div class="site-header-cartlink">
			<a class="cartlink" data-toggle="collapse" href="#cartDrawerContent" title="View your cart"></a>
		</div>
		<?php
	} else {
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
}



/*
 * Custom menu
 */
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


/*
 * Render primary navigation
 */
function shop_primary_navigation() {
	?>
	<div class="col">
		<div class="row justify-content-end">
			<div class="col-auto"><?php clean_custom_menu('primary'); ?></div>
			<?php //@TODO: Condition the cart based on site type ?>
			<div class="col-auto"><?php render_cart_in_header($site_type); ?></div>
		</div>
	</div>
	<?php
}



/*
 * Custom Breadcrumbs
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'change_breadcrumbs', 20);
function change_breadcrumbs( $defaults ) {
	$defaults['delimiter']   = '<div class="dot-separator"><span class="dot"></span><span class="dot"></span><span class="dot"></span></div>';
	$defaults['wrap_before'] = '<div class="storefront-breadcrumb"><div class="container"><nav class="d-flex justify-content-start woocommerce-breadcrumb">';
	$defaults['wrap_after']  = '</nav></div></div>';
	$defaults['after']       = '</div>';
	$defaults['before']      = '<div class="breadcrumb-item">';
	$defaults['home']        = 'Shop';

	return $defaults;
}
