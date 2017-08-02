<?php $this->display_page_two_form_start( ); ?>
<div class="ec_cart_left">
	<div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_title' ); ?>
    </div>
    <div class="ec_cart_error_row" id="ec_cart_billing_country_error">
        <?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_please_select_one' ); ?>
    </div>
    <div class="ec_cart_input_row">
        <label for="ec_cart_billing_country"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_title' ); ?></label>
        <?php $this->ec_cart_display_shipping_methods( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" ); ?>
    </div>
</div>

<div class="ec_cart_right">
    
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart', 'your_cart_title' ); ?>
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
    
    <?php if( get_option( 'ec_option_show_coupons' ) ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_coupon_title' )?>
    </div>
    <div class="ec_cart_error_message" id="ec_coupon_error"></div>
    <div class="ec_cart_success_message" id="ec_coupon_success"<?php if( isset( $this->coupon ) ){?> style="display:block;"<?php }?>><?php if( isset( $this->coupon ) ){ echo $this->coupon->message; } ?></div>
    <div class="ec_cart_input_row">
        <input type="text" name="ec_coupon_code" id="ec_coupon_code" value="<?php if( isset( $this->coupon ) ){ echo $this->coupon_code; } ?>" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_enter_coupon' )?>" />
    </div>
    <div class="ec_cart_button_row">
        <div class="ec_cart_button" id="ec_apply_coupon" onclick="ec_apply_coupon( );"><?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_apply_coupon' ); ?></div>
        <div class="ec_cart_button_working" id="ec_applying_coupon"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_please_wait' )?></div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_show_giftcards' ) ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_gift_card_title' )?>
    </div>
    <div class="ec_cart_error_message" id="ec_gift_card_error"></div>
    <div class="ec_cart_success_message" id="ec_gift_card_success"<?php if( $this->gift_card != "" ){?> style="display:block;"<?php }?>><?php if( $this->gift_card != "" ){ echo $this->giftcard->message; } ?></div>
    <div class="ec_cart_input_row">
        <input type="text" name="ec_gift_card" id="ec_gift_card" value="<?php echo $this->gift_card; ?>" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_enter_gift_code' )?>" />
    </div>
    <div class="ec_cart_button_row">
        <div class="ec_cart_button" id="ec_apply_gift_card" onclick="ec_apply_gift_card( );"><?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_redeem_gift_card' ); ?></div>
        <div class="ec_cart_button_working" id="ec_applying_gift_card"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_please_wait' )?></div>
    </div>
    <?php }?>
    
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_title' ); ?>
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
    <?php if( get_option( 'ec_option_use_shipping' ) && ( $this->cart->shippable_total_items > 0 || $this->order_totals->handling_total > 0 ) ){?>
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
    
    <div class="ec_cart_error_row" id="ec_checkout_error">
        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_checkout_details_errors' )?>
    </div>
    
    <?php if( $this->shipping->shipping_method != "live" || $this->shipping->has_live_rates ){ ?>
    <div class="ec_cart_button_row">
        <input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_continue_payment' ); ?>" class="ec_cart_button" />
    </div>
    <?php } ?>
    
</div>
<?php $this->display_page_two_form_end( ); ?>