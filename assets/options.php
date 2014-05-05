<?php
/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Custom Options
/*-------------------------------------------------------*/
 
 /*-------------------------------------------------------*/
/* Assets Tab - Create Tab
/*-------------------------------------------------------*/
themeblvd_add_option_tab( 'options', 'Options', false ); // 3rd parameter is true so tab will be at start.

/*-------------------------------------------------------*/
/* Configuration Tab - Add Colors
/*-------------------------------------------------------*/
$name = 'styles';
$description = 'Rebel Configuration Options';
$options = array(
    array(
        'name'      => 'Developer mode',
        'desc'      => 'Keep Admin Area in Developer mode to show all menu items, no hides unnecessary items',
        'id'        => 'developer_mode',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Style',
        'desc'      => 'Type',
        'id'        => 'rebel_style',
        'std'       => 'default',
        'type'      => 'radio',
        'options'   => array(
            'default' => 'default',
            'boxed' => 'boxed',
            'stretch' => 'stretch'
        )
    ),
    array(
        'name'      => 'Dark or Light',
        'desc'      => 'If your theme is more dark or more light',
        'id'        => 'dark_light',
        'std'       => 'light',
        'type'      => 'radio',
        'options'   => array(
            'light' => 'light',
            'dark' => 'dark'
        )
    ),
    array(
        'name'      => 'Include HM CMB',
        'desc'      => 'add in metabox class by HumanMade',
        'id'        => 'hm_cmb',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Styled Login',
        'desc'      => 'Customized Login for WP',
        'id'        => 'style_login',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'IE Check',
        'desc'      => 'Display a check for IE',
        'id'        => 'ie_check',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Email 404 Errors',
        'desc'      => 'Send 404 error log to site owner email',
        'id'        => '404_email',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Enable HTML5 Preload',
        'desc'      => 'if the browser allows it prerender',
        'id'        => 'html5_preload',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Enable Load Spinner',
        'desc'      => 'if the browser allows it prerender',
        'id'        => 'load_spinner',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Text Color',
        'desc'      => 'Select a color for the text.',
        'id'        => 'text_color',
        'std'       => '#333333',
        'type'      => 'color'
    ),
    array(
        'name'      => 'Background Color',
        'desc'      => 'Select a color for the Background.',
        'id'        => 'bg_color',
        'std'       => '#F2F2F2',
        'type'      => 'color'
    ),
    array(
        'name'      => 'Background Image',
        'desc'      => 'Upload image for background',
        'id'        => 'bg_image',
        'std'       => array( 'type' => 'image', 'image' => get_template_directory_uri().'/assets/images/grid.png' ),
        'type'      => 'upload'
    ),
    array(
        'name'      => 'Background Repeat',
        'desc'      => 'Repeating Image',
        'id'        => 'background_repeat',
        'std'       => 'repeat',
        'type'      => 'radio',
        'options'   => array(
            'repeat' => 'repeat',
            'no-repeat' => 'no-repeat'
        )
    ),
    array(
        'name'      => 'Background Image',
        'desc'      => 'How to align BG',
        'id'        => 'background_align',
        'std'       => 'center top',
        'type'      => 'radio',
        'options'   => array(
            'left top' => 'left top',
            'left center' => 'left center',
            'left bottom' => 'left bottom',
            'right top' => 'right top',
            'right center' => 'right center',
            'right bottom' => 'right bottom',
            'center top' => 'center top',
            'center center' => 'center center',
            'center bottom' => 'center bottom'
        )
    ),
    array(
        'name'      => 'Content Color',
        'desc'      => 'Select a color for the Background.',
        'id'        => 'content_color',
        'std'       => '#FFFFFF',
        'type'      => 'color'
    ),
    array(
        'name'      => 'Content Shadow Otline',
        'desc'      => 'Shadowed border',
        'id'        => 'content_outline',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Link Color',
        'desc'      => 'Select a color for the link text.',
        'id'        => 'link_color',
        'std'       => '#0d223b',
        'type'      => 'color'
    ),
    array(
        'name'      => 'Link Hover Color',
        'desc'      => 'Select a color for the hover text.',
        'id'        => 'hover_color',
        'std'       => '#032c5c',
        'type'      => 'color'
    ),
    array(
        'name'      => 'Nav High Color',
        'desc'      => 'Select a color for the navigation\'s background low gradient color.',
        'id'        => 'nav_high_color',
        'std'       => '#092334',
        'type'      => 'color'
    ),
    array(
        'name'      => 'Nav Low Color',
        'desc'      => 'Select a color for the navigation\'s background low gradient color.',
        'id'        => 'nav_low_color',
        'std'       => '#153f5a',
        'type'      => 'color'
    ),
    array(
        'name'      => 'Nav Link Color',
        'desc'      => 'Select a color for the navigation\'s main text color.',
        'id'        => 'nav_link_color',
        'std'       => '#f0f0f0',
        'type'      => 'color'
    ),
    array(
        'name'      => 'Form Background Color',
        'desc'      => 'background color of fields',
        'id'        => 'form_bg_color',
        'std'       => '#FFFFFF',
        'type'      => 'color'
    ),
    array(
        'name'      => 'Form Text Color',
        'desc'      => 'text color in fields',
        'id'        => 'form_color',
        'std'       => '#333333',
        'type'      => 'color'
    ),
    array(
        'name'      => 'Default Button Color',
        'desc'      => 'Choose a default color for your buttons',
        'id'        => 'button_color',
        'std'       => 'dark_blue',
        'type'      => 'select',
        'options'   => array(
            'default' => 'Default',
            'custom_button' => 'Custom',
            'primary' => 'Primary',
            'info' => 'Info',
            'success' => 'Success',
            'danger' => 'danger',
            'inverse' => 'inverse',
            'black' => 'black',
            'blue' => 'blue',
            'brown' => 'brown',
            'dark_blue' => 'dark_blue',
            'dark_brown' => 'dark_brown',
            'dark_green' => 'dark_green',
            'green' => 'green',
            'mauve' => 'mauve',
            'orange' => 'orange',
            'pearl' => 'pearl',
            'pink' => 'pink',
            'purple' => 'purple',
            'red' => 'red',
            'slate_grey' => 'slate_grey',
            'silver' => 'silver',
            'steel_blue' => 'steel_blue',
            'teal' => 'teal',
            'yellow' => 'yellow',
            'wheat' => 'wheat'
        )
    ),
    array(
        'name'      => 'Gravity Forms Stuff',
        'desc'      => 'Include gf toys like bootstrap css',
        'id'        => 'gf_includegf',
        'std'       => 'No',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    )
    // $Options End
);
themeblvd_add_option_section( 'options', 'styles', $name, $description, $options, true );

/*-------------------------------------------------------*/
/* Remove Items
/*-------------------------------------------------------*/

$name = 'scriptoptions';
$description = 'Say what you want and do not';
$options = array(
    /*** File ***/
    // Full
    array(
        'name'      => 'Disable Comment Flood',
        'desc'      => 'Make it so users can comment as much as they want',
        'id'        => 'comment_flood',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Block Malicious Attacks',
        'desc'      => 'add snippet to protect your blog',
        'id'        => 'malicious_snip',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Compress Scripts',
        'desc'      => 'add compression',
        'id'        => 'compress_scripts',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Disable Page Edit Link',
        'desc'      => 'Make it so admins can or cannot edit a page from frontend',
        'id'        => 'disable_editlink',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Disable Admin Help',
        'desc'      => 'Disable help in admin bar',
        'id'        => 'admin_help',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Enable Bootstrap',
        'desc'      => 'Enable bootstrap script from parent theme',
        'id'        => 'enable_bootstrap',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Enable Primary JS',
        'desc'      => 'Enable parent themes primary JS',
        'id'        => 'enable_primaryjs',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Enable Primary CSS',
        'desc'      => 'Enable parent themes primary CSS',
        'id'        => 'enable_primarycss',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Enable Superfish',
        'desc'      => 'Enable superfish script from parent theme',
        'id'        => 'enable_superfish',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Enable prettyPhoto',
        'desc'      => 'Enable prettyPhoto script from parent theme',
        'id'        => 'enable_prettyphoto',
        'std'       => 'No',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Enable Magnific Popup',
        'desc'      => 'Enable Magnific Popup script from parent theme',
        'id'        => 'enable_magnificpopup',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Enable iOS Orientation Fix',
        'desc'      => 'Disabled by Default',
        'id'        => 'enable_ios_orientation',
        'std'       => 'No',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    )
    // $Options End
);
themeblvd_add_option_section( 'options', 'scriptoptions', $name, $description, $options, false );

/*-------------------------------------------------------*/
/* Gravity Options
/*-------------------------------------------------------*/
$name = 'gravity_forms';
$description = 'Gravity Stuff';
$options = array(
    array(
        'name'      => 'Scripts in Footer',
        'desc'      => 'Put Gravity scripts in footer',
        'id'        => 'gf_footer_scripts',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Include Disable Class',
        'desc'      => 'Add CSS read Class for diable field',
        'id'        => 'gf_disable',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Encrypt Data',
        'desc'      => 'Use the HM Encryptorator',
        'id'        => 'gf_encryptorator',
        'std'       => 'Yes',
        'type'      => 'radio',
        'options'   => array(
            'Yes' => 'Yes',
            'No' => 'No'
        )
    ),
    array(
        'name'      => 'Encryptorator Key',
        'desc'      => 'Fill in key',
        'id'        => 'gf_ssl_key',
        'std'       => get_template_directory() . 'keyfile.pem',
        'type'      => 'text'
    ),
);
themeblvd_add_option_section( 'options', 'gravity_forms', $name, $description, $options, false );