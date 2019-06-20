<?php

/**
 * TPL=ORDER-HOME
 *
 *
 */
add_action( 'storefront_child_print_products', 'storefront_get_products', 30 );
add_action( 'storefront_child_dealer_elem_select', 'storefront_make_select_dealers', 31 );
add_action( 'storefront_child__footer_fixed_overlay', 'storefront_child__footer_fixed_overlay', 32 );

function storefront_get_products($container_id)
{

    $taxonomy     = 'product_cat';
    $orderby      = 'menu_order';
    $show_count   = 0;      // 1 for yes, 0 for no
    $pad_counts   = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no
    $title        = '';
    $empty        = 1;

    $args = array(
        'taxonomy'     => $taxonomy,
        'orderby'      => $orderby,
        'show_count'   => $show_count,
        'pad_counts'   => $pad_counts,
        'hierarchical' => $hierarchical,
        'title_li'     => $title,
        'hide_empty'   => $empty,
        'exclude'      => 15
    );
    $all_categories = get_categories( $args );

    $cart = array();
    $cart_cookie = (new AjaxHandler())->getCartCookie();

    if(isset($_COOKIE[$cart_cookie])) {
        $cart = json_decode( stripslashes($_COOKIE[$cart_cookie]),true );
    }



    ?>
    <div id="<?php echo $container_id; ?>" role="tab-panel" class="tab-pane fade show active">
        <?php
        foreach ($all_categories as $cat) {

            if($cat->category_parent == 0) {
                $category_id = $cat->term_id;
                ?>
                <div class="row order-product-item">

                <div class="col-12 col-md-2">
                    <div class="text-product-title">
                        <?php echo $cat->name;?>
                    </div>
                    <div class="product-details">
                        <?php echo category_description( $category_id ); ?>
                    </div>
                </div>

                <div class="col product-item-subitems">
                <?php
                $args = array(
                    'post_type'             => 'product',
                    'post_status'           => 'publish',
                    'ignore_sticky_posts'   => 1,
                    'posts_per_page'        => '-1',
                    'orderby'         =>  'menu_order',
                    'order'            => 'ASC',
                    'tax_query'             => array(
                        array(
                            'taxonomy'      => 'product_cat',
                            'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                            'terms'         => $category_id,
                            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                        )
                    )
                );
                $products = new WP_Query($args);
                $rowcounter = (int)ceil($products->post_count / 3);

                for ( $looper=0;$looper<$rowcounter;$looper++ )
                {
                    echo "<div class='row'>";

                    for ( $x=0;$x<3;$x++ ) {

                        if ($products->have_posts()){
                            $products->next_post();
                            $the_product = wc_get_product($products->post->ID);

                            ?>
                            <div class="col">
                                <div class="product-item-subitem">
                                    <div class="row no-gutters">
                                        <div class="col-12 col-md">
                                            <img class="product-item-thumb"
                                                 src="<?php echo get_the_post_thumbnail_url($products->post->ID, 'post-thumbnail'); ?>">
                                        </div>
                                        <div class="w-100 d-none d-sm-block d-md-none"></div>
                                        <div class="col">
                                            <p class="text-normal product-item-subitem-detail">
                                                <!-- VARIANT -->
                                                <span class="product-item-text-large"><?php echo $products->post->post_title; ?></span>
                                            </p>
                                            <p class="text-normal product-item-subitem-detail">
                                                Pallet price
                                                <span class="product-item-text-large"><?php echo wc_price($the_product->get_price()); ?></span>
                                            </p>
                                            <p class="text-normal product-item-subitem-detail">
                                                Units per pallet
                                                <span class="product-item-text-large"><?php echo get_field('pallet_size', $products->post->ID); ?></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row pallet-chooser">
                                        <div class="col-12 col-md-6 label-container">
                                            <span class="label-pallets">Select the number of pallets</span>
                                        </div>
                                        <div class="w-100 d-none d-sm-block d-md-none"></div>
                                        <div class="col-12 col-md-6">
                                            <select class="form-control" name="pallets[]"
                                                    data-product-id="<?php echo $products->post->ID; ?>"
                                                    data-product-price="<?php echo $the_product->get_price(); ?>"
                                                    data-product-pallet-size="<?php echo get_field('pallet_size', $products->post->ID); ?>">
                                                <?php

                                                for ($i = 0; $i <= 10; $i++) {
                                                    if ((new AjaxHandler())->get_cart_key($products->post->ID) !== null) {
                                                        if (WC()->cart->get_cart_item((new AjaxHandler())->get_cart_key($products->post->ID))['quantity'] == $i)
                                                            echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                                        else
                                                            echo '<option value="' . $i . '">' . $i . '</option>';

                                                    } else {
                                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                                    }

                                                }

                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                        else{
                            while ($x<3)
                            {
                                echo '<div class="col invisible"></div>';
                                $x++;
                            }
                        }
                    }

                    echo '</div>';
                }


            }
            ?>

            </div>
            </div>
            <div class="category-spacer"></div>
            <?php
        }
        ?>

    </div>

    <?php
}

function storefront_make_select_dealers($elem_id)
{
    $dealers = get_users( 'orderby=nicename&role=customer' );

    ?>
    <select id="<?php echo $elem_id;?>" class="form-control">
        <option selected>Choose...</option>
        <?php



        foreach ( $dealers as $dealer ) {
            $customer = null;
            try{
                $customer = new WC_Customer($dealer->ID);
            }
            catch (Exception $exception)
            {

            }

            if ($customer)
            {
                echo '<option value="">'.$customer->get_display_name().'</option>';
            }


        }
        ?>
    </select>
    <?php
}





//PostType ORDER modification
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'ecwc_editable_order_meta_shipping' );
add_action( 'woocommerce_process_shop_order_meta', 'ecwc_save_shipping_details' );
function ecwc_editable_order_meta_shipping( $order ){

    $shippingdate = $order->get_meta('pickup-date',true);

    ?>
    <div class="address">
        <p<?php if( empty($shippingdate) ) echo ' class="none_set"' ?>>
            <strong>Shipping date:</strong>
            <?php echo ( !empty( $shippingdate ) ) ? $shippingdate : 'Anytime.' ?>
        </p>
    </div>
    <div class="edit_address"><?php
    woocommerce_wp_text_input( array(
        'id' => 'shippingdate',
        'label' => 'Shipping date',
        'wrapper_class' => 'form-field-wide',
        'class' => 'date-picker',
        'style' => 'width:100%',
        'value' => $shippingdate,
        'description' => 'This is the day, when the factory is shipping the product.'
    ) );
    ?></div><?php
}



function ecwc_save_shipping_details( $order_id ){

    $order = wc_get_order( $order_id );
    if ($order){
        if ($order->get_meta('pickup-date',true)) $order->delete_meta_data('pickup-date');
        $order->add_meta_data('pickup-date',$_POST['std-shipdate']);
    }

}
