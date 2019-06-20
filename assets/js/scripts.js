var curCart = null;
var validatorDeliveryInfo = null;
var validatorShippingDealer = null;
var validatorShippingAddress = null;
var validatorShippingPickup = null;
$(document).ready(function () {

    validateForms();    //Init Form Validators

    // Use select to change shipping methods
    $('select.select-tabs').on('change', function () {
        $('option').removeClass('active');
        $(':selected', this).tab('show').addClass('active');
    });


    // Track progress Start
    // if ( $('#progressShipping').hasClass('active') || $('#progressConfirm').hasClass('active') ) {
    //     $('#progressProducts').addClass('done');
    // } else {
    //     $('#progressProducts').removeClass('done');
    // }

    // if ( $('#progressConfirm').hasClass('active') ) {
    //     $('#progressShipping').addClass('done')
    // } else {
    //     $('#progressShipping').removeClass('done');
    // }

    // $(document).bind('DOMSubtreeModified', function () {
    //     if ( $('#progressShipping').hasClass('active') || $('#progressConfirm').hasClass('active') ) {
    //         $('#progressProducts').addClass('done');
    //     } else {
    //         $('#progressProducts').removeClass('done');
    //     }

    //     if ( $('#progressConfirm').hasClass('active') ) {
    //         $('#progressShipping').addClass('done')
    //     } else {
    //         $('#progressShipping').removeClass('done');
    //     }
    // });
    // Track progress End



        //Reject order progress clicks if disabled
    $("#list-order-progress > a").on('click',function (e) {
        $(this).parent().siblings().removeClass("active");
        $(this).parent().addClass("active");
        var btnLogin = $(".btnLogin");
        var btnOrder = $(".btn-order");
        if ($(this).attr('href') === "#cart-products")
        {
            if (btnLogin.length !== 0) {
                btnOrder.css('display',"flex");
                btnLogin.css('display',"none");
            }
        }
        else if ($(this).attr('href') === "#cart-shipping")
        {
            if (btnLogin.length !== 0) {
                btnLogin.css('display',"flex");
                btnOrder.css('display',"none");
            }
            $("#cartDrawerContent").collapse("hide");
        }
        else if ($(this).attr('href') === "#order-confirm")
        {
            if (this.hasAttribute('disabled'))
            {
                e.preventDefault();
            }

        }
        else {
            e.preventDefault();
        }

    });

    //Delete from cart
    $(document).on('click','a.cart_delete',function (e) {
        e.preventDefault();
        var prod_id = $(this).parent().parent().attr("data-product-id");
        $('select[data-product-id="'+prod_id+'"]').val(0).change();
    });

        //Handle order button clicks on different tabs
    $(".order-summary-short .btn-order").on('click',function (e) {

        if (curCart==null)
        {

        }
        else {
            $("#cart-shipping").modal();
        }
        e.preventDefault()
    });

      //Order summary icon toggle by flipping it
    $(".order-summary-toggle").on('click',function () {
        if ($(this).find("i").hasClass("animate-transform")) {
            $(this).find("i").toggleClass('flipped');
        }
    });

    //Handle cart modification on select number of pallets change
    $('#cart-products select[name="pallets[]"]').on('change',function (e) {
        $('.order-summary').show();
        var product_id = $(this).attr('data-product-id');

        var data = {
            'action': 'sitefront_add_to_cart',
            'product_id': product_id,      // We pass php values differently!
            'quantity': this.value,      // We pass php values differently!
        };
        console.log(NProgress);
        NProgress.start();
        NProgress.inc();
        jQuery.post(ajaxurl, data, function(response) {
            NProgress.inc();
            NProgress.done();

            var cart =$(".table-order-summary tbody");
            var cart_price = $(".order-cart-price");
            var cart_space_taken = $(".order-cart-space");
            var cart_total_pallets = $(".order-pallets-ammount");
            var min_shipping_date = $(".min-shipping-date");
            var min_shipping_days = $(".min-shipping-days");
            var shipDate = $('input.shipDate').parent();



            cart.html("");
            response = JSON.parse(response);
            //var cart_items = JSON.parse(response.products);
            cart_price.html( parseFloat(response.net_price).toFixed(2));
            cart_space_taken.html( response.cart_space);
            cart_total_pallets.html( response.total_pallets);
            min_shipping_date.text(response.min_shipping_date);
            calMinShipWeeks = Math.ceil(response.min_shipping_days / 7);

            pluralcontainer = calMinShipWeeks>1?"s":"";
            min_shipping_days.text("require a minimum of "+calMinShipWeeks+" week" +  pluralcontainer +" production before shipping.");

            shipDate.datepicker({
                startDate: "+" + response.min_shipping_days + "d",
                todayHighlight: true,
                weekStart: 1,
                maxViewMode: 2,
                todayBtn: true,
                daysOfWeekHighlighted: "0,6"
            });

            if (response.net_price === 0)
            {
                curCart = null;
                //  $("#progressConfirm").attr("disabled","disabled");
                //   $("#progressConfirm").removeAttr("data-toggle");
                //   $("#progressShipping").attr("disabled","disabled");
                //   $("#progressShipping").removeAttr("data-toggle");
                $('.cart-content').css("display","none");
                $('.cart-content-empty').css("display","flex");


            }
            else
            {
               // $("#progressConfirm").removeAttr("disabled");
               // $("#progressConfirm").attr('data-toggle','list');
                $('.cart-content').css("display","flex");
                $('.cart-content-empty').css("display","none");
                curCart = response;
            }

            $.each(response.products,function (key,item) {
               cart.html(cart.html() + '<tr data-product-id="'+item.product_id+'">\n' +
                   '                                <td>'+item.item_type+'</td>\n' +
                   '                                <td>'+item.variant+'</td>\n' +
                   '                                <td>€ '+item.price+'</td>\n' + // @TODO: Change to actual unit price
                   '                                <td>'+item.quantity+'</td>\n' + // @TODO: Change to number of units
                   '                                <td>'+item.quantity+'</td>\n' +
                   '                                <td>€ '+item.total_price+'</td>\n' +
                   '                                <td> <a class="cart_delete" href="#"><span class="fa fa-minus-circle"></span> </a> </td>\n' +
                   '                            </tr>');
            });

            if (response.wc_add === 1) {
                $.bootstrapGrowl("Product added to the cart", {
                    ele: '.bootstrap_notify', // which element to append to
                    type: 'success', // (null, 'info', 'danger', 'success')
                    offset: {from: 'bottom', amount: 60}, // 'top', or 'bottom'
                    align: 'right', // ('left', 'right', or 'center')
                    width: 250, // (integer, or 'auto')
                    delay: 4000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
                    allow_dismiss: true, // If true then will display a cross to close the popup.
                    stackup_spacing: 10 // spacing between consecutively stacked growls.
                });
            }
            else if(response.wc_remove === 1) {
                $.bootstrapGrowl("Product removed from the cart", {
                    ele: '.bootstrap_notify', // which element to append to
                    type: 'success', // (null, 'info', 'danger', 'success')
                    offset: {from: 'bottom', amount: 40}, // 'top', or 'bottom'
                    align: 'right', // ('left', 'right', or 'center')
                    width: 250, // (integer, or 'auto')
                    delay: 4000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
                    allow_dismiss: true, // If true then will display a cross to close the popup.
                    stackup_spacing: 10 // spacing between consecutively stacked growls.
                });
            }


        });

    });

    init_cart();

});


function init_cart() {
    var data = {
        'action': 'sitefront_populate_cart',
    };
    console.log(NProgress);
    NProgress.start();
    NProgress.inc();
    jQuery.post(ajaxurl, data, function(response) {
        NProgress.inc()
        NProgress.done();

        var cart =$(".table-order-summary tbody");
        var cart_price = $(".order-cart-price");
        var cart_space_taken = $(".order-cart-space");
        var cart_total_pallets = $(".order-pallets-ammount");
        var min_shipping_date = $(".min-shipping-date");
        var min_shipping_days = $(".min-shipping-days");
        var shipDate = $('input.shipDate').parent();

        cart.html("");
        response = JSON.parse(response);

        if (response.net_price === 0)
        {

            curCart = null;
           // $("#progressConfirm").attr("disabled","disabled");
           // $("#progressConfirm").removeAttr("data-toggle");
           // $("#progressShipping").attr("disabled","disabled");
           // $("#progressShipping").removeAttr("data-toggle");
            $('.cart-content').css("display","none");
            $('.cart-content-empty').css("display","flex");
        }
        else
        {
            $('.cart-content').css("display","flex");
            $('.cart-content-empty').css("display","none");
            curCart = response;
        }


        //var cart_items = JSON.parse(response.products);
        cart_price.html(parseFloat(response.net_price).toFixed(2));
        cart_space_taken.html( response.cart_space);
        cart_total_pallets.html( response.total_pallets);
        min_shipping_date.text(response.min_shipping_date);
        calMinShipWeeks = Math.ceil(response.min_shipping_days / 7);

        pluralcontainer = calMinShipWeeks>1?"s":"";
        min_shipping_days.text("require a minimum of "+calMinShipWeeks+" week" +  pluralcontainer +" production before shipping.");


        shipDate.datepicker({
            startDate: "+" + response.min_shipping_days + "d",
            todayHighlight: true,
            weekStart: 1,
            maxViewMode: 2,
            todayBtn: true,
            daysOfWeekHighlighted: "0,6"
        });

        $.each(response.products,function (key,item) {
            cart.html(cart.html() + '<tr data-product-id="'+item.product_id+'">\n' +
                '                                <td>'+item.item_type+'</td>\n' +
                '                                <td>'+item.variant+'</td>\n' +
                '                                <td>€ '+item.price+'</td>\n' + // @TODO: Change to actual unit price
                '                                <td>'+item.quantity+'</td>\n' + // @TODO: Change to number of units
                '                                <td>'+item.quantity+'</td>\n' +
                '                                <td>€ '+item.total_price+'</td>\n' +
                '                                <td> <a class="cart_delete" href="#"><span class="fa fa-minus-circle"></span> </a> </td>\n' +
                '                            </tr>');
        });

    });

    $("#newOrder").on('click',function (e) {
        e.preventDefault();
         $(".order-summary").show();
         $("#progressProducts").removeAttr("disabled");
         $("#progressProducts").attr('data-toggle','list');
         $("#progressProducts").trigger('click');
         $('#cart-products select[name="pallets[]"]').val("0");
         init_cart();
    });
}

function checkPickupMethod(val_to_check) {
	return $("#shipping-method").val() == val_to_check;
}


function validateForms() {

	if (validatorShippingDealer!=null) {
		validatorShippingDealer.resetForm();
		validatorShippingDealer.destroy();
	}
	if (validatorShippingAddress!=null) {
		validatorShippingAddress.resetForm();
		validatorShippingAddress.destroy();
	}
	if (validatorShippingPickup!=null) {
		validatorShippingPickup.resetForm();
		validatorShippingPickup.destroy();
	}

	if (validatorDeliveryInfo!=null) {
		validatorDeliveryInfo.resetForm();
		validatorDeliveryInfo.destroy();
	}

	validatorShippingDealer =  $('#form-shipping-dealer').validate({
		debug:true,
		errorClass: 'is-invalid',
		success: function(label) {
			var elem_name = label.attr('for');
			label.siblings("[name='"+elem_name+"']").addClass("is-valid").removeClass("error");
		},
		rules:{
			//Ship To Me
			'std-street-address' :{
				required: checkPickupMethod('ship-to-dealer'),
			},
			'std-city' :{
				required: checkPickupMethod('ship-to-dealer'),
			},
			'std-pobox' :{
				required: checkPickupMethod('ship-to-dealer'),
			},
			'std-country' :{
				required: checkPickupMethod('ship-to-dealer'),
			},
			'std-shipdate' :{
				required: checkPickupMethod('ship-to-dealer')
			},
		},
	});
	validatorShippingAddress = $('#form-shipping-address').validate({
		debug:true,
		errorClass: 'is-invalid',
		success: function(label) {
			var elem_name = label.attr('for');
			label.siblings("[name='"+elem_name+"']").addClass("is-valid").removeClass("error");
		},
		rules:{
			//Ship to address
			'sta-name' :{
				required: checkPickupMethod('ship-to-address'),
			},
			'sta-surname' :{
				required: checkPickupMethod('ship-to-address'),
			},
			'sta-email' :{
				required: checkPickupMethod('ship-to-address'),
				email: true,
			},
			'sta-phone' :{
				required: checkPickupMethod('ship-to-address'),
			},
			'sta-street-address' :{
				required: checkPickupMethod('ship-to-address'),
			},
			'sta-city' :{
				required: checkPickupMethod('ship-to-address'),
			},
			'sta-pobox' :{
				required: checkPickupMethod('ship-to-address'),
			},
			'sta-country' :{
				required: checkPickupMethod('ship-to-address'),
			},
			'sta-shipdate' :{
				required: checkPickupMethod('ship-to-address'),
			},
		},
	});
	validatorShippingPickup =  $('#form-shipping-pickup').validate({
		debug:true,
		errorClass: 'is-invalid',
		success: function(label) {
			var elem_name = label.attr('for');
			label.siblings("[name='"+elem_name+"']").addClass("is-valid").removeClass("error");
		},
		rules:{
			//Ship to pickup
			'stp-shipdate' :{
				required: checkPickupMethod('ship-to-pickup'),
			},
		},
	});
	//Validate Delivery Info Form
	validatorDeliveryInfo = $('#form-delivery-info').validate({
		debug:false,
		errorClass: 'is-invalid',
		success: function(label) {
			var elem_name = label.attr('for');
			label.siblings("[name='"+elem_name+"']").addClass("is-valid").removeClass("error");
		},
	});

}

function getShippingInfo() {
	var ret = null;
	validateForms();

	if (!validatorDeliveryInfo.form()) return null;

	switch ($("#shipping-method").val()) {
		case 'ship-to-dealer':
		ret = validatorShippingDealer.form()?$('#form-delivery-info , #form-shipping-dealer, #form-shipping-method, #form-total-notes').serialize():null;
		break;
		case 'ship-to-address':
		ret = validatorShippingAddress.form()?$('#form-delivery-info ,#form-shipping-address, #form-shipping-method, #form-total-notes').serialize():null;
		break;
		case 'ship-to-pickup':
		ret = validatorShippingPickup.form()?$('#form-delivery-info , #form-shipping-pickup, #form-shipping-method, #form-total-notes').serialize():null;
		break;

	}

	return ret;
}
