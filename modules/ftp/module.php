<?php
/*
 * Component of the ftp module
 */

// Module general information
$module_title = "ftp";
$module_version = "1.41";
$db_version = 1;
$module_required = TRUE;
$module_menus = array( array( 'subpage' => 'ftp_admin', 'name'=>'FTP Admin', 'group'=>'admin' ) );
$module_access_rights = array('t' => 'allow_ftp');
?>
