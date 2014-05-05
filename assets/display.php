<?php
/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Modify Footer
/*-------------------------------------------------------*/
/*
function rebel_footer() {
    $divider = do_shortcode('[divider style="solid"]');
    $querynum = '<strong>Page Calculation</strong>: '. get_num_queries() .' queries in ' . (timer_stop( 0 )) .' seconds.';
    $footer_above = '<div class="column grid_6">'. do_shortcode("[button link='#top' color=". themeblvd_get_option( 'button_color' ) ." size=default]Back to top[/button]") .'</div><div class="column grid_6 last"><p style="text-align: right">'.$querynum.'</p></div><br><div>'.$divider.'</div>';
    echo $footer_above;
}
add_action( 'themeblvd_footer_above', 'rebel_footer' );
*/
/*-------------------------------------------------------*/
/* Escape html entities in comments
/*-------------------------------------------------------*/
add_filter('pre_comment_content', 'rebel_encode_code_in_comment');
function rebel_encode_code_in_comment($source) {
	$encoded = preg_replace_callback('/<code>(.*?)<\/code>/ims',
	create_function('$matches', '$matches[1] = preg_replace(array("/^[\r|\n]+/i", "/[\r|\n]+$/i"), "", $matches[1]); 
	return "<code>" . htmlentities($matches[1]) . "</"."code>";'), $source);
	if ($encoded)
		return $encoded;
	else
		return $source;
}
/*-------------------------------------------------------*/
/* Add Widget
/* http://dev.themeblvd.com/tutorial/addremove-widget-area-location/
/*-------------------------------------------------------*/
themeblvd_add_sidebar_location( 'header_widget', 'Header Right', 'collapsible', 'Widget for header' );
add_action( 'themeblvd_header_addon', 'rebel_display_header_widget' );
function rebel_display_header_widget() {
	echo '<div class="header-right pull-right text-center">';
	themeblvd_display_sidebar( 'header_widget' );
	echo '</div>';
}

/*-------------------------------------------------------*/
/* add a App Icon  to your site
/*-------------------------------------------------------*/
add_action('wp_head', 'rebel_apple_touch_icon');
function rebel_apple_touch_icon() {
  if(strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) {
    echo '<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="'.get_bloginfo('stylesheet_directory').'/assets/images/appicon72.png" />' . "\n";
    echo '<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="'.get_bloginfo('stylesheet_directory').'/assets/images/appicon144.png" />' . "\n";
  }
  if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod')) {
    echo '<link rel="apple-touch-icon" type="image/x-icon" sizes="57x57"  href="'.get_bloginfo('stylesheet_directory').'/assets/images/appicon57.png" />' . "\n";
  }
  if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone')) {
    echo '<link rel="apple-touch-icon" type="image/x-icon" sizes="57x57" href="'.get_bloginfo('stylesheet_directory').'/assets/images/appicon57.png" />' . "\n";
    echo '<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="'.get_bloginfo('stylesheet_directory').'/assets/images/appicon72.png" />' . "\n";
    echo '<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="'.get_bloginfo('stylesheet_directory').'/assets/images/appicon114.png" />' . "\n";
  }
}
/*-------------------------------------------------------*/
/* add a favicon to your site
/*-------------------------------------------------------*/
add_action('wp_head', 'rebel_blog_favicon');
function rebel_blog_favicon() {
    echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/assets/images/favicon.ico" />' . "\n";
}
/*-------------------------------------------------------*/
/* Create Custom Admin Footer
/*-------------------------------------------------------*/
add_filter('admin_footer_text', 'rebel_admin_footer');
function rebel_admin_footer() {
    echo '<div id="footer">Developed by <a href="http://blackreit.com" target="_blank">Rebel</a> for <a href="http://www.wpjumpstart.com" target="_blank">the Jumpstart Framework</a>.</div>';
}
/*--------------------------------------*/
/* Remove Menu Items
/*--------------------------------------*/
add_action( 'admin_menu', 'rebel_remove_menu_pages' );
function rebel_remove_menu_pages() {
    $option_name = themeblvd_get_option_name();
    $options = get_option( $option_name );
    if ($options['developer_mode'] == 'No') {
          remove_menu_page('link-manager.php');
          remove_menu_page('upload.php');
          remove_menu_page('tools.php');  
          remove_menu_page('plugins.php');
          remove_menu_page('edit.php');  
          /* remove_menu_page('themes.php'); // If you remove this you can't edit theme */
          remove_menu_page('options-general.php');
    }
}
/*--------------------------------------*/
/* Admin link for all settings
/*--------------------------------------*/
add_action('admin_menu', 'rebel_all_settings_link');
function rebel_all_settings_link() {
    $option_name = themeblvd_get_option_name();
    $options = get_option( $option_name );
    if ($options['developer_mode'] == 'Yes') {
    add_theme_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
  }
}
/*--------------------------------------*/
/* Change author permalink
/* http://www.wprecipes.com/how-to-change-author-url-base-on-your-wordpress-site
/*--------------------------------------*/
add_action('init', 'rebel_author_base');
function rebel_author_base() {
    global $wp_rewrite;
    $author_slug = 'profile'; // change slug name
    $wp_rewrite->author_base = $author_slug;
}
/*-------------------------------------------------------*/
/* Comment Flood
/*-------------------------------------------------------*/
if ($options['comment_flood'] == 'No') {
    enable_filter('check_comment_flood', 'check_comment_flood_db');
}
?>