<?php
/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Custom Login
/*-------------------------------------------------------*/

// changing the logo link from wordpress.org to your site 
function options_login_url() { echo home_url(); }

// changing the alt text on the logo to show your site name 
function options_login_title() { echo get_option('blogname'); }

function options_login_css() { 
  
    /*-------------------------------------------------------*/
    /* Lighten Darken Color Function
    /*-------------------------------------------------------*/
    function admincolourBrightness($hex, $percent) {
      // Work out if hash given
      $hash = '';
      if (stristr($hex,'#')) {
        $hex = str_replace('#','',$hex);
        $hash = '#';
      }
      /// HEX TO RGB
      $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
      //// CALCULATE
      for ($i=0; $i<3; $i++) {
        // See if brighter or darker
        if ($percent > 0) {
          // Lighter
          $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
        } else {
          // Darker
          $positivePercent = $percent - ($percent*2);
          $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
        }
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
          $rgb[$i] = 255;
        }
      }
      //// RBG to Hex
      $hex = '';
      for($i=0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        // Add a leading zero if necessary
        if(strlen($hexDigit) == 1) {
        $hexDigit = "0" . $hexDigit;
        }
        // Append to the hex string
        $hex .= $hexDigit;
      }
      return $hash.$hex;
    }

  $option_name = themeblvd_get_option_name();
  $options = get_option( $option_name );

  ?>
  
  <style>
          body.login {background: <?php print $options['bg_color']; ?> url('<?php print $options['bg_image']; ?>') <?php print $options['background_repeat']; ?> <?php print $options['background_align']; ?>;} 
          h1 a {background: url(<?php print get_stylesheet_directory_uri() . '/assets/images/login-logo.png'; ?>) no-repeat center !important;}
          #wp-submit {
              background-color: <?php echo $options['nav_high_color']; ?>;
              background-image: -moz-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
              background-image: -ms-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
              background-image: -webkit-gradient(linear, 0 0, 0 100%, from(<?php echo $options['nav_low_color']; ?>), to(<?php echo $options['nav_high_color']; ?>));
              background-image: -webkit-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
              background-image: -o-linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
              background-image: linear-gradient(top, <?php echo $options['nav_low_color']; ?>, <?php echo $options['nav_high_color']; ?>);
              background-repeat: repeat-x;
              filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $options['nav_low_color']; ?>', endColorstr='<?php echo $options['nav_high_color']; ?>', GradientType=0);
              border: 1px solid <?php echo admincolourBrightness($options['bg_color'], -1.5); ?>;
            }

</style>

<?php
}

/*-------------------------------------------------------*/
/* Admin Style
/*-------------------------------------------------------*/

add_action('login_head', 'options_login_css');
add_filter('login_headerurl', 'options_login_url');
add_filter('login_headertitle', 'options_login_title');
?>
