<?php
/**
 * Plugin Name: WP EasyCart Administration
 * Plugin URI: http://www.wpeasycart.com
 * Description: This is the administration software for the WP EasyCart plugin found on WordPress.org/plugins/wp-easycart.
 * Version: 3.1.6
 * Author: Level Four Development, llc
 * Author URI: http://www.wpeasycart.com
 *
 * This program is free to install and use on a site for a 14 day free trial.
 * Each site requires a license for live use and must be purchased through the WP EasyCart website.
 *
 * @package wpeasycart
 * @version 3.1.6
 * @author WP EasyCart <sales@wpeasycart.com>
 * @copyright Copyright (c) 2012, WP EasyCart
 * @link http://www.wpeasycart.com
 */
 
define( 'EC_AD_PLUGIN_NAME', 'WP EasyCart Administration');
define( 'EC_AD_PLUGIN_DIRECTORY', 'wp-easycart-admin');
define( 'EC_AD_CURRENT_VERSION', '3.1.6' );


function wp_easycart_load_admin( $domain, $userlogin, $reqid, $is_secure, $startpage ){
	
	
	echo "<object id=\"FlashID\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"1210\" height=\"748\">
          <param name=\"movie\" value=\"" . plugins_url( '/wp-easycart-admin/administration_wpedition.swf?ver=' . EC_AD_CURRENT_VERSION ) . "\" />
          <param name=\"quality\" value=\"high\" />
          <param name=\"wmode\" value=\"transparent\" />
          <param name=\"flashvars\" value=\"siteurl=" . $domain . "&username=" . $userlogin . "&reqid=" . $reqid . "&issecure=" . $is_secure . "&startpage=" . $startpage . "\" />
          <param name=\"swfversion\" value=\"10.0.0.0\" />
          <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
          <param name=\"expressinstall\" value=\"" . plugins_url( '/wp-easycart-admin/scripts/expressInstall.swf' ) . "\" />
          <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
          <!--[if !IE]>-->
          <object type=\"application/x-shockwave-flash\" data=\"" . plugins_url( '/wp-easycart-admin/administration_wpedition.swf?ver=' . EC_AD_CURRENT_VERSION ) . "\" width=\"1210\" height=\"748\">
            <!--<![endif]-->
            <param name=\"quality\" value=\"high\" />
            <param name=\"wmode\" value=\"transparent\" />
            <param name=\"swfversion\" value=\"10.0.0.0\" />
            <param name=\"expressinstall\" value=\"" . plugins_url( '/wp-easycart-admin/scripts/expressInstall.swf' ) . "\" />
            <param name=\"flashvars\" value=\"siteurl=" . $domain . "&username=" . $userlogin . "&reqid=" . $reqid . "&issecure=" . $is_secure . "&startpage=" . $startpage . "\" />
            <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
            <div>
              <h4>Content on this page requires you 'Allow Flash' to run.  Please click the graphic below to allow the administrative console software to run.</h4>
              <p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"" . plugins_url( '/wp-easycart-admin/scripts/run-store-admin.png') . "\" alt=\"Get Adobe Flash player\" width=\"400\" height=\"125\" /></a></p>
            </div>
            <!--[if !IE]>-->
          </object>
          <!--<![endif]-->
        </object>";	
}

require 'plugin-updates/plugin-update-checker.php';
$MyUpdateChecker = new PluginUpdateChecker(
    'http://support.wpeasycart.com/air/wp-easycart-admin.json',
    __FILE__,
    'wp-easycart-admin'
);

?>