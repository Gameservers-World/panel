<?php
/*
 * Component of the cron module
 */

// Module general information
$module_title = "Cron";
$module_version = "1.0";
$db_version = 0;
$module_required = TRUE;
$module_menus = array( array( 'subpage' => 'cron', 'name'=>'Cron Admin', 'group'=>'admin' ),
					   array( 'subpage' => 'user_cron', 'name'=>'Task Scheduler', 'group'=>'user' ) );
?>

