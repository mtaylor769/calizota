<html>


<head>


<title>Gift Card -<?php echo $giftcard_id; ?></title>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<style type='text/css'>


<!--


.style20 {


	font-family: Arial, Helvetica, sans-serif;


	font-weight: bold;


	font-size: 12px;


}


.style22 {


	font-family: Arial, Helvetica, sans-serif;


	font-size: 12px;


}


.style24 {


	font-family: Arial, Helvetica, sans-serif;


	font-size: 12px;


}


.style24 img{


	max-width:400px;


}


-->


</style>


</head>


<body>


<table width='725' border='0' align='center'>


  <tr>


    <td colspan='4' align='left' class='style22'>
    
    	<img src='<?php echo $email_logo_url; ?>' style="max-height:250px; max-width:100%; height:auto;">
    
    </td>


  </tr>


  <tr>


    <?php if( get_option( 'ec_option_show_image_on_receipt' ) ){ ?>
    <td width='400' class='style24'><?php $ec_orderdetail->display_image( "large" ); ?></td>



    <td width="25"></td>
	<?php }?>


    <td width='300' align='left' class='style22' colspan="2"><div class="style20">


        <?php $ec_orderdetail->display_gift_card_id( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_card_id' ) ); ?>


      </div>


      <div>&nbsp;&nbsp;&nbsp;</div>


      <div>


        <?php $ec_orderdetail->display_title(); ?>


      </div>


      <div>


        <?php $ec_orderdetail->display_gift_card_message( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_message' ) ); ?>


      </div>


      <div>


        <?php $ec_orderdetail->display_gift_card_from_name( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_from' ) ); ?>


      </div>


      <div>


        <?php $ec_orderdetail->display_gift_card_to_name( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_to' ) ); ?>


      </div></td>


  </tr>


</table>


</body>


</html>