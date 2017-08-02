<h3 class="ec_account_subscription_title"><?php $this->subscription->display_title( ); ?></h3>


<?php if( $this->subscription->has_membership_page( ) ){ ?><div class="ec_account_subscription_row"><?php $this->subscription->display_membership_page_link( $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_5" ) ); ?></div><?php } ?>


<?php if( !$this->subscription->is_canceled( ) ){ ?><div class="ec_account_subscription_row"><b><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_next_billing' ); ?>:</b> <?php $this->subscription->display_next_bill_date( ); ?></div><?php }?>


<div class="ec_account_subscription_row"><b><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_last_payment' ); ?>:</b> <?php $this->subscription->display_last_bill_date( ); ?></div>


<div class="ec_account_subscription_row"><?php $this->subscription->display_price( ); ?></div>


<?php if( !$this->subscription->is_canceled( ) ){ ?>


<div class="ec_account_subscription_row last_spacer"><?php $GLOBALS['ec_user']->display_card_type( ); ?>: ############<?php $GLOBALS['ec_user']->display_last4( ); ?> | <a href="#" onclick="return show_billing_info( );" class="ec_account_subscription_link">change billing method</a></div>

<?php $this->display_subscription_update_form_start( ); ?>

<?php if( $this->subscription->has_upgrades( ) ){ ?>

<div class="ec_account_subscription_upgrade_row"><?php $this->subscription->display_upgrade_dropdown( ); ?></div>

<?php }?>

<?php if( !get_option( 'ec_option_subscription_one_only' ) ){ ?>
<table class="ec_cartitem_quantity_table ec_account_subscription_table">
    <tbody>
        <tr>
            <td class="ec_minus_column">
                <input type="button" value="-" class="ec_minus" onclick="ec_minus_quantity( '<?php echo $this->subscription->subscription_id; ?>' );" /></td>
            <td class="ec_quantity_column"><input type="number" value="<?php echo $this->subscription->quantity; ?>" id="ec_quantity_<?php echo $this->subscription->subscription_id; ?>" name="ec_quantity" autocomplete="off" step="1" min="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" class="ec_quantity" /></td>
            <td class="ec_plus_column"><input type="button" value="+" class="ec_plus" onclick="ec_plus_quantity( '<?php echo $this->subscription->subscription_id; ?>' );" /></td>
        </tr>
    </tbody>
</table>
<?php }?>

<div id="ec_account_subscription_billing_information" class="ec_account_subscription_billing">

    <div class="ec_cart_subscription_holder_left">

        <div class="ec_cart_header ec_top">
			<?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_title' )?>
        </div>
        
        <?php if( get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_country"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' )?>*</label>
            <?php $this->display_account_billing_information_country_input( ); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_country_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' ); ?>
            </div>
        </div>
        <?php } ?>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_first_name"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_first_name' )?>*</label>
            <?php $this->display_account_billing_information_first_name_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_first_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_first_name' ); ?>
            </div>
        </div>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_last_name"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_last_name' )?>*</label>
            <?php $this->display_account_billing_information_last_name_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_last_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_last_name' ); ?>
            </div>
        </div>
        
        <?php if( get_option( 'ec_option_enable_company_name' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_company_name"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_company_name' ); ?></label>
            <input type="text" name="ec_account_billing_information_company_name" id="ec_account_billing_information_company_name" class="ec_account_billing_information_input_field" value="<?php echo htmlspecialchars( $GLOBALS['ec_user']->billing->company_name, ENT_QUOTES ); ?>">
            <div class="ec_cart_error_row" id="ec_account_billing_information_company_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'cart_billing_information_company_name' ); ?>
            </div>
        </div>
        <?php } ?>
        
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_address"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_address' )?>*</label>
            <?php $this->display_account_billing_information_address_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_address_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_address' ); ?>
            </div>
        </div>
        <?php if( get_option( 'ec_option_use_address2' ) ){ ?>
        <div class="ec_cart_input_row">
        	<?php $this->display_account_billing_information_address2_input(); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_city"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_city' )?>*</label>
            <?php $this->display_account_billing_information_city_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_city_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_city' ); ?>
        	</div>
        </div>
        
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_state"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_state' )?><span id="ec_billing_state_required">*</span></label>
            <?php $this->display_account_billing_information_state_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_state_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_state' ); ?>
            </div>
        </div>
    	
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_zip"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_zip' )?>*</label>
            <?php $this->display_account_billing_information_zip_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_zip_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_zip' ); ?>
            </div>
        </div>
		
        <?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_account_billing_information_country"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' )?>*</label>
            <?php $this->display_account_billing_information_country_input( ); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_country_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' ); ?>
            </div>
        </div>
        <?php } ?>
        
        <?php if( get_option( 'ec_option_collect_user_phone' ) ){ ?>
		<div class="ec_cart_input_row">
            <label for="ec_account_billing_information_phone"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_phone' )?>*</label>
            <?php $this->display_account_billing_information_phone_input(); ?>
            <div class="ec_cart_error_row" id="ec_account_billing_information_phone_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_phone' ); ?>
            </div>
        </div>
        <?php }?>

    </div>

    <div class="ec_cart_subscription_holder_right" style="width:100%; float:left; border-top:1px solid #CCC; margin-top:10px; padding-top:10px;">

		<div style="float:none; max-width:500px;">

            <div class="ec_cart_input_row">
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
            <div class="ec_cart_input_row">
                <input name="ec_card_number" id="ec_card_number" type="tel" class="input-lg form-control cc-number" autocomplete="cc-number" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?>">
                <div class="ec_cart_error_row" id="ec_card_number_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?>
                </div>
            </div>
            <div class="ec_cart_input_row">
                <div class="ec_cart_input_left_half">
                    <input name="ec_cc_expiration" id="ec_cc_expiration" type="tel" class="input-lg form-control cc-exp" autocomplete="cc-exp" placeholder="MM / YYYY">
                    <div class="ec_cart_error_row" id="ec_expiration_date_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?>
                    </div>
                </div>
                <div class="ec_cart_input_right_half">
                    <input name="ec_security_code" id="ec_security_code" type="tel" class="input-lg form-control cc-cvc" autocomplete="off" placeholder="CVV">
                    <div class="ec_cart_error_row" id="ec_security_code_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?>
                    </div>
                </div>
            </div>
            
        </div>

	</div>

	<div class="ec_account_subscription_details_notice"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_notice' ); ?></div>

    <div class="ec_cart_error_row" id="ec_terms_error">
		<?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_accept_terms' )?> 
    </div>
    
    <?php if( get_option( 'ec_option_require_terms_agreement' ) ){ ?>
    <div class="ec_cart_input_row ec_agreement_section">
        <input type="checkbox" name="ec_terms_agree" id="ec_terms_agree" value="1"  /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_review_agree' )?>
    </div>
    <?php }else{ ?>
        <input type="hidden" name="ec_terms_agree" id="ec_terms_agree" value="2"  />
    <?php }?>

</div>

<div class="ec_account_subscription_button"><input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'save_changes_button' ); ?>" onclick="return ec_check_update_subscription_info( );" /></div>

<?php $this->display_subscription_update_form_end( ); ?>

<?php }?>

<h3><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_past_payments' ); ?></h3>

<div class="ec_account_subscriptions_past_payments"><?php $this->subscription->display_past_payments( ); ?></div>

<?php if( !$this->subscription->is_canceled( ) ){ ?>

<hr />

<div  class="ec_account_subscription_button"><?php $this->subscription->display_cancel_form( $GLOBALS['language']->get_text( 'account_subscriptions', 'cancel_subscription_button' ), $GLOBALS['language']->get_text( 'account_subscriptions', 'cancel_subscription_confirm_text' ) ); ?></div>

<?php } ?>