<?php


/**
 * Footer
 *
 * @since  1.0.0
 * @return void
 */


add_action( 'storefront_child_footer', 'storefront_footer_widgets', 10 );
add_action( 'storefront_child_footer', 'storefront_footer_navigation', 20 );

function storefront_footer_navigation() {
    ?>
    <div class="row justify-content-between">
    <div class="col-4">
        <span class="site-info"><?php echo esc_html( apply_filters( 'storefront_copyright_text', $content = '&copy; ' . get_bloginfo( 'name' ) . ' ' . date( 'Y' ) ) );?></span>
    </div>
    <?php
    if ( has_nav_menu( 'footer' ) ) {
        ?>
        <div class="col">
            <nav id="footer-navigation" role="navigation" aria-label="<?php esc_html_e( 'Footer Navigation', 'storefront' ); ?>">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'container'       => '',
                        'menu_class'      => 'nav',
                        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                    )
                );
                ?>
            </nav>
        </div>
        </div>
        <?php
    }
}



function storefront_child__footer_fixed_overlay()
{
    if( basename(get_page_template(), ".php") == "tpl-order-home")
    {
        // @TODO Caution! Had to hide the loader. The ajax call was causing 500 error and loader didnt hide. Used z-index and opacity.
        ?>
        <div class="loadingoverlayFake" style="box-sizing: border-box; position: fixed; display: flex; flex-flow: column nowrap; align-items: center; justify-content: space-around; background: rgba(255, 255, 255, 0.8); top: 0px; left: 0px; width: 100%; height: 100%;
		z-index: -2147483647; opacity: 0;">
            <div style="order: 1; box-sizing: border-box; overflow: visible; flex: 0 0 auto; display: flex; justify-content: center; align-items: center; animation-name: loadingoverlay_animation__rotate_right; animation-duration: 2000ms; animation-timing-function: linear; animation-iteration-count: infinite; width: 120px; height: 120px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" style="width: 100%; height: 100%; fill: rgb(32, 32, 32);"><circle r="80" cx="500" cy="90" style="fill: rgb(32, 32, 32);"></circle><circle r="80" cx="500" cy="910" style="fill: rgb(32, 32, 32);"></circle><circle r="80" cx="90" cy="500" style="fill: rgb(32, 32, 32);"></circle><circle r="80" cx="910" cy="500" style="fill: rgb(32, 32, 32);"></circle><circle r="80" cx="212" cy="212" style="fill: rgb(32, 32, 32);"></circle><circle r="80" cx="788" cy="212" style="fill: rgb(32, 32, 32);"></circle><circle r="80" cx="212" cy="788" style="fill: rgb(32, 32, 32);"></circle><circle r="80" cx="788" cy="788" style="fill: rgb(32, 32, 32);"></circle></svg>
            </div>
        </div>

        <?php
    }
}
