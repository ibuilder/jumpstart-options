<?php
/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Rebel Parts
/*-------------------------------------------------------*/
$option_name = themeblvd_get_option_name();
$options = get_option( $option_name );

if ($options['html5_preload'] == 'Yes') {
	include_once( ME_REBEL_DIRECTORY . '/assets/preload.php');
}
include_once( ME_REBEL_DIRECTORY . '/assets/scripts.php');

if ($options['ie_check'] == 'Yes') {
    require_once( ME_REBEL_DIRECTORY . '/assets/ie_check.php' );
}
if ($options['style_login'] == 'Yes') {
	include_once( ME_REBEL_DIRECTORY . '/assets/adminlogin.php');
}

include_once( ME_REBEL_DIRECTORY . '/assets/display.php');
include_once( ME_REBEL_DIRECTORY . '/assets/login.php');
include_once( ME_REBEL_DIRECTORY . '/assets/shortcodes.php');
include_once( ME_REBEL_DIRECTORY . '/assets/usermeta.php');
include_once( ME_REBEL_DIRECTORY . '/assets/whitelabel.php');
/*-------------------------------------------------------*/
/* Initialize the metabox class | CMB Courtesy of https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
/*-------------------------------------------------------*/
if ($options['hm_cmb'] == 'Yes') {
    include_once( ME_REBEL_DIRECTORY . 'assets/metabox/custom-meta-boxes.php' );
}
/*-------------------------------------------------------*/
/* Jacob Snyders Update Post - https://bitbucket.org/jupitercow/gravity-forms-update-post
/*-------------------------------------------------------*/
if ($options['gf_includegf'] == 'Yes') {
	include_once( ME_REBEL_DIRECTORY . '/assets/gravity.php');
    include_once(ME_REBEL_DIRECTORY . 'assets/gravityforms-update-post.php');
}
/*-------------------------------------------------------*/
/* 404 Email Alerts
/*-------------------------------------------------------*/
if ($options['404_email'] == 'Yes') {
	include_once( ME_REBEL_DIRECTORY . '/assets/404alert.php');
}
?>