<?php
/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Whitelabel & Security
/*-------------------------------------------------------*/
$option_name = themeblvd_get_option_name();
$options = get_option( $option_name );
/*-------------------------------------------------------*/
/* Security - Remove Base (Credit: Remi Corson)
/*-------------------------------------------------------*/ 
register_activation_hook(__FILE__, 'rwl_deletedef_settings');
function rwl_deletedef_settings() {
    // Delete "hello world" post
    wp_delete_post(1, TRUE);
    
    // Delete "Mister WordPress" comment
    wp_delete_comment(1);
    
    // Delete default links
    for ($i = 1; $i <= 7; $i++) {
        wp_delete_link($i);
    }
 
    return;
}
/*-------------------------------------------------------*/
/* Remove Feeds
/*-------------------------------------------------------*/ 
if( !defined( 'ABSPATH' ) )
  exit;

class Disable_Feeds {
  function __construct() {
    if( is_admin() ) {
      add_action( 'admin_init', array( $this, 'admin_setup' ) );
    }
    else {
      add_action( 'wp_loaded', array( $this, 'remove_links' ) );
      add_filter( 'parse_query', array( $this, 'filter_query' ) );
    }
  }
  
  function admin_setup() {
    add_settings_field( 'disable_feeds_redirect', 'Disable Feeds Plugin', array( $this, 'settings_field' ), 'reading' );
    register_setting( 'reading', 'disable_feeds_redirect' );
  }
  
  function settings_field() {
    $redirect = $this->redirect_status();
    echo '<p>The <em>Disable Feeds</em> plugin is active, and all feed are disabled. By default, all requests for feeds are redirected to the corresponding HTML content. If you want to issue a 404 (page not found) response instead, select the second option below.</p><p><input type="radio" name="disable_feeds_redirect" value="on" id="disable_feeds_redirect_yes" class="radio" ' . checked( $redirect, 'on', false ) . '/><label for="disable_feeds_redirect_yes"> Redirect feed requests to corresponding HTML content</label><br /><input type="radio" name="disable_feeds_redirect" value="off" id="disable_feeds_redirect_no" class="radio" ' . checked( $redirect, 'off', false ) . '/><label for="disable_feeds_redirect_no"> Issue a 404 (page not found) error for feed requests</label></p>';
  }
  
  function remove_links() {
    remove_action( 'wp_head', 'feed_links', 2 );
    remove_action( 'wp_head', 'feed_links_extra', 3 );
  }
  
  function filter_query( $wp_query ) {
    if( !is_feed() )
      return;

    if( $this->redirect_status() == 'on' ) {
      if( isset( $_GET['feed'] ) ) {
        wp_redirect( remove_query_arg( 'feed' ), 301 );
        exit;
      }

      set_query_var( 'feed', '' );  // redirect_canonical will do the rest
      redirect_canonical();
    }
    else {
      $wp_query->is_feed = false;
      $wp_query->set_404();
      status_header( 404 );
    }
  }
  
  private function redirect_status() {
    $r = get_option( 'disable_feeds_redirect', 'on' );
    // back compat
    if( is_bool( $r ) ) {
      $r = $r ? 'on' : 'off';
      update_option( 'disable_feeds_redirect', $r );
    }
    return $r;
  }
}

new Disable_Feeds();

// Disable autop

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

function rebel_head_cleanup() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    add_filter('xmlrpc_enabled', '__return_false');
    add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action('init', 'rebel_head_cleanup');

/* Version Blanking */
function rebel_blank_version() {
        return '';
    } 
add_filter('the_generator','rebel_blank_version');

/*-------------------------------------------------------*/
/* Hide Help in Admin
/*-------------------------------------------------------*/ 

if ($options['admin_help'] == 'Yes') {
    add_action('admin_head', 'hide_help');
    function hide_help() {
        echo '<style type="text/css">
                #contextual-help-link-wrap { display: none !important; }
              </style>';
    }
}
/*-------------------------------------------------------*/
/* Remove Admin Bar from Frontend
/*-------------------------------------------------------*/ 
    add_filter('show_admin_bar', '__return_false');  
/*-------------------------------------------------------*/
/* Disable Plugin Deactivation
/*-------------------------------------------------------*/
function rebel_lock_plugins( $actions, $plugin_file, $plugin_data, $context ) {
    // Remove edit link for all
    if ( array_key_exists( 'edit', $actions ) )
        unset( $actions['edit'] );
    // Remove deactivate link for crucial plugins
    if ( array_key_exists( 'deactivate', $actions ) && in_array( $plugin_file, array(
        'slt-custom-fields/slt-custom-fields.php',
        'slt-file-select/slt-file-select.php',
        'slt-simple-events/slt-simple-events.php',
        'slt-widgets/slt-widgets.php'
    )))
        unset( $actions['deactivate'] );
    return $actions;
}

// Remove Howdy message
function em_remove_howdy( $wp_admin_bar ) {
  $my_account=$wp_admin_bar->get_node('my-account');
  $newtitle = str_replace( 'Howdy,', '', $my_account->title );
  $wp_admin_bar->add_node( array(
  'id' => 'my-account',
  'title' => $newtitle,
  ) );
}
add_filter( 'admin_bar_menu', 'em_remove_howdy',25 );

// Add widgets
function slt_dashboardWidgets() {
  wp_add_dashboard_widget( 'slt-php-errors', 'PHP errors', 'slt_PHPErrorsWidget' );
}
add_action( 'wp_dashboard_setup', 'slt_dashboardWidgets' );
/*-------------------------------------------------------*/
/* Disable Theme Changing
/*-------------------------------------------------------*/
function rebel_lock_theme() {
    global $submenu, $userdata;
    get_currentuserinfo();
    if ( $userdata->ID != 1 ) {
        unset( $submenu['themes.php'][5] );
        unset( $submenu['themes.php'][15] );
    }
}
/*-------------------------------------------------------*/
/* Lock Themes and Plugins
/*-------------------------------------------------------*/
if ($options['developer_mode'] == 'No') {
  add_filter( 'plugin_action_links', 'rebel_lock_plugins', 10, 4 );
  add_action( 'admin_init', 'rebel_lock_theme' );
}
/*-------------------------------------------------------*/
/* Disable Self Pingbacks
/*-------------------------------------------------------*/
add_action( 'pre_ping', 'disable_self_trackback' );
function disable_self_trackback( &$links ) {
    foreach ( $links as $l => $link ) {
        if ( 0 === strpos( $link, home_url() ) ) {
            unset($links[$l]);
        }
    }
}
?>
