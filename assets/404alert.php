<?php
/*-------------------------------------------------------*/
/* Jumpstart Child Theme - Rebel customized for eManager
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* 404 Alert
/*-------------------------------------------------------*/
// WP 404 ALERTS @ http://wp-mix.com/wordpress-404-email-alerts/
// Reworked @ http://werdswords.com/get-clean-404-email-alerts-from-your-wordpress-site/
// Just require() this class via your theme's functions.php file.
/* Then instantiate this at the top of your 404.php file with:
if ( class_exists( 'Clean_404_Email' ) )
	new Clean_404_Email;
*/
class Clean_404_Email {
 
	var $time, $request, $blog, $email, $theme, $theme_data, $site, $referer, $string, $address, $remote, $agent, $message;
 
	function __construct() {
		$this->headers();
		$this->setup_vars();
		$this->setup_email();
		$this->send_mail();
	}
	
	function headers() {
		echo header( "HTTP/1.1 404 Not Found" );
		echo header( "Status: 404 Not Found" );
	}
	
	function setup_vars() {
		$this->blog  = get_bloginfo( 'name' );
		$this->site  = home_url( '/' );
		$this->email = get_bloginfo( 'admin_email' );
		
		// theme info
		if ( ! empty( $_COOKIE["nkthemeswitch" . COOKIEHASH] ) ) {
		     $this->theme = $this->clean( $_COOKIE["nkthemeswitch" . COOKIEHASH] );
		} else {
		     $this->theme_data = wp_get_theme();
		     $this->theme = $this->clean( $this->theme_data->Name );
		}
 
		// referrer
		$this->referer = isset( $_SERVER['HTTP_REFERER'] ) ? $this->clean( $_SERVER['HTTP_REFERER'] ) : 'undefined';
 
		// request URI
		$this->request = isset( $_SERVER['REQUEST_URI'] ) && isset( $_SERVER['HTTP_HOST'] ) ? $this->clean( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) : 'undefined';
 
		// query string
		$this->string = isset( $_SERVER['QUERY_STRING'] ) ? $this->clean( $_SERVER['QUERY_STRING'] ) : 'undefined';
 
		// IP address
		$this->address = isset( $_SERVER['REMOTE_ADDR'] ) ? $this->clean( $_SERVER['REMOTE_ADDR'] ) : 'undefined';
 
		// user agent
		$this->agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $this->clean( $_SERVER['HTTP_USER_AGENT'] ) : 'undefined';
 
		// identity
		$this->remote = isset( $_SERVER['REMOTE_IDENT'] ) ? $this->clean( $_SERVER['REMOTE_IDENT'] ) : 'undefined';
 
		// log time
		$this->time = $this->clean( date( "F jS Y, h:ia", time() ) );		
	}
 
	function clean( $string ) {
	     $string = rtrim( $string );
	     $string = ltrim( $string );
	     $string = htmlentities( $string, ENT_QUOTES );
	     $string = str_replace( "\n", "<br />", $string );
 
	     if ( get_magic_quotes_gpc() ) {
	          $string = stripslashes( $string );
	     }
	     return $string;
	}
 
	function setup_email() {
		$this->message = '
		<html><body>
		<table width="70%" border="1" style="border-color: #777;" cellpadding="10">
			<colgroup width="25%" style="text-align:right;" />
			<colgroup id="colgroup" class="colgroup" width="1*" valign="middle" span="2" align="center" />
			<thead>
				<tr>
					<th scope="col">Element</th>
					<th scope="col">Data</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td>User Agent</td>
					<td>' . $this->agent . '</td>
				</tr>
			</tfoot>
			<tbody>
				<tr>
					<td>Date/Time</td>
					<td>' . $this->time . '</td>
				</tr>
				<tr>
					<td>404 URL</td>
					<td>' . $this->request . '</td>
				</tr>
				<tr>
					<td>Site</td>
					<td>' . $this->site . '</td>
				</tr>
				<tr>
					<td>Theme</td>
					<td>' . $this->theme . '</td>
				</tr>
				<tr>
					<td>Referer</td>
					<td>' . $this->referer . '</td>
				</tr>
				<tr>
					<td>Query String</td>
					<td>' . $this->string . '</td>
				</tr>
				<tr>
					<td>Remote Address</td>
					<td>' . $this->address . '</td>
				</tr>
				<tr>
					<td>Remote Identity</td>
					<td>' . $this->remote . '</td>
				</tr>
			</tbody>
		</table>
		</body></html>';
	}
	
	function email_headers() {
		return sprintf( 'From: %s' . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n", $this->email );
	}
 
	function send_mail() {
		mail( $this->email, sprintf( '404 Alert: %1$s [ %2$s ]', $this->blog, $this->theme ), $this->message, sprintf( 'From: %s', $this->email_headers() ) );
	}
 
}
?>