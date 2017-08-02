<div id="ec_account_subscriptions">
	<div class="ec_account_mobile">
    	<div class="ec_cart_header ec_top"><?php echo $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_title' )?></div>
		<?php do_action( 'wpeasycart_account_links' ); ?>
		<div class="ec_cart_input_row">
			<?php $this->display_dashboard_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_dashboard' )); ?>
		</div>
        <div class="ec_cart_input_row">
			<?php $this->display_personal_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_basic_inforamtion' ) ); ?>
		</div>
        <div class="ec_cart_input_row">
          <?php $this->display_orders_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_orders' ) ); ?>
        </div>
		<div class="ec_cart_input_row">
          <?php $this->display_password_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_password' ) ); ?>
        </div>
        <div class="ec_cart_input_row">
          <?php $this->display_logout_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_sign_out' )); ?>
        </div>
    </div>
  	<div class="ec_account_subscriptions_main_holder">
		<div class="ec_account_subscriptions_left">
    		<div class="ec_account_subscriptions_title ec_account_active_subscriptions_title"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_title' )?></div>
            <div class="ec_account_subscriptions_holder ec_account_active_subscriptions_list">
    			<div class="ec_account_subscription_line_header">
					<div class="ec_account_subscription_line_column1_header"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_header_1' )?></div>
					<div class="ec_account_subscription_line_column2_header"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_header_2' )?></div>
                    <div class="ec_account_subscription_line_column3_header"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_header_3' )?></div>
                    <div class="ec_account_subscription_line_column4_header"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_header_4' )?></div>
					<div class="ec_account_subscription_line_column5_header"></div>
                </div>
                <div class="ec_account_subscriptions_row" id="ec_subscriptions_list">
					<?php $this->subscriptions->display_subscription_list( ); //prints out a list of subscriptions of type ec_account_subscription_line.php ?>
				</div>
			</div>
			<div class="ec_account_subscriptions_title ec_account_cancelled_subscriptions_title"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'account_canceled_subscriptions_title' )?></div>
				<div class="ec_account_subscriptions_holder ec_account_cancelled_subscriptions_list">
					<div class="ec_account_subscription_line_header">
					<div class="ec_account_subscription_line_column1_header"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_header_1' )?></div>
					<div class="ec_account_subscription_line_column2_header"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_header_2' )?></div>
					<div class="ec_account_subscription_line_column3_header"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_header_3' )?></div>
					<div class="ec_account_subscription_line_column4_header"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_header_4' )?></div>
					<div class="ec_account_subscription_line_column5_header"></div>
				</div>
				<div class="ec_account_subscriptions_row" id="ec_subscriptions_list">
					<?php $this->subscriptions->display_canceled_subscription_list( ); //prints out a list of subscriptions of type ec_account_subscription_line.php ?>
				</div>
			</div>
		</div>
    	<div class="ec_account_subscriptions_right">
			<div class="ec_account_subscriptions_title"><?php echo $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_title' )?></div>
			<div class="ec_account_subscriptions_holder">
				<div class="ec_account_subscriptions_row">
					<?php $this->display_dashboard_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_dashboard' )); ?>
				</div>
				<div class="ec_account_subscriptions_row">
					<?php $this->display_personal_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_basic_inforamtion' ) ); ?>
				</div>
				<div class="ec_account_subscriptions_row">
					<?php $this->display_orders_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_orders' ) ); ?>
				</div>
				<div class="ec_account_subscriptions_row">
					<?php $this->display_password_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_password' ) ); ?>
				</div>
				<div class="ec_account_subscriptions_row">
					<?php $this->display_logout_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_sign_out' ) ); ?>
				</div>
			</div>
		</div>
    </div>
</div>