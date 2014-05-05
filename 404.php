<?php

/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
if ( class_exists( 'Clean_404_Email' ) ) {
    new Clean_404_Email;
}

get_header();
?>
	
	<div id="sidebar_layout" class="clearfix">
		<div class="sidebar_layout-inner">
			<div class="row-fluid grid-protection">

				<?php get_sidebar( 'left' ); ?>
				
				<!-- CONTENT (start) -->
	
				<div id="content" class="<?php echo themeblvd_get_column_class('content'); ?> clearfix" role="main">
					<div class="inner">
						<?php themeblvd_content_top(); ?>			
						<?php get_template_part( 'content', themeblvd_get_part( '404' ) ); ?>
						<h1 class="entry-title"><?php _e( 'Error 404 - Page Not Found', 'genesis' ); ?></h1>
							<div class="entry-content">
								<p><?php printf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it with the information below.', 'genesis' ), home_url() ); ?></p>

								
								<div>When communicating via HTTP, a server is required to respond to a request, such as a web browser&#39;s request for a web page, with a numeric response code and an optional, mandatory, or disallowed (based upon the status code) message. In the code 404, the first digit indicates a client error, such as a mistyped Uniform Resource Locator (URL). The following two digits indicate the specific error encountered. HTTP&#39;s use of three-digit codes is similar to the use of such codes in earlier protocols such as FTP and NNTP.</div>
								<br>
								<div>At the HTTP level, a 404 response code is followed by a human-readable &quot;reason phrase&quot;. The HTTP specification suggests the phrase &quot;Not Found&quot;[2] and many web servers by default issue an HTML page that includes both the 404 code and the &quot;Not Found&quot; phrase.</div>
								<br>
								<div>A 404 error is often returned when pages have been moved or deleted. In the first case, a better response is to return a 301 Moved Permanently response, which can be configured in most server configuration files, or through URL rewriting; in the second case, a 410 Gone should be returned. Because these two options require special server configuration, most websites do not make use of them.</div>
								<br>
								<div>404 errors should not be confused with DNS errors, which appear when the given URL refers to a server name that does not exist. A 404 error indicates that the server itself was found, but that the server was not able to retrieve the requested page.  (Sourced from Wikipedia)</div>
								<br>
								<div>Please contact a site administrator if this page was not found in error and something is missing.</div>
								<br>
							</div><!-- end .entry-content -->
					</div><!-- .inner (end) -->
				</div><!-- #content (end) -->
					
				<!-- CONTENT (end) -->	
				
				<?php get_sidebar( 'right' ); ?>
			
			</div><!-- .grid-protection (end) -->
		</div><!-- .sidebar_layout-inner (end) -->
	</div><!-- #sidebar_layout (end) -->

<?php get_footer(); ?>