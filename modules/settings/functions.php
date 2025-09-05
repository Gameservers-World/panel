<?php
/*
 * Component of the settings module
 */

/// @param $selected What value should be selected.
function get_theme_html_str( $selected, $add_empty = FALSE )
{
    $themes = makefilelist("themes/", ".|..|.svn", true, "folders");

    $retval = "<select id='theme' name='theme'>";
    if ( empty($selected) )
    {
        $retval .= "<option value='' selected=selected >-</option>";
    }
    foreach ( $themes as $theme )
    {
        $retval .= "<option value='$theme'";
        if ( $theme === $selected )
            $retval .= ' selected=selected ';
        $retval .= ">$theme</option>";
    }
    if ( $add_empty )
    {
        $retval .= "<option value='' >-</option>";
    }

    $retval .= "</select>";
    return $retval;
}
?>
