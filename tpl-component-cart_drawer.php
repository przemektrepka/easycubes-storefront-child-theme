<?php
/**
 * Template component: Floating cart drawer
 *
 * @see  tpl-order-home.php
 */

?>


<div id="cartDrawer" class="cart-drawer">
	<div class="cart-drawer--handle" data-toggle="collapse" data-target="#cartDrawerContent"></div>
	<div class="container">
		<div class="panel-heading">
			<div class="row no-gutters">
				<div class="col-5">
					<h4>This is your cart</h4>
				</div>
				<div class="col-7 order-summary-short fade show">
					<div class="row no-gutters aling-items-center justify-content-end ">
						<div class="col align-self-center">
							<span class="text-small"> Total price (Net.) </span>
							<span class="order-cart-price">0</span>
						</div>
						<div class="col order-summary-buttons">
							<div class="row align-items-center">
								<?php
								if (!is_user_logged_in()){
								?>
								<a href="#" class="col btn btn-white"> Register as a dealer </a>
								<button type="button" data-toggle="modal" data-target="#checkoutModal" class="col btn btn-brand btn-order btn-icon"> <i class="fas fa-pallet"></i> Go to checkout</button>
								<?php
								}
								else {
								?>
								<button type="button" data-toggle="modal" data-target="#checkoutModal" class="col btn btn-brand btn-order btn-icon"> <i class="fas fa-pallet"></i> Go to checkout</button>
								<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="cartDrawerContent" class="order-summary-details panel-collapse collapse">
			<div class="row cart-content" style="display: none">
				<div class="col">
					<div class="row">
						<div class="col">
							<span class="col-md-8 order-summary-label"> Amount of Pallets </span>
							<span class="col-md-4 order-summary-bignum order-pallets-ammount"> 0 </span>
						</div>
						<div class="col">
							<span class="col-md-6 order-summary-label"> Spaces Taken </span>
							<span class="col-md-4 order-summary-bignum order-cart-space"> 0 </span>
						</div>
						<div class="col" style="display: none">
							<span class="col-md-8 order-summary-label"> Container Type </span>
							<span class="col-md-4 order-summary-bignum order-container-type"> 0 </span>
						</div>
					</div>
					<div class="row">
					</div>
				</div>

				<div class="col">
					<table class="table table-order-summary ">

						<thead>
							<tr>
								<th>Item</th>
								<th>Variant</th>
								<th>Unit Price</th>
								<th>No. of Units</th>
								<th>No. Pallets</th>
								<th>Item Total</th>
								<th><span class="d-none">Actions</span></th>
							</tr>
						</thead>

						<tbody>

						</tbody>
					</table>
				</div>
			</div>
      <div class="row cart-content-empty">
          <div class="text-center">
              <img src="<?php echo get_stylesheet_directory_uri() ;?>/assets/images/cart-empty-v2.jpg" class="img-responsive"/>
          </div>
      </div>
			<div class="row no-gutters order-summary-bottom justify-content-end">
				<div class="col-7 order-summary-short">
					<div class="row no-gutters aling-items-center justify-content-end ">
						<div class="col align-self-center">
							<span class="text-small"> Total price (Net.) </span>
							<span class="order-cart-price">&euro; 0</span>
						</div>
						<div class="col order-summary-buttons">
							<div class="row align-items-center">
								<?php
								if (!is_user_logged_in()) { ?>
								<p class="col info"><small>This total doesn’t take into account individual dealer rate.</small></p>
								<?php echo '<a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '" class="col btn btn-brand btn-icon btnLogin">Log in</a>';
								} else { ?>
								<button type="button" data-toggle="modal" data-target="#checkoutModal" class="col btn btn-brand btn-order btn-icon"> <i class="fas fa-pallet"></i> Go to checkout</button>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="bootstrap_notify"></div>
</div>
