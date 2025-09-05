<?php
/*
 * Component of the editconfigfiles module
 */

if(!empty($server_xml->configuration_files)) {
	$module_buttons = array(
		"<a href=\"?m=editconfigfiles&home_id=".(int)$server_home['home_id']."\" class=\"monitorbutton\">
			<img src='" . check_theme_image("images/editconfig.png") . "' title='". get_lang("edit_configuration_files") ."'>
			<span>". get_lang("edit_configuration_files") ."</span>
		</a>"
	);
}
else
	$module_buttons = array();
?>