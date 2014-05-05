<?php
/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Custom Shortcodes
/*-------------------------------------------------------*/
/*-------------------------------------------------------*/
/* Logged in/out User Shortcode from Jack Lamb
/*-------------------------------------------------------*/
// Security check to see if someone is accessing this file directly
if(preg_match("#^logged-in-user-shortcode.php#", basename($_SERVER['PHP_SELF']))) exit();

// [loggedin]content[/loggedin] returns content only to logged in users
function wpfc_logged_in( $atts, $content = null ) {
  if (is_user_logged_in() )
      {
        return do_shortcode($content);
      }
}

add_shortcode('loggedin', 'wpfc_logged_in');

// [loggedout]content[/loggedout] returns content only to logged out users
function wpfc_logged_out( $atts, $content = null ) {
  if (is_user_logged_in() )
      {}
    else return do_shortcode($content);
}

add_shortcode('loggedout', 'wpfc_logged_out');

/*--------------------------------------*/
/*  HR
/*--------------------------------------*/
function hr_shortcode( $atts, $content = null ){
  extract(shortcode_atts(array(
    'style' => '',
    'margin_top' => '',
    'margin_bottom' => ''
  ), $atts ));
  
   return '<div class="clear"></div><hr class="'.$style.'" style="margin-top: '.$margin_top.'; margin-bottom:'.$margin_bottom.';" />';
   
}
add_shortcode( 'hr', 'hr_shortcode' );

/*-------------------------------------------------------*/
/* Adds [post] shortcode that returns either a URL or anchor to a post
/* 
/* Takes one or more of the following attributes:
/* - id - int - numeric post ID you want to link to, defaults to current (inside Loop)
/* - anchor - string, "yes" or "no" - indicates whether to return just a permalink or full anchor
/* - title - string - replaces default 'Permalink to %s' anchor title; can include a single %s to replace for post title; can only be used when anchor is set to "yes"
/* - text - string - replaces anchor inner text; can include a single %s to replace for post title; can only be used when anchor is set to "yes"
/* - class - string - adds custom class or classes to anchor element; can only be used when anchor is set to "yes"
/*
/* Usage examples:
/* - [post]
/* - [post id="42"]
/* - [post id="42" anchor="yes" class="extra-link-class"]
/* - [post id="42" anchor="yes" title="My post"]
/* - [post id="42" anchor="yes" title="See %s"]
/* - [post id="42" anchor="yes" title="The other post" text="click here"]
/* - [post id="42" anchor="yes" text="Visit %s"]
/*
/*-------------------------------------------------------*/

if ( function_exists( 'add_shortcode' ) && ! function_exists( 'post_link_shortcode' ) ) {
  function post_link_shortcode( $atts ) {
    extract( shortcode_atts( array(
      'id' => '',
      'anchor' => '',
      'title' => '',
      'text' => '',
      'class' => '',
    ), $atts ) );

    if ( empty( $id ) ) {
      global $post;
      $id = $post->ID;
    }

    $permalink = get_permalink( $id );
    if ( empty( $permalink ) ) {
      return '';
    }
    if ( 'yes' !== $anchor ) {
      return $permalink;
    }

    if ( empty( $title ) ) {
      $title = sprintf( 'Permalink to %s', get_the_title( $id ) );
    } elseif ( 1 === substr_count ( $title, '%s' ) ) {
      $title = sprintf( $title, get_the_title( $id ) );
    }
    if ( empty( $text ) ) {
      $text = get_the_title( $id );
    }  elseif ( 1 === substr_count ( $text, '%s' ) ) {
      $text = sprintf( $text, get_the_title( $id ) );
    }

    $anchor = sprintf( '<a href="%s" title="%s" class="%s">%s</a>', $permalink, $title, $class, $text );

    return $anchor;
  }
  add_shortcode( 'post', 'post_link_shortcode' );
}

/*-------------------------------------------------------*/
/* Image Shortcode
/*-------------------------------------------------------*/

function rebel_img($atts, $content = "", $shortcodename = ""){
                return '<img src="'.$atts['src'].'" alt="" style="border: 1px solid #eee" />';
}

add_shortcode('img','rebel_img');

// user IP address
function display_user_ip() {
        $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
}
add_shortcode('user_ip', 'display_user_ip');

?>