<?php
/*
 * Component of the user_games module
 */
 
$module_buttons = array(
		"<a class='monitorbutton' href='?m=user_games&amp;p=edit&amp;home_id=".$server_home['home_id']."'>
			<img src='" . check_theme_image("images/edit.png") . "' title='". get_lang("edit") ."'>
			<span>". get_lang("edit") ."</span>
		</a>"
);

if(preg_match("/c/",$server_home['access_rights'])){
	if( isset($server_xml->custom_fields) ) {
		$module_buttons[] = "<a href=\"?m=user_games&p=custom_fields&home_id=".$server_home['home_id']."\" class=\"monitorbutton\">
						<img src='" . check_theme_image("images/customfields.png") . "' title='". get_lang("custom_fields") ."'>
						<span>". get_lang("custom_fields") ."</span>
					</a>";
	}
}
?>