<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div class="row">
	<div class="col col-4"><h3>Invoice information</h3></div>
	<div class="col col-5">

		<?php //@TODO: Make the following form functional ?>
		<form id="form-delivery-info" class="form-horizontal form-delivery-info" method="post" action="#">

			<div class="form-group">
				<div class="form-row">
					<div class="col">
						<label class="control-label" for="company_name">Company name</label>
						<input type="text" class="form-control" id="cust_company_name" placeholder="Company" name="cust_company_name" required  value="<?php if ($customer) echo $customer->get_billing_company(); ?>">
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="form-row">
					<div class="form-group col">
						<label class="control-label" for="email">Dealer name</label>
						<div class="input-group">
							<input class="form-control" type="text" name="cust_firstname" placeholder="First name" required  value="<?php if ($customer) echo $customer->get_billing_first_name();?>">
							<span class="input-group-addon input-group-separator"></span>
							<input class="form-control" type="text" name="cust_lastname" placeholder="Last name" required  value="<?php if ($customer) echo $customer->get_billing_last_name();?>">
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="form-row">
					<div class="form-group col">
						<label class="control-label" for="exampleInputEmail1">Email address</label>
						<input type="email" name="cust_email" class="form-control" id="cust_email" aria-describedby="emailHelp" required  placeholder="Enter email" value="<?php if ($customer) echo $customer->get_billing_email() ; ?>">
					</div>
				</div>
				<div class="pt-2 form-row">
					<div class="form-group col">
						<label class="control-label" for="phone">Phone number</label>
						<input type="tel" class="form-control" id="cust_phone" placeholder="Enter phone" name="cust_phone" required  value="<?php if ($customer) echo $customer->get_billing_phone();?>">
					</div>
				</div>
			</div>

			<div class="form-group address">
				<div class="form-row">
					<div class="form-group col">
						<label class="control-label" for="street-address">Address</label>
						<input type="text" class="form-control" id="cust_street_address" placeholder="Street address" name="cust_street_address" required value="<?php if ($customer) echo $customer->get_billing_address();?>">
						<div class="pt-2 pb-2 input-group">
							<input class="form-control" type="text" name="cust_city" placeholder="City" required value="<?php if ($customer) echo $customer->get_billing_city();?>">
							<span class="input-group-addon input-group-separator"></span>
							<input class="form-control" type="text" name="cust_pobox" id="cust_pobox" placeholder="P.O. box" required  value="<?php if ($customer) echo $customer->get_billing_postcode();?>">
						</div>
						<input type="text" class="form-control" id="cust_country" placeholder="Country" name="cust_country" required  value="<?php if ($customer) echo $customer->get_billing_country();?>">
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="form-row">
					<div class="form-group col">
						<label class="control-label" for="vatno">VAT Number</label>
						<input type="text" class="form-control" id="cust_vatno" placeholder="VAT Number" name="cust_vatno"  required  value="<?php if ($customer) echo get_field( 'vat_number', wp_get_current_user()->ID );?>">
					</div>
				</div>
			</div>

			<div class="pt-2">
				<button type="submit" class="btn btn-brand btn-lg" name="save_invoice" value="Save invoice information">Save invoice information</button>
			</div>
		</form>

	</div>
</div>

<div class="row-seperator"></div>

<form action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<div class="row">
		<div class="col col-4"> <h3>User info</h3> </div>
		<div class="col col-5">
			<div class="form-row">
				<div class="form-group col">
					<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?></label>
					<input type="text" class="form-control" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" required />
				</div>
				<div class="form-group col">
					<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?></label>
					<input type="text" class="form-control" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" required />
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?></label>
					<input type="email" class="form-control" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" required/>
				</div>
			</div>
		</div>
	</div>

	<div class="row pt-5">
		<div class="col col-4">
			<h4><?php esc_html_e( 'Password change', 'woocommerce' ); ?></h4>
		</div>
		<div class="col col-5">
			<div class="form-row">
				<div class="form-group col">
					<label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
				</div>
			</div>

			<div class="pt-5">
				<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
				<button type="submit" class="btn btn-brand btn-lg" name="save_account_details" value="Save user info">Save user info</button>
				<input type="hidden" name="action" value="save_account_details" />
			</div>
		</div>
	</div>
</form>

<?php do_action( 'woocommerce_edit_account_form' ); ?>

<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
