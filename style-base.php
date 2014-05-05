/*

Theme Name: Options Child Theme for Jumpstart

Theme URI: mailto:contact@blackreit.com

Description: Child theme with dynamic functions to make it easy for amateur developers.

Author: Matthew M. Emma

Author URI: http://www.blackreit.com/

Version: <?php echo ME_REBEL_VERSION ?>

License: GPLv3

License URI: http://www.gnu.org/copyleft/gpl.html

Tags: html5, css3, fixed, hb5

Template: jumpstart

Text Domain: jsoptions

*/

<?php



/*-------------------------------------------------------*/

/* Include Options

/*-------------------------------------------------------*/



	$option_name = themeblvd_get_option_name();

	$options = get_option( $option_name );



/*-------------------------------------------------------*/

/* Lighten Darken Color Function

/*-------------------------------------------------------*/

function colourBrightness($hex, $percent) {

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



/*-------------------------------------------------------*/

/* Minify My CSS

/*-------------------------------------------------------*/



	ob_start("compress");



	function compress($buffer) {

	    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

	    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

	    return $buffer;

  	}



/*-------------------------------------------------------*/

/* Three types of parent styles

/*-------------------------------------------------------*/



if ($options['rebel_style'] == 'default') {

	echo '@import url("'. ME_REBEL_URI .'assets/css/default.css");';

	}



if ($options['rebel_style'] == 'boxed') {

	echo '@import url("'. ME_REBEL_URI .'assets/css/boxed.css");';

	}



if ($options['rebel_style'] == 'stretch') {

	echo '@import url("'. ME_REBEL_URI .'assets/css/stretch.css");';

	}





/*-------------------------------------------------------*/

/* if Dark

/*-------------------------------------------------------*/



if ($options['dark_light'] == 'dark') {

	echo '@import url("'. ME_REBEL_URI .'assets/css/dark.css");';

	}



/*-------------------------------------------------------*/

/* Add Stylesheet

/*-------------------------------------------------------*/

include_once( ME_REBEL_DIRECTORY . '/assets/style.php');



/*-------------------------------------------------------*/

/* Close Minify

/*-------------------------------------------------------*/



  ob_end_flush();



?>