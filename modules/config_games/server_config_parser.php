<?php
/*
 * Component of the config_games module
 */

define("SERVER_CONFIG_LOCATION","modules/config_games/server_configs/");
define("XML_SCHEMA","modules/config_games/schema_server_config.xml");

/// \return FALSE in case of failure in parsing.
/// \return array containing the elements on success.
function read_server_config( $filename )
{
    $dom = new DOMDocument();
    if ( $dom->load($filename) === FALSE )
    {
        print_failure(get_lang_f('unable_to_load_xml',$filename));
        return FALSE;
    }
    if ( $dom->schemaValidate(XML_SCHEMA) != TRUE )
    {
        print_failure(get_lang_f('xml_file_not_valid',$filename,XML_SCHEMA));
        return FALSE;
    }

    $xml = simplexml_load_file($filename);
    if($xml !== false){
		$xml->addChild('home_cfg_file',basename($filename));
		return $xml;
	}
	
	return false;
}

function xml_get_mod( $server_xml, $mod_key )
{
    foreach ( $server_xml->mods->mod as $xml_mod_tmp )
    {
        if ($xml_mod_tmp['key'] == $mod_key)
        {
            return $xml_mod_tmp;
        }
    }
    return FALSE;
}

?>
