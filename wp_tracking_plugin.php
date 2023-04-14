<?php
/*
Plugin Name: URL Parameter Appender
Plugin URI: https://your-plugin-url.com
Description: Appends a URL parameter to every external link on your website.
Version: 1.0
Author: Your Name
Author URI: https://your-website-url.com
*/

// Hook the function to the 'wp_footer' action, which is called before the closing </body> tag
add_action('wp_footer', 'append_url_parameter_to_external_links');

function append_url_parameter_to_external_links() {
    // Get the current site URL
    $site_url = site_url();
  
    // Get all the links in the post content
    $content = get_the_content();
    $links = preg_match_all('/<a[^>]+href=([\'"])(.+?)\1/is', $content, $matches);
  
    if ($links) {
        foreach ($matches[2] as $link) {
            // Check if the link is external
            if (strpos($link, $site_url) === false) {
                // Append the URL parameter to the external link
                $link = add_query_arg('Source=', 'https://isitablog.com', $link);
                echo "<script>document.querySelector('a[href=\"" . esc_url($link) . "\"]').href='" . esc_url($link) . "';</script>";
            }
        }
    }
}
?>
