<?php
$db = new ec_db_admin( );

function get_high_point( $largest ){
	if( $largest < 10 )
		return 10;
	else if( $largest < 50 )
		return 50;
	else if( $largest < 100 )
		return 100;
	else if( $largest < 250 )
		return 250;
	else if( $largest < 500 )
		return 500;
	else if( $largest < 1000 )
		return 1000;
	else if( $largest < 2500 )
		return 2500;
	else if( $largest < 5000 )
		return 5000;
	else if( $largest < 10000 )
		return 10000;
	else if( $largest < 25000 )
		return 25000;
	else if( $largest < 50000 )
		return 50000;
	else if( $largest < 100000 )
		return 100000;
	else if( $largest < 250000 )
		return 250000;
	else if( $largest < 500000 )
		return 500000;
	else if( $largest < 1000000 )
		return 1000000;
	else if( $largest < 5000000 )
		return 5000000;
	else if( $largest < 10000000 )
		return 10000000;
	else if( $largest < 100000000 )
		return 100000000;
	else if( $largest < 1000000000 )
		return 1000000000;
	else
		return 10000000000;
	
}

/* Get the recent sales totals */
if( !isset( $_GET['ec_stat'] ) || ( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "days" ) )
	$orders = $db->get_order_totals_by_days( 11 );

else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "weeks" )
	$orders = $db->get_order_totals_by_weeks( 11 );

else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "months" )
	$orders = $db->get_order_totals_by_months( 11 );

else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "years" )
	$orders = $db->get_order_totals_by_years( 11 );

// Get splits
$largest = 0;
for( $i=0; $i<count( $orders ); $i++ ){
	if( $orders[$i]->total > $largest ){
		$largest = $orders[$i]->total;
	}
}
$high_point = get_high_point( $largest );
$split = $high_point/5;
$high_point = $high_point + $split;
$next_point = $high_point;

// Get the top viewed products
$top_products = $db->get_top_ten_products( );

// get the last 10 orders
$last_orders = $db->get_last_ten_orders( );

// get top 10 customers
$top_customers = $db->get_top_ten_customers( );

$highest_point = $high_point + $split;
?>

<div class="ec_statistics_row">
  <div class="ec_statistics_quad1">
    <div class="ec_statistics_tab_holder">
      <div class="ec_statistcs_tab<?php if( !isset( $_GET['ec_stat'] ) || ( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "days" ) ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=statistics&ec_stat=days">Days</a></div>
      <div class="ec_statistcs_tab<?php if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "weeks" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=statistics&ec_stat=weeks">Weeks</a></div>
      <div class="ec_statistcs_tab<?php if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "months" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=statistics&ec_stat=months">Months</a></div>
      <div class="ec_statistcs_tab<?php if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "years" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=statistics&ec_stat=years">Years</a></div>
    </div>
    <div class="ec_statistics_holder">
      <div class="ec_statistics_scale">
        <div class="ec_statistics_scale_item_top"><?php echo $GLOBALS['currency']->get_stats_currency_display( $next_point ); $next_point = $next_point - $split; ?></div>
        <div class="ec_statistics_scale_item"><?php echo $GLOBALS['currency']->get_stats_currency_display( $next_point ); $next_point = $next_point - $split; ?></div>
        <div class="ec_statistics_scale_item"><?php echo $GLOBALS['currency']->get_stats_currency_display( $next_point ); $next_point = $next_point - $split; ?></div>
        <div class="ec_statistics_scale_item"><?php echo $GLOBALS['currency']->get_stats_currency_display( $next_point ); $next_point = $next_point - $split; ?></div>
        <div class="ec_statistics_scale_item"><?php echo $GLOBALS['currency']->get_stats_currency_display( $next_point ); $next_point = $next_point - $split; ?></div>
        <div class="ec_statistics_scale_item"><?php echo $GLOBALS['currency']->get_stats_currency_display( $next_point ); $next_point = $next_point - $split; ?></div>
        <div class="ec_statistics_scale_item"><?php echo $GLOBALS['currency']->get_stats_currency_display( 0 ); ?></div>
      </div>
      <div class="ec_statistics_content">
        <?php 
			$last_total = 0;
			if( !isset( $_GET['ec_stat'] ) || ( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "days" ) ){
				$last_used_order_index = 0;
				$first_num = date( 'd', strtotime( '-11 days' ) );
				$last_num = date( 'd', strtotime( '-0 days' ) );
				
				// We need to first check and see if the first order value falls before our first date...
				// This is a bug fix for timezone issues
				if( $first_num < $last_num ){ //check when all dates in the same month
					if( count( $orders ) > 0 && $orders[0]->the_day >= $first_num  && $orders[0]->the_day <= $last_num ){
						$i=11;
					}else{
						$i=12;
					}
				}else{ //check when dates are split between two months
					if( ( count( $orders ) > 0 && isset( $orders[0] ) && $first_num >= $orders[0]->the_day ) || ( count( $orders ) > 0 && $orders[0]->the_day <= $last_num ) ){
						$i=11;
					}else{
						$i=11;
					}
				}
				
				for( $i; $i > -1 && $last_used_order_index < count( $orders ); $i-- ){
					$current_day_number = date( 'd', strtotime( '-' . $i . ' days' ) ); 
					
					if( $orders[$last_used_order_index]->the_day == $current_day_number ){
						$total = $orders[$last_used_order_index]->total;
						$last_used_order_index++;
					}else{
						$total = 0;
					}
					$last_total = $total;
					if( $highest_point > 0 )
						$percent_height = $total/$highest_point;
					else
						$percent_height = 0;
				?>
        <div class="ec_statistics_bar_item" style="margin-top:<?php echo ( 210 * ( 1 - $percent_height ) ); ?>px; height:<?php echo ( 210 * $percent_height ); ?>px;"></div>
        <?php 
				}
				$current_day_number = date( 'd' ); 
				if( count( $orders ) > 0 && $orders[count( $orders ) - 1]->the_day != $current_day_number )
					$last_total = 0;
			}else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "weeks" ){
				if( count( $orders ) > 12 )
					$last_used_order_index = 1;
				else
					$last_used_order_index = 0;
					
				for( $i=12; $i > 0 && $last_used_order_index < count( $orders ); $i-- ){
					if( count( $orders ) > 11 || ( count( $orders ) >= $i ) ){
						$total = $orders[$last_used_order_index]->total;
						$last_used_order_index++;
					}else{
						$total = 0;
					}
					$last_total = $total;
					if( $highest_point > 0 )
						$percent_height = $total/$highest_point;
					else
						$percent_height = 0;
				?>
        <div class="ec_statistics_bar_item" style="margin-top:<?php echo ( 210 * ( 1 - $percent_height ) ); ?>px; height:<?php echo ( 210 * $percent_height ); ?>px;"></div>
        <?php 
				}
				$current_week_number = (integer) date( 'W', strtotime( '0 weeks' ) ); 
				if( count( $orders ) > 0 && $orders[count( $orders ) - 1]->the_week != $current_week_number )
					$last_total = 0;
			}else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "months" ){
				$last_used_order_index = 0;
				for( $i=11; $i > -1 && $last_used_order_index < count( $orders ); $i-- ){
					$current_month_number = date( 'n', strtotime( '-' . $i . ' months' ) ); 
					
					if( $orders[$last_used_order_index]->the_month == $current_month_number ){
						$total = $orders[$last_used_order_index]->total;
						$last_used_order_index++;
					}else{
						$total = 0;
					}
					$last_total = $total;
					if( $highest_point > 0 )
						$percent_height = $total/$highest_point;
					else
						$percent_height = 0;
				?>
        <div class="ec_statistics_bar_item" style="margin-top:<?php echo ( 210 * ( 1 - $percent_height ) ); ?>px; height:<?php echo ( 210 * $percent_height ); ?>px;"></div>
        <?php 
				}
				$current_month_number = date( 'n' ); 
				if( count( $orders ) > 0 && $orders[count( $orders ) - 1]->the_month != $current_month_number )
					$last_total = 0;
			}else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "years" ){
				$last_used_order_index = 0;
				for( $i=11; $i > -1 && $last_used_order_index < count( $orders ); $i-- ){
					$current_year_number = date( 'Y', strtotime( '-' . $i . ' years' ) ); 
					
					if( $orders[$last_used_order_index]->the_year == $current_year_number ){
						$total = $orders[$last_used_order_index]->total;
						$last_used_order_index++;
					}else{
						$total = 0;
					}
					$last_total = $total;
					if( $highest_point > 0 )
						$percent_height = $total/$highest_point;
					else
						$percent_height = 0;
				?>
        <div class="ec_statistics_bar_item" style="margin-top:<?php echo ( 210 * ( 1 - $percent_height ) ); ?>px; height:<?php echo ( 210 * $percent_height ); ?>px;"></div>
        <?php 
				}
				$current_year_number = date( 'Y' ); 
				if( count( $orders ) > 0 && $orders[count( $orders ) - 1]->the_year != $current_year_number )
					$last_total = 0;
			}?>
      </div>
      <div class="ec_statistics_dates">
        <?php if( !isset( $_GET['ec_stat'] ) || ( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "days" ) ){ ?>
        <div class="ec_statistics_date_first_item"><?php echo date( 'M d', strtotime( '-10 days' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M d', strtotime( '-8 days' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M d', strtotime( '-6 days' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M d', strtotime( '-4 days' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M d', strtotime( '-2 days' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M d', strtotime( '-0 days' ) ); ?></div>
        <?php }else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "weeks" ){ ?>
        <div class="ec_statistics_date_first_item"><?php echo date( 'M d', strtotime( '-10 weeks' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M d', strtotime( '-8 weeks' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M d', strtotime( '-6 weeks' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M d', strtotime( '-4 weeks' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M d', strtotime( '-2 weeks' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M d', strtotime( '-0 weeks' ) ); ?></div>
        <?php }else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "months" ){ ?>
        <div class="ec_statistics_date_first_item"><?php echo date( 'M, Y', strtotime( '-10 months' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M, Y', strtotime( '-8 months' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M, Y', strtotime( '-6 months' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M, Y', strtotime( '-4 months' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M, Y', strtotime( '-2 months' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'M, Y', strtotime( '-0 months' ) ); ?></div>
        <?php }else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "years" ){ ?>
        <div class="ec_statistics_date_first_item"><?php echo date( 'Y', strtotime( '-10 years' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'Y', strtotime( '-8 years' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'Y', strtotime( '-6 years' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'Y', strtotime( '-4 years' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'Y', strtotime( '-2 years' ) ); ?></div>
        <div class="ec_statistics_date_item"><?php echo date( 'Y', strtotime( '-0 years' ) ); ?></div>
        <?php }?>
      </div>
      <div class="ec_statistics_todate_label">
        <?php if( !isset( $_GET['ec_stat'] ) || ( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "days" ) ){ echo "Today"; }else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "weeks" ){ echo "This Week"; }else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "months" ){ echo "This Month"; }else if( isset( $_GET['ec_stat'] ) && $_GET['ec_stat'] == "years" ){ echo "This Year"; } ?>
      </div>
      <div class="ec_statistics_todate_value"><?php echo $GLOBALS['currency']->get_currency_display( $last_total ); ?></div>
      <div class="ec_statistics_todate_label2">Sales</div>
    </div>
  </div>
</div>



<div class="ec_statistics_section_title">
<div class="ec_statistics_section_title_padding">
<a href="#" onclick="ec_show_stats_section( 'ec_statistics_more' ); return false;" id="ec_statistics_more_expand" class="ec_payment_expand_button"></a>
<a href="#" onclick="ec_hide_stats_section( 'ec_statistics_more' ); return false;" id="ec_statistics_more_contract" class="ec_payment_contract_button"></a>Show More Statistics
</div>
</div>


    <div class="ec_statistics_row" id="ec_statistics_more">
        <div class="ec_statistics_quad2">
            <div class="ec_statistics_title_bar"><div class="ec_statistics_holder_square">Top 10 Viewed Products</div></div>
            <?php for( $i=0; $i<count( $top_products ); $i++ ){ ?>
            <div class="ec_statistics_lineitem<?php echo $i%2; ?>"><div class="ec_statistics_holder_square"><span class="ec_statistics_lineitem_label"><?php echo $top_products[$i]->title; ?></span><span class="ec_statistics_lineitem_value"><?php echo $top_products[$i]->views; ?> views</span></div></div>
            <?php }?>
        </div>
        <div class="ec_statistics_quad3">
            <div class="ec_statistics_title_bar"><div class="ec_statistics_holder_square">Top 10 Customers</div></div>
            <?php for( $i=0; $i<count( $top_customers ); $i++ ){ ?>
            <div class="ec_statistics_lineitem<?php echo $i%2; ?>"><div class="ec_statistics_holder_square"><span class="ec_statistics_lineitem_label"><?php echo $top_customers[$i]->billing_first_name . " " . $top_customers[$i]->billing_last_name; ?></span><span class="ec_statistics_lineitem_value"><?php echo $GLOBALS['currency']->get_currency_display( $top_customers[$i]->total ); ?></span></div></div>
            <?php }?>
        </div>
    </div>





  <div class="ec_stats_section">
    <div class="ec_stats_heading">Setup</div>
    <div class="ec_stats_button_container">
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/setup.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Basic Setup</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-settings"> 
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/settings.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Basic Settings</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-setup">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/advancedsettings.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Advanced Settings</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=payment-settings">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/payment.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Payment Setup</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-language">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/language.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Language Editor</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=woo-importer">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/woo-import.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Import From Woo</div>
      </div>
    </div>
  </div>
  
  
  
   <div class="ec_stats_section">
    <div class="ec_stats_heading">Design</div>
    <div class="ec_stats_button_container">
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=colorize-easycart">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/colorize.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Colorize</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-setup"> 
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/advancedesign.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Advanced Design</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=design-management">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/designfiles.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Design Files</div>
      </div>
      <div class="ec_stats_button"><a href="http://themeforest.net/collections/3385661-wp-easycart-theme-collection?ref=wpeasycart" target="_blank">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/theme-forest.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Partner Themes</div>
      </div>
      <div class="ec_stats_button"><a href="http://www.wpeasycart.com/videos/V3%20admin%20sidebar.mp4" target="_blank">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/design-tutorial.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Design Tutorial</div>
      </div>
      <div class="ec_stats_button"><a href="http://developers.wpeasycart.com/category/designer-articles/" target="_blank">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/designer-articles.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Designer Articles</div>
      </div>
    </div>
  </div>
  
  
  
   <div class="ec_stats_section">
    <div class="ec_stats_heading">Management</div>
    <div class="ec_stats_button_container">
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/storeadmin.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Store Admin</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=products">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/products.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Products</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=orders">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/orders.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Orders</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=users">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/accounts.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Accounts</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=shipping">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/shipping.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Shipping</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=taxes">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/taxes.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Taxes</div>
      </div>
    </div>
  </div>
  
  <div class="ec_stats_section">
    <div class="ec_stats_heading">Marketing Tools</div>
    <div class="ec_stats_button_container">
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=coupons">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/coupons.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Coupons</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=promotions">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/promotions.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Promotions</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=newsletter">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/subscribers.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Subscribers</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=affiliates">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/affiliates.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Affiliate Rules</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&store-setup&ec_panel=google-merchant">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/google-merchant.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Google Merchant</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&store-setup&ec_panel=mymail-integration">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/mymail.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">MyMail Integration</div>
      </div>
    </div>
  </div>
  
  
  
   <div class="ec_stats_section">
    <div class="ec_stats_heading">Support</div>
    <div class="ec_stats_button_container">
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=store-status"> 
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/status.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Store Status</div>
      </div>
      <div class="ec_stats_button"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=backup-store">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/backup.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Store Backup</div>
      </div>
      <div class="ec_stats_button"><a href="http://forums.wpeasycart.com/" target="_blank">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/forums.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Online Forums</div>
      </div>
      <div class="ec_stats_button"><a href="http://www.wpeasycart.com/video-tutorials" target="_blank"> 
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/video.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Video Tutorials</div>
      </div>
      <div class="ec_stats_button"><a href="http://v3docs.wpeasycart.com" target="_blank">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/onlinedocs.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Online Docs</div>
      </div>
      <div class="ec_stats_button"><a href="http://www.wpeasycart.com/support-ticket/" target="_blank">
        <div class="ec_stats_button_img"><img src="<?php echo plugins_url('../images/dashboard_buttons/ticket.png', __FILE__); ?>" /></div></a>
        <div class="ec_stats_button_label">Support Ticket</div>
      </div>
    </div>
  </div>
  
  
  

<div style="clear:both;"></div>

<script>
function ec_show_stats_section( section ){
	jQuery( '#' + section ).slideDown( "slow" );
	jQuery( '#' + section + "_expand" ).hide( );
	jQuery( '#' + section + "_contract" ).show( );
}

function ec_hide_stats_section( section ){
	jQuery( '#' + section ).slideUp( "slow" );
	jQuery( '#' + section + "_expand" ).show( );
	jQuery( '#' + section + "_contract" ).hide( );
}

jQuery( '#' + "ec_statistics_more" ).slideUp( 0);
jQuery( '#' + "ec_statistics_more_expand" ).show( );
jQuery( '#' + "ec_statistics_more_contract" ).hide( );

</script>
