<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details">

	<?php if ( $show_shipping ) : ?>

	<section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
		<div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-6">

            <?php endif; ?>

            <h2 class="woocommerce-column__title"><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h2>

            <address>
                <?php echo wp_kses_post( $order->get_formatted_billing_address( __( 'N/A', 'woocommerce' ) ) ); ?>
                <?php if ( $order->get_meta('billing-vat-id') ) : ?>
                    <p class="woocommerce-customer-details--vat">VAT # <?php echo esc_html( $order->get_meta('billing-vat-id') ); ?></p>
                <?php endif; ?>
                <?php if ( $order->get_billing_phone() ) : ?>
                    <p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
                <?php endif; ?>

                <?php if ( $order->get_billing_email() ) : ?>
                    <p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
                <?php endif; ?>
            </address>

            <?php if ( $show_shipping ) : ?>

		</div><!-- /.col-1 -->

		<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-6">
			<h2 class="woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>
			<address>
				<?php echo wp_kses_post( $order->get_formatted_shipping_address( __( 'N/A', 'woocommerce' ) ) ); ?>
                <p class="woocommerce-customer-details--phone"><?php echo $order->get_meta('shipping-phone') ;?></p>
                <p class="woocommerce-customer-details--email"><?php echo $order->get_meta('shipping-email') ;?></p>

            </address>
            <div class="form-row">
                <label class="col-12 control-label" for="shipping-method"><strong>Shipping method</strong></label>
                <div class="offset-7 col-5">
                    <select id="shipping-method" class="form-control select-tabs" name="shipping-method">
                        <option data-target='#ship-to-dealer' value="ship-to-dealer" <?php echo $order->get_meta('pickup-method')== "ship-to-dealer"?"selected":""; ?>>Ship to me</option>
                        <option data-target='#ship-to-address' value="ship-to-address" <?php echo $order->get_meta('pickup-method')== "ship-to-address"?"selected":""; ?>>Ship to address</option>
                        <option data-target="#self-pick" value="ship-to-pickup" <?php echo $order->get_meta('pickup-method')== "ship-to-pickup"?"selected":""; ?>>Self pickup</option>
                    </select>
                    <p class="woocommerce-customer-details--date">
                        <label class="col-12 control-label" for="shipping-method"><strong>Shipping Date</strong></label>
                        <em class="col-12"><?php echo $order->get_meta('pickup-date') ;?></em>
                    </p>
                </div>
            </div>
		</div><!-- /.col-2 -->

	</section><!-- /.col2-set -->

	<?php endif; ?>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
