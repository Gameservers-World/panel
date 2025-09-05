<?php
/*
 * Theme Login Flow Test
 * This file simulates the login success message to test theme rendering
 */

// Simulate session and basic setup
session_start();
define("IMAGES", "images/");
define("INCLUDES", "includes/");
define("MODULES", "modules/");

// Test different themes
$test_themes = ['AdminLTE', 'SimpleBootstrap', 'Revolution', 'Revolution-Light', 'MasterControlProgram'];

if (isset($_GET['theme']) && in_array($_GET['theme'], $test_themes)) {
    $test_theme = $_GET['theme'];
} else {
    $test_theme = 'AdminLTE';
}

// Simple function to simulate getThemePath
function getThemePath() {
    global $test_theme;
    return "themes/{$test_theme}/";
}

// Simulate basic OGP view system
$path = getThemePath();
$layout = file_exists($path.'layout.html') ? file_get_contents($path.'layout.html') : 'Layout file not found';
$top = file_exists($path.'top.html') ? file_get_contents($path.'top.html') : '';
$bottom = file_exists($path.'bottom.html') ? file_get_contents($path.'bottom.html') : '';
$topbody = file_exists($path.'topbody.html') ? file_get_contents($path.'topbody.html') : '';
$botbody = file_exists($path.'botbody.html') ? file_get_contents($path.'botbody.html') : '';

// Simulate the success message content that caused white screen
$success_message = '
<div style="background: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 4px; margin: 20px 0;">
    <h4>✓ Login Successful</h4>
    <p>You have successfully logged in. Redirecting to dashboard...</p>
    <p><small>This message simulates what appears after login in the actual system.</small></p>
</div>

<div style="background: #f8f9fa; padding: 20px; border: 1px solid #dee2e6; margin: 20px 0;">
    <h5>Theme Test: ' . htmlspecialchars($test_theme) . '</h5>
    <p>This content should appear in the main content area, not in sidebars or navigation areas.</p>
    <p>If you see this properly formatted, the theme structure is working correctly.</p>
</div>

<div style="margin: 20px 0;">
    <h6>Test Other Themes:</h6>
    ' . implode(' | ', array_map(function($theme) {
        return '<a href="?theme=' . $theme . '" style="margin-right: 10px;">' . $theme . '</a>';
    }, $test_themes)) . '
</div>
';

// Replace placeholders
$header_code = '<style>body { font-family: Arial, sans-serif; }</style>';
$title = 'Theme Test - ' . $test_theme;
$charset = 'utf-8';

$layout = str_replace('%title%', $title, $layout);
$layout = str_replace('%header_code%', $header_code, $layout);
$layout = str_replace('%charset%', $charset, $layout);
$layout = str_replace('%body%', $success_message, $layout);
$layout = str_replace('%top%', $top, $layout);
$layout = str_replace('%topbody%', $topbody, $layout);
$layout = str_replace('%botbody%', $botbody, $layout);
$layout = str_replace('%bottom%', $bottom, $layout);
$layout = str_replace('%meta%', '', $layout);
$layout = str_replace('%logo%', '#', $layout);
$layout = str_replace('%bg_wrapper%', '', $layout);
$layout = str_replace('%footer%', '<p style="text-align: center; color: #666;">Theme Test Footer</p>', $layout);
$layout = str_replace('%notifications%', '', $layout);

// Clean up any remaining placeholders
$layout = preg_replace('/%[a-zA-Z_]+%/', '', $layout);

echo $layout;
?>