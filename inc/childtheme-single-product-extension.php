<?php

add_action( 'woocommerce_single_product_summary', 'show_attr_in_prod_summary', 31 );

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
 * Add a custom product data tab
 */
add_filter( 'woocommerce_product_tabs', 'edit_product_tabs' );
function edit_product_tabs( $tabs ) {

  $tabs['description']['title'] = 'More Information';   // Rename the description tab
  $tabs['additional_information']['title'] = 'Product Data';  // Rename the additional information tab

// Adds the new tab
  $tabs['product_meta_tab'] = array(
    'title'   => __( 'New Product Tab', 'woocommerce' ),
    'priority'  => 50,
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
