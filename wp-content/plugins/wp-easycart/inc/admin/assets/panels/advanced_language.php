<?php

$validate = new ec_validation; 
$license = new ec_license;
$language = new ec_language( );
$language->update_language_data( ); //Do this to update the database if a new language is added

if( !get_option( 'ec_option_use_seperate_language_forms' ) )
	update_option( 'ec_option_use_seperate_language_forms', 1 );
	
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "advanced-language" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "update_language" && isset( $_POST['ec_option_language '] ) ){
	ec_update_language_file( $language );

}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "advanced-language" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "update-selected-language" && isset( $_POST['ec_option_language'] ) ){
	update_option( 'ec_option_language', $_POST['ec_option_language'] );

}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "advanced-language" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "delete-language" && isset( $_GET['ec_language'] ) ){
	$language->remove_language( $_GET['ec_language'] );

}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "advanced-language" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "add-new-language" && isset( $_POST['ec_option_add_language'] ) ){
	$language->add_new_language( $_POST['ec_option_add_language'] );
}

?>
<?php 

if( isset( $_GET['dismiss_lite_banner'] ) ){
	update_option( 'ec_option_show_lite_message', '0' );	
}

?>

<?php if(isset($_POST['isupdate'])) { ?>
<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Settings saved.</strong></p></div>
<?php }?>

<div class="ec_admin_page_title">Add/Remove Languages</div>
<div class="ec_adin_page_intro">Please start by adding languages you need or removing those that you don't. Adding languages increases your php memory and you should limit the language used as much as possible.</div>

<form method="post" action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-language&ec_action=add-new-language" style="float:left; width: 100%; margin-bottom:25px;">

<div class="ec_admin_dropdown_wide">Add Language:<select name="ec_option_add_language" id="ec_option_add_language">
	<?php 
	$add_count = 0;
	$language_file_list = $language->get_language_file_list( );
	$languages = $language->get_languages_array( );
	$language_data = $language->get_language_data( );
    for( $i=0; $i<count( $language_file_list ); $i++ ){ 
        $file_name = $language_file_list[$i];
		if( !in_array( $file_name, $languages ) ){
    ?>
        <option value="<?php echo $file_name; ?>" <?php if( get_option( 'ec_option_language' ) == $file_name ) echo ' selected'; ?>><?php echo $language_file_list[$i]; ?></option>
    <?php
		$add_count++;
		}
	}
	if( $add_count == 0 ){ ?>
    <option value="">No New Languages</option>
    <?php } ?>
    </select> 
    <?php if( $add_count > 0 ){ ?>
    <input type="submit" value="Add" />
    <?php }?>
</div>

</form>

<div class="ec_admin_page_title">Current Language List</div>

<?php foreach( $language_data as $key => $data ){ ?>
<div class="ec_setting_row ec_language_edit_row">
	<span class="ec_setting_row_label"><?php echo $data->label; ?> | <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-language&ec_action=delete-language&ec_language=<?php echo $key; ?>">delete </a></span>
</div>
<?php } ?>

<div class="ec_language_spacer"></div>

<div class="ec_admin_page_title">Advanced Language Editor</div>
<div class="ec_adin_page_intro">This page allows you to change every word in the EasyCart system. This will allow you to change text throughout the site to fit your needs, or completely convert into a whole new language. To change between existing languages, select the language from below. To add a whole new language, go to the /wp-content/plugins/wp-easycart/inc/language/ and duplicate and rename a text file. Once you add to the language folder, add it to the list above. You can either edit the text file first, or upload and refresh this page.</div>

<form method="post" action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-language&ec_action=update-selected-language">

<div class="ec_admin_dropdown_wide">Selected Language:<select name="ec_option_language" id="ec_option_language">
	<?php 
    for( $i=0; $i<count( $languages ); $i++ ){ 
        $file_name = $languages[$i];
    ?>
        <option value="<?php echo $file_name; ?>" <?php if( get_option( 'ec_option_language' ) == $file_name ) echo ' selected'; ?>><?php echo $language_data->{$file_name}->label; ?></option>
    <?php }?>
    </select> <input type="submit" value="Update" />
</div>

</form>

<?php 
$file_name = get_option( 'ec_option_language' );
?>

<div class="ec_language_holder" id="<?php echo $file_name; ?>">
	<div class="ec_language_header"><?php echo $language_data->{$file_name}->label; ?></div>
    
    <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-language&ec_action=export-language&ec_language=<?php echo $file_name; ?>" class="ec_export_button">Export <?php echo $language_data->{$file_name}->label; ?> File</a>
    
	<?php
	foreach( $language_data->{$file_name}->options as $key_section => $language_section ){
	$section_label = $language_section->label;
	?>
    
    <form method="post" action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-language&ec_action=update_language">
    <input type="hidden" name="file_name" value="<?php echo $file_name; ?>" />
	<input type="hidden" name="key_section" value="<?php echo $key_section; ?>" />
    
    <div class="ec_language_section_title"><div class="ec_language_section_title_padding"><a href="#" onclick="ec_show_language_section( '<?php echo $file_name . "_" . $key_section; ?>' ); return false;" id="<?php echo $file_name . "_" . $key_section; ?>_expand" class="ec_language_expand_button"></a><a href="#" onclick="ec_hide_language_section( '<?php echo $file_name . "_" . $key_section; ?>' ); return false;" id="<?php echo $file_name . "_" . $key_section; ?>_contract" class="ec_language_contract_button"></a><?php echo $section_label; ?></div></div>
    <div class="ec_language_section_holder" id="<?php echo $file_name . "_" . $key_section; ?>">
    	<?php
		foreach( $language_section->options as $key => $language_item ){
		$title = $language_item->title;
		$value = $language_item->value;
		?>
        <div class="ec_language_row_holder"><span class="ec_language_row_label"><?php echo $title; ?>: </span><span class="ec_language_row_input"><input name="ec_language_field[<?php echo $key; ?>]" type="text" value="<?php echo htmlspecialchars( stripslashes( $value ), ENT_QUOTES, "UTF-8" ); ?>" style="width:250px;" /></span></div>
        <?php }?>
    </div>
    
    <input type="hidden" value="<?php echo get_option( 'ec_option_language' ); ?>" name="ec_option_language" />
    <input type="hidden" value="1" name="isupdate" />
<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
    </form>
    
    <?php }?>
    
</div>

<script>

function ec_show_language_section( section ){
	jQuery( '#' + section ).slideDown( "slow" );
	jQuery( '#' + section + "_expand" ).hide( );
	jQuery( '#' + section + "_contract" ).show( );
}

function ec_hide_language_section( section ){
	jQuery( '#' + section ).slideUp( "slow" );
	jQuery( '#' + section + "_expand" ).show( );
	jQuery( '#' + section + "_contract" ).hide( );
}

</script>