<?php
/*
 * Component of the ftp module
 */
 

if(preg_match("/t/",$server_home['access_rights']) > 0)
{
	$module_buttons = array();

	
$module_buttons = array(
		"<a class='monitorbutton' href='?m=ftp&amp;home_id=".$server_home['home_id']."'>
			<img src='" . check_theme_image("images/ftp.png") . "' title='". get_lang("ftp") ."'>
			<span>". get_lang("ftp") ."</span>
		</a>"
	);

}
else
	$module_buttons = array();
?>
