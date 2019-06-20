<?php

class AjaxHandler{

    /**
     * AjaxHandler constructor.
     */
    public function __construct()
    {
        include get_stylesheet_directory() . '/inc/ecorder.config.php';
    }

    public function getCartCookie(){
        return $GLOBALS['cartCookieName'];
    }


    public function sitefront_add_to_cart()
    {
       $result = array();
       $total_pallets = 0;
       $space_taken = 0;
       $total_processing_days = 0;
       $products = array();
       $redunant_cat = array();
        set_current_user(get_current_user_id());
       if (isset($_POST['product_id']) && isset($_POST['quantity']))
       {
           $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $_POST['product_id'], $_POST['quantity']);
           $product_status = get_post_status($_POST['product_id']);
           $cart_item_key = $this->get_cart_key($_POST['product_id']);
           if ($_POST['quantity'] != 0)
           {
               if ($passed_validation && 'publish' === $product_status) {
                   try{


                       if ($cart_item_key !=null)
                       {
                           WC()->cart->remove_cart_item($cart_item_key);
                       }

                       if (WC()->cart->add_to_cart($_POST['product_id'],$_POST['quantity']))
                       {
                           $result['wc_add'] = 1;
                       }

                   }
                   catch (Exception $exception)
                   {
                       $result['wc_add'] = 0;
                   }

               }
               else
               {
                   $result['wc_add'] = 0;
               }
           }
           else{
               try{

                    if ($cart_item_key !=null)
                    {
                        WC()->cart->remove_cart_item($cart_item_key);
                        $result['wc_remove'] = 1;
                    }
               }
               catch (Exception $exception)
               {
                   $result['wc_remove'] = 0;
               }
           }

           $this->ec_apply_mega_calculation();
           foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
               $the_product = wc_get_product($cart_item['product_id']);
               set_current_user(get_current_user_id());
               if ($the_product) {


                   array_push($products,array(
                       'product_id' => $cart_item['product_id'],
                       'quantity' => $cart_item['quantity'],
                       'space_consumes' => get_field('space_takes_per_pallet',$the_product->get_id()) * $cart_item['quantity'],
                       'item_type' => get_the_terms( $cart_item['product_id'], 'product_cat' )[0]->name,
                       'variant' => $the_product->get_title(),
                       'price'   => (int)$cart_item['data']->get_price(),
                       'processing_time' => $GLOBALS['def_shipping_class'][$the_product->get_shipping_class()],
                       'total_price'   => (int)$cart_item['line_subtotal'],
                   ));

                   if (!in_array($the_product->get_category_ids()[0],$redunant_cat))
                   {
                       $total_processing_days += $GLOBALS['def_shipping_class'][$the_product->get_shipping_class()];
                       array_push($redunant_cat,$the_product->get_category_ids()[0]);
                   }

                   $total_pallets+= $cart_item['quantity'];
                   $space_taken+= get_field('space_takes_per_pallet',$the_product->get_id()) * $cart_item['quantity'];

               }

           }



           $result['products'] = $products;
           $result['net_price'] = WC()->cart->get_cart_contents_total();
           $result['total_pallets'] = $total_pallets;
           $result['cart_space'] = $space_taken;
           $result['min_shipping_days'] = $total_processing_days;
           $result['min_shipping_date'] = Date('M dS, Y', strtotime("+".$total_processing_days." days"));


       }
       else
       {
           $result['products'] = $products;
           $result['net_price'] = 0;
           $result['total_pallets'] = $total_pallets;
           $result['cart_space'] = $space_taken;
           $result['min_shipping_days'] = $total_processing_days;
           $result['min_shipping_date'] = null;
       }
        echo json_encode($result);
        wp_die();
        return;

    }

    public function populate_cart_data()
    {
        $products = array();
        $result = array();
        $net_price = 0;
        $total_pallets = 0;
        $space_taken = 0;
        $total_processing_days = 0;
        $redunant_cat = array();

        set_current_user(get_current_user_id());
        $this->ec_apply_mega_calculation();
        if (WC()->cart->get_cart_contents_count() > 0){

            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

                $the_product = wc_get_product($cart_item['product_id']);

                if ($the_product) {
                    array_push($products,array(
                        'product_id' => $cart_item['product_id'],
                        'quantity' => $cart_item['quantity'],
                        'space_consumes' => get_field('space_takes_per_pallet',$the_product->get_id()) * $cart_item['quantity'],
                        'item_type' => get_the_terms( $cart_item['product_id'], 'product_cat' )[0]->name,
                        'variant' => $the_product->get_title(),
                        'price'   => (int)$cart_item['data']->get_price(),
                        'processing_time' => $GLOBALS['def_shipping_class'][$the_product->get_shipping_class()],
                        'total_price'   => (int)$cart_item['line_subtotal'],
                    ));

                    if (!in_array($the_product->get_category_ids()[0],$redunant_cat))
                    {
                        $total_processing_days += $GLOBALS['def_shipping_class'][$the_product->get_shipping_class()];
                        array_push($redunant_cat,$the_product->get_category_ids()[0]);
                    }


                    $total_pallets+= $cart_item['quantity'];
                    $space_taken+= get_field('space_takes_per_pallet',$the_product->get_id()) * $cart_item['quantity'];

                }
            }
            $result['products'] = $products;
            $result['net_price'] =  WC()->cart->get_cart_contents_total();
            $result['total_pallets'] = $total_pallets;
            $result['cart_space'] = $space_taken;
            $result['min_shipping_days'] = $total_processing_days;
            $result['min_shipping_date'] = Date('M dS, Y', strtotime("+".$total_processing_days." days"));

        }
        else{
            $result['products'] = $products;
            $result['net_price'] = $net_price;
            $result['total_pallets'] = $total_pallets;
            $result['cart_space'] = $space_taken;
        }


        echo json_encode($result);
        wp_die();
        return;
    }

    public function get_cart_key($product_id)
    {
        $ret_cart_item_key = null;

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

            if($cart_item['product_id'] == $product_id ){
                $ret_cart_item_key = $cart_item_key;
            }
        }

        return $ret_cart_item_key;
    }

    private function ec_apply_mega_calculation()
    {

        // var_dump(WC()->cart->get_cart());
        //var_dump((new MegaWooDiscountsModel())->get_all_product_rules());
        foreach ( WC()->cart->get_cart() as $cart_item ) {

            foreach ((new MegaWooDiscountsModel())->get_all_product_rules() as $rKey => $rule)
            {
                if ($rule['type'] == 'mega_product_rule' && $rule['status'] == '1')
                {
                    $tmpItem = false;
                    $tmpCond = false;

                    if (is_array($rule['condsArr'][0]))
                    {
                        foreach ($rule['condsArr'][0] as $key => $item)         //If not empty then iterate through the conditions
                        {
                            foreach ($item['selectedVal'] as $cVal)        //Iterate through the values
                            {
                                switch ($item['selectedItem']){             //Check the item matching base
                                    case 'cust_uid':
                                        if ($item['selectedList'] == "12")           //Check the operator is equal or not equal
                                        {
                                            if ($cVal['id'] == wp_get_current_user()->user_login) $tmpCond = true;
                                        }
                                        else if ($item['selectedList'] == "14")
                                        {
                                            if ($cVal['id'] != wp_get_current_user()->user_login) $tmpCond = true;
                                        }
                                       break;
                                }
                            }
                        }
                    }
                    else{
                        $tmpCond = true;
                    }

                     if (is_array($rule['itemsArr'][0]))            //Check if the item is empty or not, non empty will contain an array
                     {
                        foreach ($rule['itemsArr'][0] as $key => $item)         //If not empty then iterate through the product items
                        {
                            foreach ($item['selectedVal'] as $sVal)        //Iterate through the values
                            {

                                if ($item['selectedList'] == "equal")           //Check the operator is equal or not equal
                                {
                                    switch ($item['selectedItem']){             //Check the item matching base
                                        case 'prod':
                                            if ((int)$sVal['id'] == (int)$cart_item['product_id']) $tmpItem = true;
                                            break;
                                    }

                                }
                                else{
                                    switch ($item['selectedItem']){
                                        case 'prod':
                                            if ((int)$sVal['id'] != (int)$cart_item['product_id']) $tmpItem = true;
                                            break;
                                    }

                                }
                                //Equalizer ends

                            }
                        }
                     }
                     else{
                        $tmpItem = true;
                     }

                     if ($tmpItem == true && $tmpCond == true)
                     {
                        if( $rule['disc_method'] == "simple" ) {
                            $the_product = wc_get_product($cart_item['product_id']);
                            switch ($rule['disc_type'])
                            {
                                case 'fd':          //Fixed Discount
                                    $price = (int)$the_product->get_price() - $rule['disc_value'];
                                    $cart_item['data']->set_price($price);
                                    $cart_item['mega_prod_data']['reg_price'] = $price;
                                    $cart_item['mega_prod_data']['woo_price'] = $price;
                                    break;
                                case 'pd':          //Percent Discount

                                    $price = (int)$the_product->get_price() - (($rule['disc_value']/$cart_item['data']->get_price()) * 100);
                                    $cart_item['data']->set_price($price);
                                    $cart_item['mega_prod_data']['reg_price'] = $price;
                                    $cart_item['mega_prod_data']['woo_price'] = $price;

                                    break;
                                case 'ff':          //Fixed Fee
                                    $price = (int)$the_product->get_price() + $rule['disc_value'];
                                    $cart_item['data']->set_price($price);
                                    $cart_item['mega_prod_data']['reg_price'] = $price;
                                    $cart_item['mega_prod_data']['woo_price'] = $price;
                                    break;
                                case 'pf':          //Percent Fee

                                    $price = (int)$the_product->get_price() + (($rule['disc_value']/$cart_item['data']->get_price()) * 100);
                                    $cart_item['data']->set_price($price);
                                    $cart_item['mega_prod_data']['reg_price'] = $price;
                                    $cart_item['mega_prod_data']['woo_price'] = $price;
                                    break;
                                default:            //fp : Fixed Price
                                    $cart_item['data']->set_price($rule['disc_value']);
                                    $cart_item['mega_prod_data']['reg_price'] = $rule['disc_value'];
                                    $cart_item['mega_prod_data']['woo_price'] = $rule['disc_value'];
                                    break;
                            }

                            WC()->cart->calculate_totals();

                            //var_dump(WC()->cart->get_cart());
                        }
                     }


                }
            }
        }


    }


    public function make_order()
    {
        $ret = array();
        $nonce_value = wc_get_var( $_REQUEST['make_order_nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.
        $customer = null;
        global $woocommerce;
        if (wp_verify_nonce( $nonce_value, 'make_order' ) ) {

            if (is_user_logged_in()) {
                try {
                    $customer = new WC_Customer(get_current_user_id());
                } catch (Exception $exception) {
                    $ret['res'] = "error";
                    $ret['error'] = "Invalid CUSTOMER";
                }
            }
            else{

            }

            if(isset($_POST['cust_company_name'],$_POST['cust_firstname'],$_POST['cust_lastname'],$_POST['cust_email'],$_POST['cust_phone'],$_POST['cust_street_address'],$_POST['cust_city'],$_POST['cust_pobox'],$_POST['cust_country'],$_POST['cust_vatno']))
            {
               // $ret['res'] = "success";
               // $ret['success'] = "Delivery Info Verified";


                if(isset($_POST['shipping-method'])){
                    $billing_address = array(
                        'first_name' => $_POST['cust_firstname'],
                        'last_name'  => $_POST['cust_lastname'],
                        'company'    => $_POST['cust_company_name'],
                        'email'      => $_POST['cust_email'],
                        'phone'      => $_POST['cust_phone'],
                        'address_1'    => $_POST['cust_street_address'],
                        'city'       => $_POST['cust_city'],
                        'state'      => $_POST['cust_firstname'],
                        'postcode'   => $_POST['cust_pobox'],
                        'country'    => $_POST['cust_firstname']
                    );

                    switch ($_POST['shipping-method'])
                    {
                        case "ship-to-dealer":
                            if (isset($_POST['std-street-address'],$_POST['std-city'],$_POST['std-pobox'],$_POST['std-country'],$_POST['std-shipdate']))
                            {
                                $shipping_address = array(
                                    'first_name' => $_POST['cust_firstname'],
                                    'last_name'  => $_POST['cust_lastname'],
                                    'company'    => $_POST['cust_company_name'],
                                    'address_1'    => $_POST['std-street-address'],
                                    'city'       => $_POST['std-city'],
                                    'postcode'   => $_POST['std-pobox'],
                                    'country'    => $_POST['std-country']
                                );

                                $cart = WC()->cart;
                                $checkout = WC()->checkout();
                                $order_id = $checkout->create_order();
                                $order = wc_get_order( $order_id );

                                $order->set_address($billing_address,'billing');
                                $order->set_address($shipping_address,'shipping');


                                $order->add_meta_data('pickup-method',$_POST['shipping-method']);
                                $order->add_meta_data('pickup-date',$_POST['std-shipdate']);
                                $order->add_meta_data('billing-vat-id',$_POST['cust_vatno']);

                                $order->set_customer_ip_address(WC_Geolocation::get_ip_address());
                                if (isset($_POST['order_notes'])) $order->set_customer_note($_POST['order_notes']);
                                $shipping = new WC_Shipping_Rate('','Ship to dealer');
                                $order->add_shipping( $shipping );


                                $order->calculate_totals();
                                $order->save();
                                $cart->empty_cart();
                                $ret['res'] = "success";
                                $ret['success'] = "Order success";
                                $ret['order_id'] = $order_id;

                            }
                            else
                            {
                                $ret['res'] = "error";
                                $ret['error'] = "Invalid SHIPPING-METHOD-DATA";
                            }
                            break;
                        case "ship-to-address":
                            if (isset($_POST['sta-name'],$_POST['sta-surname'],$_POST['sta-email'],$_POST['sta-phone'],$_POST['sta-street-address'],$_POST['sta-city'],$_POST['sta-pobox'],$_POST['sta-country'],$_POST['sta-shipdate']))
                            {
                                $shipping_address = array(
                                    'first_name' => $_POST['sta-name'],
                                    'last_name'  => $_POST['sta-surname'],
                                    'company'    => $_POST['cust_company_name'],
                                    'address_1'    => $_POST['sta-street-address'],
                                    'city'       => $_POST['sta-city'],
                                    'postcode'   => $_POST['sta-pobox'],
                                    'country'    => $_POST['sta-country']
                                );

                                $cart = WC()->cart;
                                $checkout = WC()->checkout();
                                $order_id = $checkout->create_order();
                                $order = wc_get_order( $order_id );

                                $order->set_address($billing_address,'billing');
                                $order->set_address($shipping_address,'shipping');


                                $order->add_meta_data('shipping-email',$_POST['sta-email']);
                                $order->add_meta_data('shipping-phone',$_POST['sta-phone']);

                                $order->add_meta_data('pickup-method',$_POST['shipping-method']);
                                $order->add_meta_data('pickup-date',$_POST['sta-shipdate']);
                                $order->add_meta_data('billing-vat-id',$_POST['cust_vatno']);

                                $order->set_customer_ip_address(WC_Geolocation::get_ip_address());
                                if (isset($_POST['order_notes'])) $order->set_customer_note($_POST['order_notes']);
                                $shipping = new WC_Shipping_Rate('','Ship to an address');

                                $order->add_shipping( $shipping );


                                $order->calculate_totals();
                                $order->save();
                                $cart->empty_cart();
                                $ret['res'] = "success";
                                $ret['success'] = "Order success";
                                $ret['order_id'] = $order_id;
                            }
                            else
                            {
                                $ret['res'] = "error";
                                $ret['error'] = "Invalid SHIPPING-METHOD-DATA";
                            }
                            break;
                        case "ship-to-pickup":
                            if (isset($_POST['stp-shipdate']))
                            {
                                $cart = WC()->cart;
                                $checkout = WC()->checkout();
                                $order_id = $checkout->create_order();
                                $order = wc_get_order( $order_id );
                                update_post_meta($order_id, '_customer_user', get_current_user_id());
                                $order->set_address($billing_address,'billing');

                                $order->add_meta_data('pickup-method',$_POST['shipping-method']);
                                $order->add_meta_data('pickup-date',$_POST['stp-shipdate']);
                                $order->add_meta_data('billing-vat-id',$_POST['cust_vatno']);

                                if (isset($_POST['order_notes'])) $order->set_customer_note($_POST['order_notes']);

                                $order->calculate_totals();
                                $order->save();
                                $cart->empty_cart();
                                $ret['res'] = "success";
                                $ret['success'] = "Order success";
                                $ret['order_id'] = $order_id;

                            }
                            else
                            {
                                $ret['res'] = "error";
                                $ret['error'] = "Invalid SHIPPING-METHOD-DATA";
                            }
                            break;
                        default:
                            $ret['res'] = "error";
                            $ret['error'] = "Invalid SHIPPING-METHOD";
                            break;

                    }
                }
                else{
                    $ret['res'] = "error";
                    $ret['error'] = "Invalid SHIPPING-METHOD";
                }

            }
            else{
                $ret['res'] = "error";
                $ret['error'] = "Invalid POST-DATA";
            }




        }
        else
        {
            $ret['res'] = "error";
            $ret['error'] = "Invalid REQUEST";
        }

        echo json_encode($ret);
        wp_die();
    }
}
