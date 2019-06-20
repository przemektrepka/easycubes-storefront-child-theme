<?php
/*
 * Template Name: Wholesale Shop Homepage
 */

get_header();


$customer = null;
if (in_array('customer',wcmo_get_current_user_roles()))
{
	try{
		$customer = new WC_Customer(get_current_user_id());
	}
	catch (Exception $exception)
	{

	}

}


?>

<!-- Start page container -->
<div class="container-fluid">

	<!-- Start page content -->
	<div class="content-area">
		<!-- Start Blocks content -->
		<?php echo get_post()->post_content; ?>
		<!-- End of Blocks content -->

		<div class='bs_notify notifications top-left'></div>
		<div class="tab-content">

			<?php do_action( 'storefront_child_print_products',"cart-products" ); ?>

			<?php include 'tpl-component-confirmation.php' ?>

		</div>
	</div>
	<!-- End page content -->

	<!-- Start cart drawer -->
	<?php include 'tpl-component-cart_drawer.php'; ?>
	<!-- End order cart drawer -->

	<!-- Start checkout modal -->
	<div id="checkoutModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-checkout" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><span class="type-light small">EasyCubes&reg; Wholesale Shop.</span> Order checkout.</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php include 'tpl-component-checkout.php' ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Back to products</button>
					<button type="button" class="btn btn-brand px-4"> <i class="fas fa-handshake pr-1"></i> Make the order</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End checkout modal -->

	<?php get_footer(); ?>
