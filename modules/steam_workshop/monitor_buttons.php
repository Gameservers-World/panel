<?php
/*
 * Component of the steam_workshop module
 */

if(isset($server_xml->installer) and $server_xml->installer == "steamcmd")
{
	$mod_xml = xml_get_mod($server_xml, $server_home['mod_key']);
	require_once("modules/steam_workshop/functions.php");
	if(isset($mod_xml->installer_name) and !in_array((string)$mod_xml->installer_name, get_blacklist()))
	{
		$module_buttons = array(
			"<a class='monitorbutton' href='?m=steam_workshop&p=main&home_id-mod_id-ip-port=".$server_home['home_id']."-".$server_home['mod_id']."-".$server_home['ip']."-".$server_home['port']."'>
				<img src='" . check_theme_image("images/steam_workshop.png") . "' title='Steam Workshop'>
				<span>Steam Workshop</span>
			</a>"
		);
	}
	else
		$module_buttons = array();
}
else
	$module_buttons = array();
?>