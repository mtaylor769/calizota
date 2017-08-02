<?php $this->display_page_three_form_start( ); ?>
<div class="ec_cart_left">
    
    <?php if( $this->order_totals->grand_total > 0 ){ ?>
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_payment_method' ); ?>
    </div>
    
    <?php if( $this->use_manual_payment( ) ){?>
    <div class="ec_cart_option_row">
		<input type="radio" name="ec_cart_payment_selection" id="ec_payment_manual" value="manual_bill"<?php if( $this->get_selected_payment_method( ) == "manual_bill" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_manual_payment' )?>
    </div>
    
    <div id="ec_manual_payment_form"<?php if( $this->get_selected_payment_method( ) == "manual_bill" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section">
        	<?php $this->display_manual_payment_text( ); ?>
        </div>
    </div>
    <?php } ?>
    
    <?php if( get_option( 'ec_option_use_affirm' ) ){ ?>
    <div class="ec_cart_option_row">
		<input type="radio" name="ec_cart_payment_selection" id="ec_payment_affirm" value="affirm"<?php if( $this->get_selected_payment_method( ) == "affirm" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_affirm' ); ?>
    </div>
    
    <div id="ec_affirm_form"<?php if( $this->get_selected_payment_method( ) == "affirm" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section ec_affirm_box">
        	<script>
				function ec_checkout_with_affirm( ){
				// setup and configure checkout
				affirm.checkout({
				
					config: {
						financial_product_key:		"<?php echo get_option( 'ec_option_affirm_financial_product' ); ?>"
					},
					
					merchant: {
						user_confirmation_url:		"<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=process_affirm",
						user_cancel_url:			"<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_payment"
					},
					
					billing: {
						name: {
							first:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->first_name, ENT_QUOTES ); ?>",
							last:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->last_name, ENT_QUOTES ); ?>"
						},
						address: {
							line1:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_1, ENT_QUOTES ); ?>",
							line2:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_2, ENT_QUOTES ); ?>",
							city:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->city, ENT_QUOTES ); ?>",
							state:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->state, ENT_QUOTES ); ?>",
							zipcode:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->zip, ENT_QUOTES ); ?>",
							country:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->country, ENT_QUOTES ); ?>"
						},
						phone_number:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->phone, ENT_QUOTES ); ?>",
						email:						"<?php echo htmlspecialchars( $GLOBALS['ec_user']->email, ENT_QUOTES ); ?>"
					},
					
					shipping: {
						name: {
							first:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->first_name, ENT_QUOTES ); ?>",
							last:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->last_name, ENT_QUOTES ); ?>"
						},
						address: {
							line1:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_1, ENT_QUOTES ); ?>",
							line2:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_2, ENT_QUOTES ); ?>",
							city:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->city, ENT_QUOTES ); ?>",
							state:					"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->state, ENT_QUOTES ); ?>",
							zipcode:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->zip, ENT_QUOTES ); ?>",
							country:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->country, ENT_QUOTES ); ?>"
						},
						phone_number:				"<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->phone, ENT_QUOTES ); ?>"
					},
					
					items: [<?php for( $i=0; $i<count( $this->cart->cart ); $i++ ){ ?>{
						display_name:         		"<?php echo $this->cart->cart[$i]->title; ?>",
						sku:                  		"<?php echo $this->cart->cart[$i]->model_number; ?>",
						unit_price:           		<?php echo number_format( ( 100 * $this->cart->cart[$i]->unit_price ), 0, '', '' ); ?>,
						qty:                  		<?php echo $this->cart->cart[$i]->quantity; ?>,
						item_image_url:       		"<?php echo $this->cart->cart[$i]->get_image_url( ); ?>",
						item_url:             		"<?php echo $this->cart->cart[$i]->get_product_url( ); ?>"
					},<?php }?>],
					
					tax_amount:						<?php echo number_format( ( 100 * $this->order_totals->tax_total ), 0, '', '' ); ?>,
					shipping_amount:				<?php echo number_format( ( 100 * $this->order_totals->shipping_total ), 0, '', '' ); ?>
				
				});
				
				affirm.checkout.open( ); 
				
				}
			</script>
            
            <a href="https://www.affirm.com" target="_blank"><img src="<?php echo $this->get_payment_image_source( "affirm-banner-540x200.png" ); ?>" alt="Affirm Split Pay" /></a>
        </div>
    </div>
    <?php }?>
    
	<?php if( $this->use_third_party( ) ){?>
    <div class="ec_cart_option_row">
		<input type="radio" name="ec_cart_payment_selection" id="ec_payment_third_party" value="third_party"<?php if( $this->get_selected_payment_method( ) == "third_party" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party' )?> <?php $this->ec_cart_display_current_third_party_name( ); ?>
    </div>
    
    
    <div id="ec_third_party_form"<?php if( $this->get_selected_payment_method( ) == "third_party" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section">
        	<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party_first' )?> <?php $this->ec_cart_display_current_third_party_name( ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party_second' )?>
            
            <br />
			
			<?php if( get_option( 'ec_option_payment_third_party' ) == "paypal" ){ ?>
            	<img src="<?php echo $this->get_payment_image_source( "paypal.jpg" ); ?>" alt="PayPal" />
            
            <?php }else if( get_option( 'ec_option_payment_third_party' ) == "skrill" ){ ?>
            	<img src="<?php echo $this->get_payment_image_source( "skrill-logo.gif" ); ?>" alt="Skrill" />
            
			<?php } ?>
            
            <?php do_action( 'wpeasycart_third_party_checkout_box' ); ?>
        
        </div>
    </div>
    <?php }?>
    
    <?php if( $this->use_payment_gateway( ) ){?>
    
    <?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?>
    <script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script>
	<script>
	
	var applicationId = '<?php echo get_option( 'ec_option_square_application_id' ); ?>';
	
	var paymentForm = new SqPaymentForm({
		applicationId: applicationId,
		inputClass: 'sq-input',
		inputStyles: [{
			fontSize: '15px'
	  	}],
		cardNumber: {
			elementId: 'sq-card-number',
			placeholder: '•••• •••• •••• ••••'
		},
	cvv: {
	  elementId: 'sq-cvv',
	  placeholder: 'CVV'
	},
	expirationDate: {
	  elementId: 'sq-expiration-date',
	  placeholder: 'MM/YY'
	},
	postalCode: {
	  elementId: 'sq-postal-code'
	},
	callbacks: {
		cardNonceResponseReceived: function(errors, nonce, cardData) {
			if (errors) {
		  		console.log("Encountered errors:");
				errors.forEach(function(error) {
					console.log('  ' + error.message);
		  		});
			}else{
				document.getElementById('card-nonce').value = nonce;
				document.getElementById('ec_submit_order_form').submit();			
			}
		},
		unsupportedBrowserDetected: function() {
			// Fill in this callback to alert buyers when their browser is not supported.
	  	},
		// Fill in these cases to respond to various events that can occur while a
		// buyer is using the payment form.
		inputEventReceived: function(inputEvent) {
			switch (inputEvent.eventType) {
				case 'focusClassAdded':
					// Handle as desired
					break;
				case 'focusClassRemoved':
					// Handle as desired
					break;
				case 'errorClassAdded':
					// Handle as desired
					break;
				case 'errorClassRemoved':
					// Handle as desired
					break;
				case 'cardBrandChanged':
					// Handle as desired
					break;
				case 'postalCodeChanged':
					// Handle as desired
					break;
			}
	  	},

		paymentFormLoaded: function() {
			paymentForm.setPostalCode('<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->zip, ENT_QUOTES ); ?>');
	  	}
	}
	});
	
	function requestCardNonce( event ){
		if( jQuery( document.getElementById( 'ec_payment_credit_card' ) ).is( ":checked" ) ){
			event.preventDefault( );
			paymentForm.requestCardNonce( );
			return false;
		}else{
			return true;
		}
	}
	</script>
	
	<!--
	These styles can live in a separate .css file. They're just here to keep this
	example to a single file.
	-->
	<style type="text/css">
	.sq-input {
		border: 1px solid rgb(223, 223, 223);
		outline-offset: -2px;
	  	margin-bottom: 5px;
		border-color: #e1e1e1;
		background-color: #fcfcfc;
		color: #919191;
		padding: 8px 6px;
		outline: none;
		font: 1em "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
		height:35px;
	}
	.sq-input--focus {
	  /* Indicates how form inputs should appear when they have focus */
	  outline: 5px auto rgb(59, 153, 252);
	}
	.sq-input--error {
	  /* Indicates how form inputs should appear when they contain invalid values */
	  outline: 5px auto rgb(255, 97, 97);
	}
	</style>
    <input type="hidden" id="card-nonce" name="nonce">
    <?php }?>
    
    <div class="ec_cart_option_row">
		<input type="radio" name="ec_cart_payment_selection" id="ec_payment_credit_card" value="credit_card"<?php if( $this->get_selected_payment_method( ) == "credit_card" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_credit_card' )?>
    </div>
    
    <div id="ec_credit_card_form"<?php if( $this->get_selected_payment_method( ) == "credit_card" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section">
        	<div class="ec_cart_input_row" style="margin-top:-10px;">
				<?php if( get_option('ec_option_use_visa') || get_option('ec_option_use_delta') || get_option('ec_option_use_uke') ){ ?>
					<img src="<?php echo $this->get_payment_image_source( "visa.png" ); ?>" alt="Visa" class="ec_card_active" id="ec_card_visa" />
                	<img src="<?php echo $this->get_payment_image_source( "visa_inactive.png" ); ?>" alt="Visa" class="ec_card_inactive" id="ec_card_visa_inactive" />
            	<?php }?>
            
                <?php if( get_option('ec_option_use_discover') ){ ?>
                    <img src="<?php echo $this->get_payment_image_source( "discover.png" ); ?>" alt="Discover" class="ec_card_active" id="ec_card_discover" />
                    <img src="<?php echo $this->get_payment_image_source( "discover_inactive.png" ); ?>" alt="Discover" class="ec_card_inactive" id="ec_card_discover_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_mastercard') || get_option('ec_option_use_mcdebit') ){ ?>
                    <img src="<?php echo $this->get_payment_image_source( "mastercard.png"); ?>" alt="Mastercard" class="ec_card_active" id="ec_card_mastercard" />
					<img src="<?php echo $this->get_payment_image_source( "mastercard_inactive.png"); ?>" alt="Mastercard" class="ec_card_inactive" id="ec_card_mastercard_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_amex') ){ ?>
                    <img src="<?php echo $this->get_payment_image_source( "american_express.png"); ?>" alt="AMEX" class="ec_card_active" id="ec_card_amex" />
					<img src="<?php echo $this->get_payment_image_source( "american_express_inactive.png"); ?>" alt="AMEX" class="ec_card_inactive" id="ec_card_amex_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_jcb') ){ ?>
                    <img src="<?php echo $this->get_payment_image_source( "jcb.png"); ?>" alt="JCB" class="ec_card_active" id="ec_card_jcb" />
					<img src="<?php echo $this->get_payment_image_source( "jcb_inactive.png"); ?>" alt="JCB" class="ec_card_inactive" id="ec_card_jcb_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_diners') ){ ?>
                    <img src="<?php echo $this->get_payment_image_source( "diners.png"); ?>" alt="Diners" class="ec_card_active" id="ec_card_diners" />
					<img src="<?php echo $this->get_payment_image_source( "diners_inactive.png"); ?>" alt="Diners" class="ec_card_inactive" id="ec_card_diners_inactive" />
            	<?php }?>
                
            	<?php if( get_option('ec_option_use_maestro') || get_option('ec_option_use_laser')){ ?>
                	<img src="<?php echo $this->get_payment_image_source( "maestro.png"); ?>" alt="Maestro" class="ec_card_active" id="ec_card_maestro" />
					<img src="<?php echo $this->get_payment_image_source( "maestro_inactive.png"); ?>" alt="Maestro" class="ec_card_inactive" id="ec_card_maestro_inactive" />
            	<?php }?>
            </div>
            
			<?php if( get_option( 'ec_option_show_card_holder_name' ) ){ ?>
            <div class="ec_cart_input_row">
                <input name="ec_card_holder_name" id="ec_card_holder_name" type="text" class="input-lg form-control" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_holder_name' )?>">
                <div class="ec_cart_error_row" id="ec_card_holder_name_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_holder_name' )?>
                </div>
            </div>
			<?php }else{ ?>
            <?php $this->ec_cart_display_card_holder_name_hidden_input(); ?>
            <?php } ?>
			<div class="ec_cart_input_row"<?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?> id="sq-card-number"<?php }?>>
				<input name="ec_card_number" id="ec_card_number"<?php if( get_option( 'ec_option_payment_process_method' ) == "eway" && get_option( 'ec_option_eway_use_rapid_pay' ) ){?> data-eway-encrypt-name="ec_card_number"<?php }?> type="tel" class="input-lg form-control cc-number" autocomplete="cc-number" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?>">
                <div class="ec_cart_error_row" id="ec_card_number_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?>
                </div>
            </div>
           	<div class="ec_cart_input_row">
				<div class="ec_cart_input_left_half"<?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?> id="sq-expiration-date"<?php }?>>
                	<input name="ec_cc_expiration" id="ec_cc_expiration" type="tel" class="input-lg form-control cc-exp" autocomplete="cc-exp" placeholder="MM / YYYY">
					<div class="ec_cart_error_row" id="ec_expiration_date_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?>
                    </div>
            	</div>
			    <div class="ec_cart_input_right_half"<?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?> id="sq-cvv"<?php }?>>
                	<input name="ec_security_code" id="ec_security_code"<?php if( get_option( 'ec_option_payment_process_method' ) == "eway" && get_option( 'ec_option_eway_use_rapid_pay' ) ){?> data-eway-encrypt-name="ec_security_code"<?php }?> type="tel" class="input-lg form-control cc-cvc" autocomplete="off" placeholder="CVV">
                	<div class="ec_cart_error_row" id="ec_security_code_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?>
                    </div>
            	</div>
            </div>
            <?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?><div style="display:none !important;"><div class="ec_cart_input_row" id="sq-postal-code"></div></div><?php }?>
        </div>
    </div>
    <?php }?>
    
    <?php } //close if/else check for free order ?>
    
    <div class="ec_cart_header<?php if( $this->order_totals->grand_total <= 0 ){ ?> ec_top<?php }?>">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_review_title' )?>
    </div>
    
    <?php for( $cartitem_index = 0; $cartitem_index<count( $this->cart->cart ); $cartitem_index++ ){ ?>
    
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php $this->cart->cart[$cartitem_index]->display_title( ); ?><?php if( $this->cart->cart[$cartitem_index]->grid_quantity > 1 ){ ?> x <?php echo $this->cart->cart[$cartitem_index]->grid_quantity; ?><?php }else if( $this->cart->cart[$cartitem_index]->quantity > 1 ){ ?> x <?php echo $this->cart->cart[$cartitem_index]->quantity; ?><?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->stock_quantity <= 0 && $this->cart->cart[$cartitem_index]->allow_backorders ){ ?>
        <div class="ec_cart_backorder_date"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_backordered' ); ?><?php if( $this->cart->cart[$cartitem_index]->backorder_fill_date != "" ){ ?> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_backorder_until' ); ?> <?php echo $this->cart->cart[$cartitem_index]->backorder_fill_date; ?><?php }?></div>
        <?php }?>
        <?php if( $this->cart->cart[$cartitem_index]->optionitem1_name ){ ?>
        <dl>
            <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem1_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem1_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem1_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem1_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem1_price ); ?> )<?php } ?></dt>
        
        <?php if( $this->cart->cart[$cartitem_index]->optionitem2_name ){ ?>
            <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem2_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem2_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem2_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem2_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem2_price ); ?> )<?php } ?></dt>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->optionitem3_name ){ ?>
            <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem3_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem3_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem3_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem3_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem3_price ); ?> )<?php } ?></dt>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->optionitem4_name ){ ?>
            <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem4_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem4_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem4_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem4_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem4_price ); ?> )<?php } ?></dt>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->optionitem5_name ){ ?>
            <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem5_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem5_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem5_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem5_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem5_price ); ?> )<?php } ?></dt>
        <?php }?>
        </dl>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->use_advanced_optionset ){ ?>
        <dl>
        <?php foreach( $this->cart->cart[$cartitem_index]->advanced_options as $advanced_option_set ){ ?>
            <?php if( $advanced_option_set->option_type == "grid" ){ ?>
            <dt><?php echo $advanced_option_set->optionitem_name; ?>: <?php echo $advanced_option_set->optionitem_value; ?><?php if( $advanced_option_set->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_override ) . ')'; } ?></dt>
            <?php }else if( $advanced_option_set->option_type == "dimensions1" || $advanced_option_set->option_type == "dimensions2" ){ ?>
            <strong><?php echo $advanced_option_set->option_label; ?>:</strong><br /><?php $dimensions = json_decode( $advanced_option_set->optionitem_value ); if( count( $dimensions ) == 2 ){ echo $dimensions[0]; if( !get_option( 'ec_option_enable_metric_unit_display' ) ){ echo "\""; } echo " x " . $dimensions[1]; if( !get_option( 'ec_option_enable_metric_unit_display' ) ){ echo "\""; } }else if( count( $dimensions ) == 4 ){ echo $dimensions[0] . " " . $dimensions[1] . "\" x " . $dimensions[2] . " " . $dimensions[3] . "\""; } ?><br />
            
            <?php }else{ ?>
            <dt><?php echo $advanced_option_set->option_label; ?>: <?php echo htmlspecialchars( $advanced_option_set->optionitem_value, ENT_QUOTES ); ?><?php if( $advanced_option_set->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_override ) . ')'; } ?></dt>
            <?php } ?>
        <?php }?>
        </dl>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->is_giftcard ){ ?>
        <dl>
        <dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_recipient_name' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_to_name, ENT_QUOTES ); ?></dt>
        <dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_recipient_email' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_email, ENT_QUOTES ); ?></dt>
        <dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_sender_name' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_from_name, ENT_QUOTES ); ?></dt>
        <dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_message' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_message, ENT_QUOTES ); ?></dt>
        </dl>
        <?php }?>
        
        <?php if( $this->cart->cart[$cartitem_index]->is_deconetwork ){ ?>
        <dl>
        <dt><?php echo $this->cart->cart[$cartitem_index]->deconetwork_options; ?></dt>
        <dt><?php echo "<a href=\"https://" . get_option( 'ec_option_deconetwork_url' ) . $this->cart->cart[$cartitem_index]->deconetwork_edit_link . "\">" . $GLOBALS['language']->get_text( 'cart', 'deconetwork_edit' ) . "</a>"; ?></dt>
        </dl>
        <?php }?>
        
        </div>
        <div class="ec_cart_price_row_total" id="ec_cart_subtotal"><?php echo $this->cart->cart[$cartitem_index]->get_total( ); ?></div>
    </div>
    
    <?php }?>
    
    <div class="ec_cart_price_row ec_order_total">
        <div class="ec_cart_price_row_label"></div>
        <div class="ec_cart_price_row_total"><a href="<?php echo $this->cart_page; ?>"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_cart_link' ); ?></a></div>
    </div>
    
    <?php if( get_option( 'ec_option_user_order_notes' ) && $GLOBALS['ec_cart_data']->cart_data->order_notes != "" && strlen( $GLOBALS['ec_cart_data']->cart_data->order_notes ) > 0 ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?>
    </div>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->order_notes, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div id="ec_cart_payment_one_column">
    	<div class="ec_cart_header ec_top">
            <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->last_name, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->billing->company_name ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->company_name, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_1, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->billing->address_line_2 ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_2, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->city, ENT_QUOTES ); ?>, <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->state, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->zip, ENT_QUOTES ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->country_name, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->billing->phone ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->phone, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <?php if( strlen( $GLOBALS['ec_user']->vat_registration_number ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <strong><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_vat_registration_number' ); ?>:</strong> <?php echo htmlspecialchars( $GLOBALS['ec_user']->vat_registration_number, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_billing_link' ); ?></a>
        </div>
        
        <?php if( get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){ ?>
        
        <div class="ec_cart_header ec_top">
            <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_title' ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->last_name, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->shipping->company_name ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->company_name, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_1, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->shipping->address_line_2 ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_2, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->city, ENT_QUOTES ); ?>, <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->state, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->zip, ENT_QUOTES ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->country_name, ENT_QUOTES ); ?>
        </div>
        
        <?php if( strlen( $GLOBALS['ec_user']->shipping->phone ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->phone, ENT_QUOTES ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_shipping_link' ); ?></a>
        </div>
        
        <div class="ec_cart_header">
            <?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_title' ); ?> 
        </div>
        <div class="ec_cart_input_row">
            <strong><?php $this->ec_cart_display_shipping_methods( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" ); ?></strong>
        </div>
        
        <?php }?>
    </div>
    
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_review_totals_title' ); ?>
    </div>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_subtotal' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_subtotal"><?php echo $this->get_subtotal( ); ?></div>
    </div>
    <?php if( $this->order_totals->tax_total > 0 ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_tax' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_tax"><?php echo $this->get_tax_total( ); ?></div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_shipping' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_shipping"><?php echo $this->get_shipping_total( ); ?></div>
    </div>
    <?php }?>
    <div class="ec_cart_price_row<?php if( $this->order_totals->discount_total == 0 ){ ?> ec_no_discount<?php }else{ ?> ec_has_discount<?php }?>">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_discounts' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_discount"><?php echo $this->get_discount_total( ); ?></div>
    </div>
    <?php if( $this->tax->is_duty_enabled( ) ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_duty' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_duty"><?php echo $this->get_duty_total( ); ?></div>
    </div>
    <?php }?>
    <?php if( $this->tax->is_vat_enabled( ) ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_vat' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_vat"><?php echo $this->get_vat_total_formatted( ); ?></div>
    </div>
    <?php }?>
	<?php if( get_option( 'ec_option_enable_easy_canada_tax' ) && $this->order_totals->gst_total > 0 ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label">GST (<?php echo $this->tax->gst_rate; ?>%)</div>
        <div class="ec_cart_price_row_total" id="ec_cart_tax"><?php echo $this->get_gst_total( ); ?></div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_enable_easy_canada_tax' ) && $this->order_totals->pst_total > 0 ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label">PST (<?php echo $this->tax->pst_rate; ?>%)</div>
        <div class="ec_cart_price_row_total" id="ec_cart_tax"><?php echo $this->get_pst_total( ); ?></div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_enable_easy_canada_tax' ) && $this->order_totals->hst_total > 0 ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label">HST (<?php echo $this->tax->hst_rate; ?>%)</div>
        <div class="ec_cart_price_row_total" id="ec_cart_tax"><?php echo $this->get_hst_total( ); ?></div>
    </div>
    <?php }?>
    <div class="ec_cart_price_row ec_order_total">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_grand_total' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_total"><?php echo $this->get_grand_total( ); ?></div>
    </div>
		
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' )?>
    </div>
    
    <div class="ec_cart_error_row" id="ec_terms_error">
        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_accept_terms' )?> 
    </div>
    <div class="ec_cart_input_row">
		<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_checkout_text' )?>
    </div>
	<?php if( get_option( 'ec_option_require_terms_agreement' ) ){ ?>
    <div class="ec_cart_input_row ec_agreement_section">
        <input type="checkbox" name="ec_terms_agree" id="ec_terms_agree" value="1"  /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_review_agree' )?>
    </div>
    <?php }else{ ?>
    	<input type="hidden" name="ec_terms_agree" id="ec_terms_agree" value="2"  />
    <?php }?>
    
    
    <div class="ec_cart_error_row" id="ec_submit_order_error">
        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_correct_errors' )?> 
    </div>
                    
    <div class="ec_cart_button_row">
        <input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' )?>" class="ec_cart_button" id="ec_cart_submit_order" onclick="<?php if( get_option( 'ec_option_payment_process_method' ) == "square" ){ ?>return requestCardNonce(event);<?php }else{ ?>return ec_validate_submit_order( );<?php }?>" />
        <input type="submit" value="<?php echo strtoupper( $GLOBALS['language']->get_text( 'cart', 'cart_please_wait' ) ); ?>" class="ec_cart_button_working" id="ec_cart_submit_order_working" onclick="return false;" />
    </div>
</div>

<?php $this->display_page_three_form_end( ); ?>

<div class="ec_cart_right" id="ec_cart_payment_hide_column">
    
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' ); ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->last_name, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->billing->company_name ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->company_name, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_1, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->billing->address_line_2 ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->address_line_2, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->city, ENT_QUOTES ); ?>, <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->state, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->zip, ENT_QUOTES ); ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->country_name, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->billing->phone ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->phone, ENT_QUOTES ); ?>
    </div>
    <?php }?>
        
	<?php if( strlen( $GLOBALS['ec_user']->vat_registration_number ) > 0 ){ ?>
    <div class="ec_cart_input_row">
        <strong><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_vat_registration_number' ); ?>:</strong> <?php echo htmlspecialchars( $GLOBALS['ec_user']->vat_registration_number, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_billing_link' ); ?></a>
    </div>
    
    <?php if( get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){ ?>
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_title' ); ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->last_name, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->shipping->company_name ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->company_name, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_1, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->shipping->address_line_2 ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->address_line_2, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->city, ENT_QUOTES ); ?>, <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->state, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->zip, ENT_QUOTES ); ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->country_name, ENT_QUOTES ); ?>
    </div>
    
    <?php if( strlen( $GLOBALS['ec_user']->shipping->phone ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo htmlspecialchars( $GLOBALS['ec_user']->shipping->phone, ENT_QUOTES ); ?>
    </div>
    <?php }?>
    
    <?php $this->display_page_two_form_start( ); ?>
    <div class="ec_cart_input_row">
    	<a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_shipping_link' ); ?></a>
    </div>
    <?php }?>
    
    <?php if( get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_title' ); ?>
    </div>
    <div class="ec_cart_input_row">
        <strong><?php $this->ec_cart_display_shipping_methods( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" ); ?></strong>
    </div>
    
    <div class="ec_cart_button_row">
        <input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_update_shipping' ); ?>" class="ec_cart_button" />
    </div>
    <?php $this->display_page_two_form_end( ); ?>
    <?php } // Close if for shipping ?>
    
</div>