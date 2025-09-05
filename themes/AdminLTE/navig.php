<?php
/*
 * AdminLTE Theme Navigation Handler
 * This file provides theme-specific navigation rendering for AdminLTE
 */

function renderAdminLTENavigation() {
    global $db, $settings;
    
    // Check if we're in a logged-in state
    if (!isset($_SESSION['user_id'])) {
        return;
    }
    
    $isAdmin = $db->isAdmin($_SESSION['user_id']);
    $user_id = $_SESSION['user_id'];
    
    if ($isAdmin) {
        $server_homes = $db->getHomesFor('admin', $user_id);
    } else {
        $server_homes = $db->getHomesFor('user_and_group', $user_id);
    }
    
    if (!empty($server_homes)) {
        $servers_by_game_name = array();
        foreach ($server_homes as $server_home) {
            if (isset($settings['check_expiry_by']) and $settings['check_expiry_by'] == "once_logged_in") {
                if ($db->check_expire_date($_SESSION['user_id'], $server_home['home_id']))
                    continue;
            }
            $servers_by_game_name["$server_home[game_name]"][] = $server_home;
        }
        ksort($servers_by_game_name);
        
        require_once("modules/config_games/server_config_parser.php");
        foreach ($servers_by_game_name as $game_name => $server_homes) {
            $server_xml = read_server_config(SERVER_CONFIG_LOCATION."/".$server_homes[0]['home_cfg_file']);
            $mod = $server_homes[0]['mod_key'];
            
            // If query name does not exist use mod key instead.
            if ($server_xml->protocol == "gameq")
                $query_name = $server_xml->gameq_query_name;
            elseif ($server_xml->protocol == "lgsl")
                $query_name = $server_xml->lgsl_query_name;
            elseif ($server_xml->protocol == "teamspeak3")
                $query_name = 'ts3';
            else
                $query_name = $mod;
            
            //----------+ getting the lgsl image icon
            $icon_paths = array("images/icons/$mod.png",
                                "images/icons/$query_name.png",
                                "protocol/lgsl/other/icon_unknown.gif");

            $icon_path = get_first_existing_file($icon_paths);
            
            echo '<li class="nav-item has-treeview">';
            echo '<a href="?m=gamemanager&p=game_monitor&home_cfg_id='.$server_homes[0]['home_cfg_id'].'" class="nav-link">';
            echo '<i class="nav-icon fas fa-gamepad"></i>';
            echo '<p>'.$game_name.'<i class="right fas fa-angle-left"></i></p>';
            echo '</a>';
            echo '<ul class="nav nav-treeview">';
            
            foreach ($server_homes as $server_home) {
                $button_name = htmlentities($server_home['home_name']);
                if (!preg_match("/none/i", $server_home['mod_name'])) 
                    $button_name .= " - ".$server_home['mod_name'];
                
                echo '<li class="nav-item">';
                echo '<a href="?m=gamemanager&p=game_monitor&home_id-mod_id-ip-port='.
                     $server_home['home_id'].'-'.$server_home['mod_id'].'-'.$server_home['ip'].'-'.
                     $server_home['port'].'" class="nav-link">';
                echo '<i class="far fa-circle nav-icon"></i>';
                echo '<p>'.$button_name.'</p>';
                echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
            echo '</li>';
        }
    }
    
    // User menus
    $menus = $db->getMenusForGroup('user');
    foreach ($menus as $menu) {
        $module = $menu['module'];
        if (!empty($menu['subpage'])) {
            $subpage = "&amp;p=".$menu['subpage'];
            $button = $menu['subpage'];
            $menu_link_class = (isset($_GET['p']) AND $_GET['p'] == $menu['subpage']) ? 'nav-link active' : 'nav-link';
        } else {
            $subpage = "";
            $button = $menu['module'];
            $menu_link_class = (isset($_GET['m']) AND $_GET['m'] == $menu['module']) ? 'nav-link active' : 'nav-link';
        }
        $button_url = "?m=".$module.$subpage;
        
        if (preg_match('/\\_?\\_/', get_lang("$button"))) {
            $button_name = $menu['menu_name'];
        } else {
            $button_name = get_lang("$button");
        }
        
        // Get appropriate icon
        $icon_class = getMenuIcon($button);
        
        echo '<li class="nav-item">';
        echo '<a href="'.$button_url.'" class="'.$menu_link_class.'">';
        echo '<i class="nav-icon '.$icon_class.'"></i>';
        echo '<p>'.$button_name.'</p>';
        echo '</a>';
        echo '</li>';
    }
    
    if ($isAdmin) {
        $menus = $db->getMenusForGroup('admin');
        
        echo '<li class="nav-item has-treeview">';
        echo '<a href="?m=administration&amp;p=main" class="nav-link">';
        echo '<i class="nav-icon fas fa-cogs"></i>';
        echo '<p>'.get_lang('administration').'<i class="right fas fa-angle-left"></i></p>';
        echo '</a>';
        echo '<ul class="nav nav-treeview">';
        
        foreach ($menus as $menu) {
            $module = $menu['module'];
            if (!empty($menu['subpage'])) {
                $subpage = "&amp;p=".$menu['subpage'];
                $button = $menu['subpage'];
                $menu_link_class = (isset($_GET['p']) AND $_GET['p'] == $menu['subpage']) ? 'nav-link active' : 'nav-link';
            } else {
                $subpage = "";
                $button = $menu['module'];
                $menu_link_class = (isset($_GET['m']) AND $_GET['m'] == $menu['module']) ? 'nav-link active' : 'nav-link';
            }
            $button_url = "?m=".$module.$subpage;
            
            if (preg_match('/\\_?\\_/', get_lang("$button"))) {
                $button_name = $menu['menu_name'];
            } else {
                $button_name = get_lang("$button");
            }
            
            echo '<li class="nav-item">';
            echo '<a href="'.$button_url.'" class="'.$menu_link_class.'">';
            echo '<i class="far fa-circle nav-icon"></i>';
            echo '<p>'.$button_name.'</p>';
            echo '</a>';
            echo '</li>';
        }
        
        echo '</ul>';
        echo '</li>';
    } else {
        $isSubUser = $db->isSubUser($_SESSION['user_id']);
        
        echo '<li class="nav-item">';
        echo '<a href="?m=user_admin&amp;p=edit_user&amp;user_id='.$_SESSION['user_id'].'" class="nav-link">';
        echo '<i class="nav-icon fas fa-user"></i>';
        echo '<p>'.$_SESSION['users_login'].'</p>';
        echo '</a>';
        echo '</li>';
    }
    
    echo '<li class="nav-item">';
    echo '<a href="?logout" class="nav-link">';
    echo '<i class="nav-icon fas fa-sign-out-alt"></i>';
    echo '<p>'.get_lang('logout').'</p>';
    echo '</a>';
    echo '</li>';
}

function getMenuIcon($button) {
    $icons = array(
        'dashboard' => 'fas fa-tachometer-alt',
        'gamemanager' => 'fas fa-gamepad',
        'game_monitor' => 'fas fa-desktop',
        'user_admin' => 'fas fa-users',
        'administration' => 'fas fa-cogs',
        'settings' => 'fas fa-cog',
        'tickets' => 'fas fa-ticket-alt',
        'billing' => 'fas fa-credit-card',
        'mysql' => 'fas fa-database',
        'ftp' => 'fas fa-folder-open',
        'subusers' => 'fas fa-user-plus',
        'backup-restore' => 'fas fa-download',
        'litefm' => 'fas fa-file-alt',
        'news' => 'fas fa-newspaper',
        'support' => 'fas fa-life-ring'
    );
    
    return isset($icons[$button]) ? $icons[$button] : 'fas fa-circle';
}
?>