<?php

if (!function_exists('get_recent_posts')) {

    function get_recent_posts($no_posts = 5, $before = '<li>', $after = '</li>', $show_excerpts = false) {
        /** Define ABSPATH as this files directory */
        define('ABSPATH', dirname(__FILE__) . '/../../../');
        include_once(ABSPATH . "wp-config.php");
        include_once(ABSPATH . "wp-load.php");
        include_once(ABSPATH . "wp-includes/wp-db.php");
        include_once(ABSPATH . "wp-includes/post.php");

        global $wpdb;
        $recent_posts = wp_get_recent_posts($no_posts);
        $output = '';

        foreach ($recent_posts as $post) {
            $output .= $before . '<a href="' . get_permalink($post["ID"]) . '" title="' .
                    $post["post_title"] . '" >' . $post["post_title"] . '</a>' . $after;
        }
        return $output;
    }

}

?>
