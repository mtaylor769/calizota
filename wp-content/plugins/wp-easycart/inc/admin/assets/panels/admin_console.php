<?php
//get admin request ID
global $wpdb;
$admin_users = $wpdb->get_results( "SELECT * FROM ec_user WHERE ec_user.user_level = 'admin'" );
$admin_password_hash = "";
foreach( $admin_users as $user ){
	if( $user->user_level == "admin" ){
		$admin_password_hash = $user->password;
	}
}
$reqid = $admin_password_hash;

//get store startup page from url variable
if(isset($_GET["ec_admin_panel"])){
   $startpage = $_GET["ec_admin_panel"];
}
else{
   $startpage = '';
}

//get the site url without http:// https:// or www.
if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
	$https_class = new WordPressHTTPS( );
	$input = $https_class->makeUrlHttps( site_url( ) );
	if(substr($input, -1) == '/') {
		$input = substr($input, 0, -1);
	}
}else{
	$input = site_url();
}

if (!preg_match('#^http(s)?://#', $input)) {
    $input = 'http://' . $input;
}
$urlParts = parse_url($input);

if( isset( $urlParts['path'] ) && isset( $urlParts['port'] ) ){
	$domain = $urlParts['host'] . ":" . $urlParts['port'] . $urlParts['path'];
}else if( isset( $urlParts['path'] ) ){
	$domain = $urlParts['host'] . $urlParts['path'];
}else{
	$domain = $urlParts['host'];
}


//get current wordpress user
$current_user = wp_get_current_user();
$userlogin = $current_user->user_login;
$useremail = $current_user->user_email;

//check if using https://
$is_secure = 'false';
if( is_ssl( ) ){
	$is_secure = 'true';
}

?>

<script type="text/javascript">
jQuery( document ).bind( 'keydown', function( e ){
	e.stopImmediatePropagation();
});
</script>

<?php if( function_exists( "wp_easycart_load_admin" ) ){ ?>  
<table align="left" width="95%" border="0" cellspacing="0" cellpadding="0">
    <tr id="ec_wordpress_content">

      <td width="100%" colspan="2" align="center"><?php wp_easycart_load_admin( $domain, $userlogin, $reqid, $is_secure, $startpage ); ?></td>
     
      <td height="10" colspan="2"></td>
    </tr>
</table>
<?php }else{ ?>
<div class="admin_content_margin">
<br />
<table align="left" width="95%" border="0" cellspacing="0" cellpadding="0">
    <tr id="ec_wordpress_content">
    <tr>
      <td height="55" colspan="2"><div class="ec_admin_page_title">WordPress EasyCart Administrative Console</div>
        <br />
        
        <p>Available for: <strong>WordPress</strong>, <strong>Desktops (PC or MAC)</strong>, <strong>Tablets (iPad or Android)</strong>, and <strong>Android Phones</strong>.</p>
        <p><em>The administrative console is not downloaded or associated with WordPress and/or it's site. This software is downloaded via 3rd party systems such as Apple iTunes, the Google Play store, and WP Easy Cart.</em></p>
      </td>
    </tr>
    <tr>
      <td height="10" colspan="2"></td>
    </tr>
    <tr>
      <td height="25" class="platformheading"><div class="ec_admin_page_title">EasyCart Admin for WordPress</div></td>
      <td height="25" class="platformheadingimage"><img src="<?php echo plugins_url('../images/wordpress_icon.jpg', __FILE__); ?>" width="38" height="40" /></td>
    </tr>
    <tr>
      <td height="10" colspan="2"></td>
    </tr>
    
      <td width="600" align="center"><img src="<?php echo plugins_url('../images/wordpress_easycart.jpg', __FILE__); ?>" alt="iPad Administration Console" width="600" height="360" /></td>
      <td  style="padding: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;
        <h3><strong>How to Install: </strong></h3>
        <p><strong>1. </strong><a href="http://wpeasycart.com/air/wp-easycart-admin.zip">Click this link</a> to download the WP EasyCart Administration Plugin.<br />
          <strong>Note:</strong> MAC users may have an option set in Safari that automatically opens the zip. You should disable this option: Uncheck &quot;Open Safe files after downloading&quot; in Safari preferences.</p>
        <p><strong>2. </strong><a href="plugin-install.php?tab=upload">Upload Plugin Here</a> and click 'Choose File' then select the plugin from your downloads. Once selected, click install now.</p>
        <p><strong>3. </strong>Once Installed, this section will be replaced with an embedded version of the WP EasyCart Administration Software.</p>
        <p>&nbsp;</p>
        <p><strong>Need More Help?</strong></p>
        <p><a href="http://www.wpeasycart.com/support-ticket/" target="_blank">Submit a ticket</a> with the url you are using and an agent will get back to you shortly.</p>
        <br />
        <br /></td></tr></table>
      <?php } ?>
<div class="admin_content_margin">   
<table align="left" width="95%" border="0" cellspacing="0" cellpadding="0">
    <tr id="ec_wordpress_content">
    <tr>
      <td height="10" colspan="2"></td>
    </tr>
    <tr>
      <td height="25" class="platformheading"><div class="ec_admin_page_title">Desktop and Laptop Users</div></td>
      <td height="25" class="platformheadingimage"><img src="<?php echo plugins_url('../images/windows-apple-linux.png', __FILE__); ?>" width="120" height="40" /></td>
    </tr>
    <tr>
      <td height="10" colspan="2"></td>
    </tr>
    <tr id="ec_desktop_content">
      <td width="600" align="center"><script type="text/javascript" src="<?php echo plugins_url('../../AIR_badge/swfobject.js', __FILE__); ?>"></script> 
        
        <!-- BEGIN EMBED CODE --> 
        
        <!-- IMPORTANT: Make sure you also copy the swfobject script tag from the head above -->
        
        <div id="flashcontent" style="width:600px; height:360px;"> <strong>Please upgrade your Flash Player</strong> This is the content that would be shown if the user does not have Flash Player 10.0.0 or higher installed. </div>
        <script type="text/javascript">
                // <![CDATA[
                
                // version 9.0.115 or greater is required for launching AIR apps.
                var so = new SWFObject("<?php echo plugins_url('../../AIR_badge/AIRInstallBadge.swf', __FILE__); ?>", "Badge", "600", "360", "10.0.0", "#FFFFFF");
                so.useExpressInstall('<?php echo plugins_url('../../AIR_badge/expressinstall.swf', __FILE__); ?>');
                
                // these parameters are required for badge install:
                so.addVariable("airversion", "3.7"); // version of AIR runtime required
                so.addVariable("appname", "WP EasyCart Admin Console"); // application name to display to the user
                so.addVariable("appurl", "https://www.wpeasycart.com/air/wpadmin.air"); // absolute URL (beginning with http or https) of the application ".air" file
                
                // these parameters are required to support launching apps from the badge (but optional for install):
                so.addVariable("appid", "com.wpeasycart.admin"); // the qualified application ID (ex. com.gskinner.air.MyApplication)
                so.addVariable("pubid", ""); // publisher id
                
                // this parameter is required in addition to the above to support upgrading from the badge:
                so.addVariable("appversion", "1.1.0"); // AIR application version
                
                // these parameters are optional:
                so.addVariable("image", "<?php echo plugins_url('../../AIR_badge/DemoImage.jpg', __FILE__); ?>"); // URL for an image (JPG, PNG, GIF) or SWF to display in the badge (205px wide, 170px high)
                so.addVariable("appinstallarg", "installed from web"); // passed to the application when it is installed from the badge
                so.addVariable("applauncharg", "launched from web"); // passed to the application when it is launched from the badge
                so.addVariable("helpurl", "http://v3docs.wpeasycart.com/"); // optional url to a page containing additional help, displayed in the badge's help screen
                so.addVariable("hidehelp", "false"); // hides the help icon if "true"
                so.addVariable("skiptransition", "true"); // skips the initial transition if "true"
                so.addVariable("titlecolor", "#4b9725"); // changes the color of titles
                so.addVariable("buttonlabelcolor", "#4b9725"); // changes the color of the button label
                so.addVariable("appnamecolor", "#4b9725"); // changes the color of the application name if the image is not specified or loaded
                
                // these parameters allow you to override the default text in the badge:
                // supported strings: str_error, str_err_params, str_err_airunavailable, str_err_airswf, str_loading, str_install, str_launch, str_upgrade, str_close, str_launching, str_launchingtext, str_installing, str_installingtext, str_tryagain, str_beta3, str_beta3text, str_help, str_helptext
                so.addVariable("str_err_airswf", "<u>Running locally?</u><br/><br/>The AIR proxy swf won't load properly when this demo is run from the local file system."); // overrides the error text when the AIR proxy swf fails to load
                
                so.write("flashcontent");
                
                // ]]>
            </script> 
        
        <!-- END EMBED CODE --></td>
      <td style="padding: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;
        <p><strong>How to Install: </strong></p>
        <p><strong>1. </strong>Simply click the '<em><strong>Install Now</strong></em>' on the left image and the automatic installer will try to install Adobe AIR and the Administrative Console. Please allow a few moments for it to install.</p>
        <p>Note: If that process fails or the automatic installer does not work, you can try our second method.</p>
        <p><strong>2. </strong> Try manually installing by following these <a href="http://www.wpeasycart.com/air-install" target="_blank">2 steps to install.</a></p>
        <p>&nbsp;</p>
        <p><strong>Need More Help?</strong></p>
        <p>Try visiting our <a href="http://www.wpeasycart.com/video-tutorials/" target="_blank">Video Tutorial</a> on installing and logging into the admin console, or our <a href="http://v3docs.wpeasycart.com/3.0.0/administration/installing_console.php" target="_blank">Online Documentation</a>.</p>
        <p>Still need more help? Simply <a href="http://www.wpeasycart.com/support-ticket/" target="_blank">submit a ticket</a> with the url you are using and an agent will get back to you shortly.</p></td>
    </tr>
    <tr>
      <td width="600">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" class="platformheading"><div class="ec_admin_page_title">iPad Users</div></td>
      <td height="25" class="platformheadingimage"><img src="<?php echo plugins_url('../images/apple.png', __FILE__); ?>" width="40" height="40" /></td>
    </tr>
    <tr>
      <td height="10" colspan="2"></td>
    </tr>
    <tr id="ec_ipad_content">
      <td width="600" align="center"><a href="https://itunes.apple.com/us/app/wp-easycart/id616846878?mt=8" target="_blank"><img src="<?php echo plugins_url('../images/ipad_mockup1.jpg', __FILE__); ?>" alt="iPad Administration Console" width="250" height="196" /></a></td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <p><strong>How to Install: </strong></p>
        <p><strong>1. </strong>Simply click the iPad to visit iTunes and download the app from the Apple iTunes store.</p>
        <p><strong><br />
          Need More Help?</strong></p>
        <p>Try visiting our <a href="http://www.wpeasycart.com/video-tutorials/" target="_blank">Video Tutorial</a> on installing and logging into the admin console, or our <a href="http://v3docs.wpeasycart.com/3.0.0/administration/installing_console.php" target="_blank">Online Documentation</a>.</p>
        <p>Still need more help? Simply <a href="http://www.wpeasycart.com/support-ticket/" target="_blank">submit a ticket</a> with the url you are using and an agent will get back to you shortly.</p></td>
    </tr>
    <tr>
      <td width="600">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" class="platformheading"><div class="ec_admin_page_title">Android Tablet and Phone Users</div></td>
      <td height="25" class="platformheadingimage"><img src="<?php echo plugins_url('../images/android_vector.png', __FILE__); ?>" width="38" height="40" /></td>
    </tr>
    <tr>
      <td colspan="2" height="10"></td>
    </tr>
    <tr id="ec_android_content">
      <td width="600" align="center"><a href="https://play.google.com/store/search?q=wp+easycart&amp;c=apps&amp;feature=spelling" target="_blank"><img src="<?php echo plugins_url('../images/android_tablet_phone.jpg', __FILE__); ?>" width="250" height="205" /></a></td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <p><strong>How to Install: </strong></p>
        <p><strong>1. </strong>Simply click the tablet to visit the Google Play network and download the app from the Play app store.</p>
        <p><br />
          <strong>Need More Help?</strong></p>
        <p>Try visiting our <a href="http://www.wpeasycart.com/video-tutorials/" target="_blank">Video Tutorial</a> on installing and logging into the admin console, or our <a href="http://v3docs.wpeasycart.com/3.0.0/administration/installing_console.php" target="_blank">Online Documentation</a>.</p>
        <p>Still need more help? Simply <a href="http://www.wpeasycart.com/support-ticket/" target="_blank">submit a ticket</a> with the url you are using and an agent will get back to you shortly.</p>
        <p>&nbsp; </p></td>
    </tr>
    <tr>
      <td width="600">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>

<p style="float:left; width:100%">The WordPress EasyCart runs best on its administrative console software, but we do offer a <em><strong>free editor</strong></em> which can be accessed here: <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin">Simple Store Manager</a></p>

<script type="text/javascript">
function ec_admin_open( panel ){
	jQuery( '#' + panel + "_content" ).show('blind');
}
</script>