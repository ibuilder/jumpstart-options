<?php
/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Define Rebel
/*-------------------------------------------------------*/
define( 'ME_REBEL_VERSION', '1.0' );
define( 'ME_REBEL_DIRECTORY', get_stylesheet_directory().'/' );
define( 'ME_REBEL_URI', get_stylesheet_directory_uri().'/' );
/*-------------------------------------------------------*/
/* Check for Updates (No Updates available for Birchwood)
/*-------------------------------------------------------
include_once( ME_REBEL_DIRECTORY . 'assets/update.php');
$example_update_checker = new ThemeUpdateChecker(
    'jumpstart-options',                                            //Theme folder name, AKA "slug". 
    'http://rebel.blackreit.com/jumpstart-options.json' //URL of the metadata file.
);*/
/*-------------------------------------------------------*/
/* Run Theme Blvd framework (required)
/*-------------------------------------------------------*/
require_once( get_template_directory() . '/framework/themeblvd.php' );
/*-------------------------------------------------------*/
/* Start eManager Customizations
/*-------------------------------------------------------*/
include_once( ME_REBEL_DIRECTORY . 'assets/options.php');
/* Get Framework Options */
$option_name = themeblvd_get_option_name();
$options = get_option( $option_name );
/*-------------------------------------------------------*/
/* Protect Your Blog From Malicious URL Requests
/*-------------------------------------------------------*/
if ($options['malicious_snip'] == 'Yes') {
    global $user_ID;
    if($user_ID) {
      if(!current_user_can('level_10')) {
        if (strlen($_SERVER['REQUEST_URI']) > 255 ||
          strpos($_SERVER['REQUEST_URI'], "eval(") ||
          strpos($_SERVER['REQUEST_URI'], "CONCAT") ||
          strpos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
          strpos($_SERVER['REQUEST_URI'], "base64")) {
            @header("HTTP/1.1 414 Request-URI Too Long");
        @header("Status: 414 Request-URI Too Long");
        @header("Connection: Close");
        @exit;
        }
      }
    }
}
/*-------------------------------------------------------*/
/* Build Custom Style
/*-------------------------------------------------------*/
function rebel_css_style_generator($newdata) {
    $data = $newdata; 
    $uploads = wp_upload_dir();
    $css_dir = ME_REBEL_DIRECTORY; // Shorten code, save 1 call
    
    /** Save on different directory if on multisite **/
    if(is_multisite()) {
        $em_uploads_dir = trailingslashit($uploads['basedir']);
    } else {
        $em_uploads_dir = $css_dir;
    }
    
    /** Capture CSS output **/
    ob_start();
    require($css_dir . 'style-base.php');
    $css = ob_get_clean();
    
    /** Write to options.css file **/
    WP_Filesystem();
    global $wp_filesystem;
    if ( ! $wp_filesystem->put_contents( $em_uploads_dir . 'style.css', $css, 0644) ) {
        return true;
    }
}

add_action( 'update_option_' .themeblvd_get_option_name(), 'rebel_css_style_generator' );
/*-------------------------------------------------------*/
/* Jumpstart Child - Rebel Options
/*-------------------------------------------------------*/
include_once( ME_REBEL_DIRECTORY . 'assets/index.php');
?>