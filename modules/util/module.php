<?php
/*
 * Component of the util module
 */

// Module general information
$module_title = "Utilities";
$module_version = "2.0";
$db_version = 0;
$module_required = TRUE;
$module_menus = array( array( 'subpage' => '', 'name'=>'Utilities', 'group'=>'user' ) );
$module_prereqs = array(
	array( "name" => "PHP BCMath Extension", "type" => "f", "value" => "bcadd" ),
);
?>

