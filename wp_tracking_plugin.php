<?php
/**
 * Plugin Name: My Tracking Plugin
 * Description: Automatically append tracking parameter to external links.
 * Version: 1.0
 * Author: Andy Gaukrodger
 * License: GPL2
 */

// Hook the function to wp_footer action
add_action( 'wp_footer', 'my_tracking_plugin_add_tracking_parameter' );

function my_tracking_plugin_add_tracking_parameter() {
	// Check if user is logged in or if it's an admin page
	if ( is_user_logged_in() || is_admin() ) {
		return;
	}

	// Get the site URL
	$site_url = site_url();

	// Get all the links in the page
	$dom = new DOMDocument();
	@$dom->loadHTML( mb_convert_encoding( get_ob_content(), 'HTML-ENTITIES', 'UTF-8' ) );
	$links = $dom->getElementsByTagName( 'a' );

	// Loop through each link
	foreach ( $links as $link ) {
		$url = $link->getAttribute( 'href' );
		// Check if the link is external
		if ( ! empty( $url ) && ( strpos( $url, 'http://' ) === 0 || strpos( $url, 'https://' ) === 0 ) && strpos( $url, $site_url ) === false ) {
			// Append the tracking parameter to the URL
			$url = add_query_arg( 'utm_source', 'myplugin', $url );
			$link->setAttribute( 'href', $url );
		}
	}

	// Output the updated HTML
	echo $dom->saveHTML();
}

// Helper function to get the output buffer content
function get_ob_content() {
	$content = '';
	if ( ob_get_length() > 0 ) {
		$content = ob_get_contents();
		ob_end_clean();
	}

	return $content;
}
