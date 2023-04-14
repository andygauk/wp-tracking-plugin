<?php
/*
Plugin Name: URL Parameter Appender
Plugin URI: https://isitablog.com
Description: Appends a URL parameter to every external link on your website.
Version: 1.0
Author: Andy Gaukrodger
Author URI: https://isitablog.com
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
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var links = document.querySelectorAll('a');
                for (var i = 0; i < links.length; i++) {
                    var link = links[i];
                    // Check if the link is external
                    if (link.href.indexOf('" . esc_url($site_url) . "') === -1) {
                        // Append the URL parameter to the external link
                        link.href = link.href + '?source=isitablog.com';
                    }
                }
            });
        </script>";
    }
}
?>
