<div class="ec_account_subscription_line_<?php echo $i%2; ?>">


  <div class="ec_account_subscription_line_column1">


    <?php $subscription->display_title( ); ?>


  </div>


  <div class="ec_account_subscription_line_column2">


    <?php $subscription->display_next_bill_date(  ); ?>


  </div>


  <div class="ec_account_subscription_line_column3">


    <?php $subscription->display_last_bill_date(  ); ?>


  </div>


  <div class="ec_account_subscription_line_column4">


    <?php $subscription->display_price( ); ?>


  </div>


  <div class="ec_account_subscription_line_column5">


    <?php $subscription->display_subscription_link( $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_view_subscription_button' ) ); ?>


  </div>


</div>


