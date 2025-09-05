<?php
/*
 * Component of the litefm module
 */
 

if(preg_match("/f/",$server_home['access_rights']) > 0)
{
	$module_buttons = array(
		"<a class='monitorbutton' href='?m=litefm&amp;home_id=".$server_home['home_id']."'>
			<img src='" . check_theme_image("images/filemanager.png") . "' title='". get_lang("file_manager") ."'>
			<span>". get_lang("file_manager") ."</span>
		</a>"
	);
}
else
	$module_buttons = array();
?>