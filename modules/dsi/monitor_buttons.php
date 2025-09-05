<?php
/*
 * Component of the dsi module
 */

$module_buttons = array(
	"<a class='monitorbutton' href='?m=dsi&p=user_dsi&home_id-mod_id-ip-port=".$server_home['home_id']."-".$server_home['mod_id']."-".$server_home['ip']."-".$server_home['port']."'>
		<img src='" . check_theme_image("images/dsi.png") . "' title='DSi'>
		<span>DSi</span>
	</a>"
);	
?>