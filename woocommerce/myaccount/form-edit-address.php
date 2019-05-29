<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

$page_title = ( 'billing' === $load_address ) ? __( 'Billing address', 'woocommerce' ) : __( 'Shipping address', 'woocommerce' );

// define the woocommerce_before_edit_account_address_form callback
function before_edit_address_form(  ) {
	?>
	<div class="container">
		<?php
	};

// define the woocommerce_after_edit_account_address_form callback
	function after_edit_address_form(  ) {
		?>
	</div>
	<?php
};

// add the actions
add_action( 'woocommerce_before_edit_account_address_form', 'before_edit_address_form', 10, 0 );
add_action( 'woocommerce_after_edit_account_address_form', 'after_edit_address_form', 10, 1 );
?>

<?php do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
	<?php else : ?>

		<form method="post">
			<div class="row">

				<div class="col-3"><h3><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h3><?php // @codingStandardsIgnoreLine ?></div>

				<div class="col woocommerce-address-fields">
					<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

					<div class="woocommerce-address-fields__field-wrapper">
						<?php
						foreach ( $address as $key => $field ) {
							woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
						}
						?>
					</div>

					<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

				</div>

			</div>
			<div class="row pt-3 justify-content-end">
				<button type="submit" class="btn btn-brand btn-lg" name="save_address" value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>"><?php esc_html_e( 'Save address', 'woocommerce' ); ?></button>
				<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
				<input type="hidden" name="action" value="edit_address" />
			</div>
		</form>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
