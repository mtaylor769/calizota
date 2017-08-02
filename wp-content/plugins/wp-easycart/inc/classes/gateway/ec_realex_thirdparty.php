<?php
class ec_realex_thirdparty extends ec_third_party{
	
	public function display_form_start( ){
		$realex_merchant_id = get_option( 'ec_option_realex_thirdparty_merchant_id' );
		$realex_secret = get_option( 'ec_option_realex_thirdparty_secret' );
		$realex_currency = get_option( 'ec_option_realex_thirdparty_currency' );
		
		$realex_timestamp = strftime("%Y%m%d%H%M%S");
		mt_srand((double)microtime()*1000000);
		
		$realex_order_id = $this->order_id;
		$realex_total = number_format( $this->order->grand_total * 100, 0, '', '' );
		
		$tmp = "$realex_timestamp.$realex_merchant_id.$realex_order_id.$realex_total.$realex_currency";
		
		$md5hash = strtolower( md5( $tmp ) );
		$tmp_md5 = "$md5hash.$realex_secret";
		$md5hash = md5($tmp_md5);
		
		$sha1hash = strtolower( sha1( $tmp ) );
		$tmp_sha1 = "$sha1hash.$realex_secret";
		$sha1hash = sha1($tmp_sha1);
		
		$realex_account = "redirect";
		
		echo "<form action=\"https://epage.payandshop.com/epage.cgi\" method=\"post\">";
		echo "<input name=\"MERCHANT_ID\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_merchant_id . "\" />";
		echo "<input name=\"ORDER_ID\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_order_id . "\" />";
		echo "<input name=\"AMOUNT\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_total . "\" />";
		echo "<input name=\"ACCOUNT\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_account . "\" />";
		echo "<input name=\"CURRENCY\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_currency . "\" />";
		echo "<input name=\"TIMESTAMP\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_timestamp . "\" />";
		echo "<input name=\"MD5HASH\" id=\"cmd\" type=\"hidden\" value=\"" . $md5hash . "\" />";
		echo "<input name=\"SHA1HASH\" id=\"cmd\" type=\"hidden\" value=\"" . $sha1hash . "\" />";
		echo "<input name=\"AUTO_SETTLE_FLAG\" id=\"cmd\" type=\"hidden\" value=\"1\" />";
		echo "<input name=\"RETURN_TSS\" id=\"cmd\" type=\"hidden\" value=\"1\" />";
		echo "<input name=\"SHIPPING_CODE\" id=\"cmd\" type=\"hidden\" value=\"" . $this->order->shipping_zip . "\" />";
		echo "<input name=\"SHIPPING_CO\" id=\"cmd\" type=\"hidden\" value=\"" . $this->mysqli->get_country_code( $this->order->shipping_country ) . "\" />";
		echo "<input name=\"BILLING_CODE\" id=\"cmd\" type=\"hidden\" value=\"" . $this->order->billing_zip . "\" />";
		echo "<input name=\"BILLING_CO\" id=\"cmd\" type=\"hidden\" value=\"" . $this->mysqli->get_country_code( $this->order->billing_country ) . "\" />";
	}
	
	public function display_auto_forwarding_form( ){
		$realex_merchant_id = get_option( 'ec_option_realex_thirdparty_merchant_id' );
		$realex_secret = get_option( 'ec_option_realex_thirdparty_secret' );
		$realex_currency = get_option( 'ec_option_realex_thirdparty_currency' );
		
		$realex_timestamp = strftime("%Y%m%d%H%M%S");
		mt_srand((double)microtime()*1000000);
		
		$realex_order_id = $this->order_id;
		$realex_total = number_format( $this->order->grand_total * 100, 0, '', '' );
		
		$tmp = "$realex_timestamp.$realex_merchant_id.$realex_order_id.$realex_total.$realex_currency";
		
		$md5hash = md5($tmp);
		$tmp_md5 = "$md5hash.$realex_secret";
		$md5hash = md5($tmp_md5);
		
		$sha1hash = sha1($tmp);
		$tmp_sha1 = "$sha1hash.$realex_secret";
		$sha1hash = sha1($tmp_sha1);
		
		$realex_account = "redirect";
		
		echo "<form action=\"https://epage.payandshop.com/epage.cgi\" method=\"post\" name=\"ec_realex_thirdparty_auto_form\">";
		echo "<input name=\"MERCHANT_ID\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_merchant_id . "\" />";
		echo "<input name=\"ORDER_ID\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_order_id . "\" />";
		echo "<input name=\"AMOUNT\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_total . "\" />";
		echo "<input name=\"ACCOUNT\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_account . "\" />";
		echo "<input name=\"CURRENCY\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_currency . "\" />";
		echo "<input name=\"TIMESTAMP\" id=\"cmd\" type=\"hidden\" value=\"" . $realex_timestamp . "\" />";
		echo "<input name=\"MD5HASH\" id=\"cmd\" type=\"hidden\" value=\"" . $md5hash . "\" />";
		echo "<input name=\"SHA1HASH\" id=\"cmd\" type=\"hidden\" value=\"" . $sha1hash . "\" />";
		echo "<input name=\"AUTO_SETTLE_FLAG\" id=\"cmd\" type=\"hidden\" value=\"1\" />";
		echo "<input name=\"RETURN_TSS\" id=\"cmd\" type=\"hidden\" value=\"1\" />";
		echo "<input name=\"SHIPPING_CODE\" id=\"cmd\" type=\"hidden\" value=\"" . $this->order->shipping_zip . "\" />";
		echo "<input name=\"SHIPPING_CO\" id=\"cmd\" type=\"hidden\" value=\"" . $this->mysqli->get_country_code( $this->order->shipping_country ) . "\" />";
		echo "<input name=\"BILLING_CODE\" id=\"cmd\" type=\"hidden\" value=\"" . $this->order->billing_zip . "\" />";
		echo "<input name=\"BILLING_CO\" id=\"cmd\" type=\"hidden\" value=\"" . $this->mysqli->get_country_code( $this->order->billing_country ) . "\" />";
		echo "</form>";
		echo "<SCRIPT LANGUAGE=\"Javascript\">document.ec_realex_thirdparty_auto_form.submit();</SCRIPT>";
	}
	
}
?>