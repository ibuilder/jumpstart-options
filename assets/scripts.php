<?php
/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Get Options
/*-------------------------------------------------------*/
$option_name = themeblvd_get_option_name();
$options = get_option( $option_name );
/*-------------------------------------------------------*/
/* Enque Use HTML5 Shiv
/*-------------------------------------------------------*/

add_action( 'wp_enqueue_scripts', 'wps_enqueue_lt_ie10' );
/**
 * Conditionally Enqueue Script for IE browsers less than IE 9
 *
 * @link http://php.net/manual/en/function.version-compare.php
 * @uses wp_check_browser_version()
 */
function wps_enqueue_lt_ie10() {
    global $is_IE;
 
    // Return early, if not IE
    if ( ! $is_IE ) return;
 
    // Include the file, if needed
    if ( ! function_exists( 'wp_check_browser_version' ) )
        include_once( ABSPATH . 'wp-admin/includes/dashboard.php' );
 
    // IE version conditional enqueue
    $response = wp_check_browser_version();
    if ( 0 > version_compare( intval( $response['version'] ) , 10 ) )
        wp_register_script( 'html5-js', ME_REBEL_URI . '/assets/js/html5.js' );
    	wp_enqueue_script('html5-js');
}
/*-------------------------------------------------------*/
/* Enque Custom JS and CSS
/*-------------------------------------------------------*/
add_action( 'wp_enqueue_scripts', 'rebel_scripts' );
function rebel_scripts() {
    global $themeblvd_framework_styles, $compress_scripts, $concatenate_scripts;
	$option_name = themeblvd_get_option_name();
	$options = get_option( $option_name );
	/* Javascript */
	if ($options['load_spinner'] == 'Yes') {
	    wp_register_script( 'spin-js', ME_REBEL_URI . '/assets/js/spin.min.js' );
	    wp_enqueue_script('spin-js');
	    wp_register_script( 'pageload', ME_REBEL_URI . '/assets/js/pageload.js' );
	    wp_enqueue_script('pageload');
	} else {
		wp_deregister_script( 'spin-js' );
		wp_deregister_script( 'pageload' );
	}


    wp_deregister_script( 'themeblvd_theme-css' );  // Deregister parent

	/* CSS */

if ($options['compress_scripts'] == 'Yes') {
    $compress_scripts = 1;
    $concatenate_scripts = 1;
    define('ENFORCE_GZIP', false);
}
   

    wp_register_style( 'themeblvd_theme-css', ME_REBEL_URI . '/style.css', $themeblvd_framework_styles );
    wp_enqueue_script('themeblvd_theme-css');
}
/*-------------------------------------------------------*/
/* Remove Scripts
/*-------------------------------------------------------*/
if ($options['enable_bootstrap'] == 'No') {
    function rebel_enable_bootstrap( $config ){
	    $config['assets']['bootstrap'] = false;
	    return $config;
	}
	add_filter( 'themeblvd_global_config', 'rebel_enable_bootstrap' );
}

if ($options['enable_primaryjs'] == 'No') {
    function rebel_enable_primaryjs( $config ){
	    $config['assets']['primary_js'] = false;
	    return $config;
	}
	add_filter( 'themeblvd_global_config', 'rebel_enable_primaryjs' );
}

if ($options['enable_primarycss'] == 'No') {
    function rebel_enable_primarycss( $config ){
	    $config['assets']['primary_css'] = false;
	    return $config;
	}
	add_filter( 'themeblvd_global_config', 'rebel_enable_primarycss' );
}

if ($options['enable_superfish'] == 'No') {
    function rebel_enable_superfish( $config ){
	    $config['assets']['superfish'] = false;
	    return $config;
	}
	add_filter( 'themeblvd_global_config', 'rebel_enable_superfish' );
}

if ($options['enable_prettyphoto'] == 'No') {
    function rebel_enable_prettyphoto( $config ){
	    $config['assets']['prettyphoto'] = false;
	    return $config;
	}
	add_filter( 'themeblvd_global_config', 'rebel_enable_prettyphoto' );
}

if ($options['enable_ios_orientation'] == 'Yes') {
    function rebel_enable_ios_orientation( $config ){
	    $config['assets']['ios_orientation '] = true;
	    return $config;
	}
	add_filter( 'themeblvd_global_config', 'rebel_enable_ios_orientation' );
}

if ($options['enable_magnificpopup'] == 'No') {
    function rebel_enable_magnificpopup( $config ){
	    $config['assets']['magnific_popup'] = false;
	    return $config;
	}
	add_filter( 'themeblvd_global_config', 'rebel_enable_magnificpopup' );
}
?>