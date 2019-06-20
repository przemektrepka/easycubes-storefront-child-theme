<?php
/**
 * Template component: Checkout modal
 *
 * @see  tpl-order-home.php
 */

?>

<div id="cart-shipping">
  <div class="row">
    <div class="col col-3">
      <div class="d-flex justify-content-between">
        <h3 class="shipping-panel-title">Invoice information</h3>

        <?php
        if ( is_user_logged_in() ){
          ?>
          <a href="my-account/edit-account/" class="textcolor--g4"><i class="fas fa-edit"></i> Edit your info</a>
          <?php
        } else if ( !is_user_logged_in() ){
          ?>
          <a href="my-account/edit-account/" class="textcolor--g4"><i class="fas fa-sign-in-alt"></i> Sign in</a>
          <?php
        }
        ?>
      </div>

      <form id="form-delivery-info" class="form-horizontal form-delivery-info" method="post" action="#">

        <div class="form-group">
          <div class="form-row">
            <label class="col-3 control-label" for="company_name">Company name</label>
            <div class="col">
              <input type="text" class="form-control" id="cust_company_name" placeholder="Company" name="cust_company_name" required  value="<?php if ($customer)echo $customer->get_billing_company(); ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <label class="col-3 control-label" for="email">Dealer name</label>

            <div class="col input-group">
              <input class="form-control" type="text" name="cust_firstname" placeholder="First name" required  value="<?php if ($customer) echo $customer->get_billing_first_name();?>">
              <span class="input-group-addon input-group-separator"></span>
              <input class="form-control" type="text" name="cust_lastname" placeholder="Last name" required  value="<?php if ($customer)echo $customer->get_billing_last_name();?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <label class="col-3 control-label" for="exampleInputEmail1">Email address</label>
            <div class="col">
              <input type="email" name="cust_email" class="form-control" id="cust_email" aria-describedby="emailHelp" required  placeholder="Enter email" value="<?php if ($customer)echo $customer->get_billing_email() ; ?>">
            </div>
          </div>
          <div class="pt-2 form-row">
            <label class="col-3 control-label" for="phone">Phone number</label>
            <div class="col">
              <input type="tel" class="form-control" id="cust_phone" placeholder="Enter phone" name="cust_phone" required  value="<?php if ($customer)echo $customer->get_billing_phone();?>">
            </div>
          </div>
        </div>

        <div class="form-group address">
          <div class="form-row">
            <label class="col-3 control-label" for="street-address">Address</label>
            <div class="col">
              <input type="text" class="form-control" id="cust_street_address" placeholder="Street address" name="cust_street_address" required value="<?php if ($customer)echo $customer->get_billing_address();?>">
              <div class="pt-2 pb-2 input-group">
                <input class="form-control" type="text" name="cust_city" placeholder="City" required value="<?php if ($customer)echo $customer->get_billing_city();?>">
                <span class="input-group-addon input-group-separator"></span>
                <input class="form-control" type="text" name="cust_pobox" id="cust_pobox" placeholder="P.O. box" required  value="<?php if ($customer)echo $customer->get_billing_postcode();?>">
              </div>
              <input type="text" class="form-control" id="cust_country" placeholder="Country" name="cust_country" required  value="<?php if ($customer)echo $customer->get_billing_country();?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <label class="col-3 control-label" for="vatno">VAT NO.</label>
            <div class="col">
              <input type="text" class="form-control" id="cust_vatno" placeholder="VAT Number" name="cust_vatno"  required  value="<?php if ($customer) echo get_field( 'vat_number', wp_get_current_user()->ID );?>">
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="col col-seperator"></div>

    <div class="col col-3">
      <h3 class="shipping-panel-title">Shipping</h3>

      <form id="form-shipping-method" class="form-shipping-method">
        <div class="form-group">
          <div class="form-row">
            <label class="col-3 control-label" for="shipping-method">Pick a method</label>
            <div class="col">
              <select id="shipping-method" class="form-control select-tabs" name="shipping-method">
                <option data-target='#ship-to-dealer' value="ship-to-dealer">Ship to me</option>
                <option data-target='#ship-to-address' value="ship-to-address">Ship to address</option>
                <option data-target="#self-pick" value="ship-to-pickup">Self pickup</option>
              </select>
            </div>
          </div>
        </div>
      </form>
      <div class="tab-content">

        <!-- Ship to dealer -->
        <div class="tab-pane fade show active" id="ship-to-dealer">
          <h4 class="pt">Ship to dealer</h4>
          <form id="form-shipping-dealer" class="form-shipping-dealer">
            <div class="form-group address">
              <div class="form-row">
                <label class="col-3 control-label" for="street-address">Address</label>
                <div class="col">
                  <input type="text" class="form-control" id="std-street-address" placeholder="Street address" name="std-street-address"  value="<?php if ($customer)echo $customer->get_billing_address();?>">
                  <div class="pt-2 pb-2 input-group">
                    <input class="form-control" type="text" name="std-city" id="std-city" placeholder="City"  value="<?php if ($customer)echo $customer->get_billing_city();?>">
                    <span class="input-group-addon input-group-separator"></span>
                    <input class="form-control" type="text" name="std-pobox" id="std-pobox" placeholder="P.O. box"  value="<?php if ($customer)echo $customer->get_billing_postcode();?>">
                  </div>
                  <input type="text" class="form-control" id="std-country" placeholder="Country" name="std-country"  value="<?php if ($customer)echo $customer->get_billing_country();?>">
                </div>
              </div>
            </div>

            <div class="form-group ship-date">
              <div class="form-row">
                <label class="col-3 control-label" for="street-address">Shipping date</label>
                <div class="col">
                  <div class="input-group date flex-nowrap">
                    <div class="input-group-prepend input-group-addon">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control shipDate" name="std-shipdate">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>


        <!-- Ship to an address -->
        <div class="tab-pane fade" id="ship-to-address">
          <h4 class="pt">Ship to an address</h4>
          <form id="form-shipping-address" class="form-shipping-address">
            <div class="form-group receiver">
              <div class="form-row">
                <label class="col-3 control-label" for="rName">Receiver</label>

                <div class="col input-group">
                  <input class="form-control" type="text" name="sta-name" placeholder="First name" value="<?php if ($customer)echo $customer->get_shipping_first_name();?>">
                  <span class="input-group-addon input-group-separator"></span>
                  <input class="form-control" type="text" name="sta-surname" placeholder="Last name" value="<?php if ($customer)echo $customer->get_shipping_last_name();?>">
                </div>
              </div>

              <div class="pt-2 form-row">
                <label class="col-3 control-label" for="rEmail">Email</label>
                <div class="col">
                  <input type="email" class="form-control" id="sta-email" name="sta-email" aria-describedby="emailHelp" placeholder="Enter email" value="<?php if ($customer)echo $customer->get_billing_email();?>">
                </div>
              </div>
              <div class="pt-2 form-row">
                <label class="col-3 control-label" for="rPhone">Phone number</label>
                <div class="col">
                  <input type="tel" class="form-control" id="sta-phone" placeholder="Enter phone" name="sta-phone" value="<?php if ($customer)echo $customer->get_billing_phone();?>">
                </div>
              </div>
            </div>

            <div class="form-group address">
              <div class="form-row">
                <label class="col-3 control-label" for="street-address">Address</label>
                <div class="col">
                  <input type="text" class="form-control" id="sta-street-address" placeholder="Street address" name="sta-street-address" value="<?php if ($customer)echo $customer->get_shipping_address();?>">
                  <div class="pt-2 pb-2 input-group">
                    <input class="form-control" type="text" name="sta-city" id="sta-city" placeholder="City" value="<?php if ($customer)echo $customer->get_shipping_city();?>">
                    <span class="input-group-addon input-group-separator"></span>
                    <input class="form-control" type="text" name="sta-pobox" id="sta-city" placeholder="P.O. box" value="<?php if ($customer)echo $customer->get_shipping_postcode();?>">
                  </div>
                  <input type="text" class="form-control" id="sta-country" placeholder="Country" name="sta-country" value="<?php if ($customer)echo $customer->get_shipping_country();?>">
                </div>
              </div>
            </div>

            <div class="form-group ship-date">
              <div class="form-row">
                <label class="col-3 control-label" for="shipDate">Shipping date</label>
                <div class="col">
                  <div class="input-group date flex-nowrap">
                    <div class="input-group-prepend input-group-addon">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control shipDate" name="sta-shipdate">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>

        <!-- Self pickup -->
        <div class="tab-pane fade" id="self-pick">
          <h4 class="pt">Self pickup</h4>
          <form id="form-shipping-pickup" class="form-shipping-pickup">
            <div class="form-group ship-date">
              <div class="form-row">
                <label class="col-3 control-label" for="street-address">Pickup date</label>
                <div class="col">
                  <div class="input-group date flex-nowrap">
                    <div class="input-group-prepend input-group-addon">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control shipDate" name="stp-shipdate">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>

      </div>

      <div class="form-horizontal form-shipping-info">

      </div>
    </div>

    <div class="col col-seperator"></div>

    <div class="col">
      <h3 class="shipping-panel-title">
        Order summary
      </h3>
      <p class="textcolor--g3 pt-0 d-flex">
        <i class="fas fa-exclamation-circle textcolor--blue pt-1"></i>
        <span class="pl-2">
          Note that the custom color cubes, <strong class="min-shipping-days"> require a minimum of 3 weeks production before shipping.</strong>
          <br><span class="textcolor--blue">This order is estamated to be ready on <strong class="min-shipping-date">June 15th 2019</strong>.</span>
        </span>
      </p>

      <table class="table table-order-summary ">

        <thead>
          <tr>
            <th>Item</th>
            <th>Variant</th>
            <th>Discounted Unit Price</th>
            <th>No. of Units</th>
            <th>No. Pallets</th>
            <th>Discounted Item Total</th>
            <th><span>Actions</span></th>
          </tr>
        </thead>

        <tbody>

        </tbody>
      </table>

      <p>
        <span class="text-small"> Total Price <small>(Net.)</small> </span>
        <span class="order-cart-price">&euro; 0</span>
      </p>

      <form id="form-total-notes" class="form-total-notes">
        <div class="form-group">
          <div class="form-row">
            <label class="col-12 control-label text-left py-2" for="company_name">Notes</label>
            <div class="col">
              <textarea class="form-control p-2" placeholder="Type any note regarding the order" name="order_notes" id="order_notes" ></textarea>
            </div>
          </div>
        </div>
        <input type="hidden" name="action" value="sitefront_make_order"/>
        <?php wp_nonce_field( 'make_order', 'make_order_nonce' ); ?>
      </form>
    </div>
  </div>
