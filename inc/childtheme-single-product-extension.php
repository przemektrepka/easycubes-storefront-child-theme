<?php

/**
 * Rework price + add to cart layout
 */
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_before_price', 9 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_after_price', 11 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_after_atc', 31 );

function woocommerce_template_single_before_price() {
  ?>
  <div class="row align-items-center price-n-cart">
    <div class="col">
  <?php
}

function woocommerce_template_single_after_price() {
  ?>
    </div>
    <div class="col">
  <?php
}

function woocommerce_template_single_after_atc() {
  ?>
    </div>
  </div>
  <?php
}

/**
 * Add attribus to product summary
 */
add_action( 'woocommerce_single_product_summary', 'show_attr_in_prod_summary', 35 );

function show_attr_in_prod_summary() {
  $tabs = apply_filters( 'woocommerce_product_tabs', array() );
  if ( ! empty( $tabs ) ) : ?>
    <div class="single-product--extra-info">
      <?php foreach ( $tabs as $key => $tab ) : ?>
        <div class="panel" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
          <?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <?php
}


/**
 * Change tab headings
 */
add_filter( 'woocommerce_product_additional_information_heading', 'change_product_additional_information_tab_heading', 10, 1 );
function change_product_additional_information_tab_heading( $title ) {
  // $title = 'Product data';
  $title = '';
  return $title;
}

add_filter( 'woocommerce_product_description_heading', 'change_product_description_tab_heading', 10, 1 );
function change_product_description_tab_heading( $title ) {
  $title = '';
  return $title;
}

/**
 * Add a custom product data tab
 */
add_filter( 'woocommerce_product_tabs', 'edit_product_tabs', 98 );
function edit_product_tabs( $tabs ) {

  $tabs['description']['title'] = 'More Information';   // Rename the description tab
  $tabs['additional_information']['title'] = 'Product Data';  // Rename the additional information tab

// Adds the new tab
  $tabs['product_meta_tab'] = array(
    'title'   => __( 'New Product Tab', 'woocommerce' ),
    'callback'  => 'product_meta_tab_content',
  );
  return $tabs;
}

function product_meta_tab_content() {
  global $product;
  ?>
  <table>
    <tbody>
      <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
      <tr>
        <th><?php esc_html_e( 'SKU', 'woocommerce' ); ?></th>
        <td><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></td>
      </tr>
    <?php endif; ?>
    <tr>
      <th><?php echo _n( 'Tag', 'Tags', count( $product->get_tag_ids() ), 'woocommerce' ); ?></th>
      <td><?php echo wc_get_product_tag_list( $product->get_id() ); ?></td>
    </tr>
  </tbody>
</table>
<?php
}

/**
 * Reorder product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {

  $tabs['description']['priority'] = 5;
  $tabs['additional_information']['priority'] = 10;
  $tabs['product_meta_tab']['priority'] = 15;
  $tabs['reviews']['priority'] = 50;     // Reviews last

  return $tabs;
}
