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
/* Add HTML5 Prefetch and Prerender
/* Credit tp Patrick Chia - http://patrick.bloggles.info/
/*-------------------------------------------------------*/
if ($options['html5_preload'] == 'Yes') {
	add_filter('next_post_rel_link', 'prefetch_next_post_rel');
	add_filter('previous_post_rel_link', 'prefetch_previous_post_rel');
	add_action('wp_head', 'front_page_prefetch');
}
/* Add Prefetch and Prenreder to Post Page */
if (!function_exists('prefetch_next_post_rel')){
	function prefetch_next_post_rel($link){
		$link = str_replace("next", "next prefetch prerender", $link);
		return $link;
	}
}
if (!function_exists('prefetch_previous_post_rel')){
	function prefetch_previous_post_rel($link){
		$link = str_replace("prev", "prev prefetch prerender", $link);
		return $link;
	}
}
 
/* Add Prefetch and Prenreder to front Page */
if (!function_exists('front_page_prefetch')){
	function front_page_prefetch(){
		global $wp_query;
			if ( is_front_page() && (get_query_var('paged') < $wp_query->max_num_pages) ) { 
						
echo '<link rel="prefetch prerender" href="'. get_next_posts_page_link() .'" />';
		}
	}
}
?>