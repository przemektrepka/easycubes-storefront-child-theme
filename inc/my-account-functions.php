<?php

/**
 *My Account Page
 */

add_action( 'wp_loaded', 'woocommerce_process_login_mod' ,10); // Modified on login hook using only email address
add_action( 'wp_loaded', 'woocommerce_process_login_mod_verify' ,10); // verifies the created hash and authenticates an user
add_action( 'woocommerce_save_account_details', 'woocommerce_save_account_fields' ); // Save custom WC account field



function woocommerce_save_account_fields( $customer_id ) {

    if (isset($_POST['account_vat']))
    {
        if ($customer_id)
        {
            update_field('vat_number',$_POST['account_vat'],$customer_id);
        }
    }

}
