<?php
/*
 * Component of the fast_download module
 */
if(preg_match("/d/",$server_home['access_rights']) > 0)
{
	$module_buttons = array(
		"<a class='monitorbutton' href='?m=fast_download&p=fd_user&home_id-mod_id-ip-port=".$server_home['home_id']."-".$server_home['mod_id']."-".$server_home['ip']."-".$server_home['port']."'>
			<img src='" . check_theme_image("images/fast_download.png") . "' title='". get_lang("fast_download") ."'>
			<span>". get_lang("fast_download") ."</span>
		</a>"
	);
}
else
	$module_buttons = array();
?>