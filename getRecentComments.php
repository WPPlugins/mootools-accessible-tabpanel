<?php

if (!function_exists('get_recent_comments')) {

    function get_recent_comments($no_comments = 5, $before = '<li>', $after = '</li>') {
        /** Define ABSPATH as this files directory */
        define('ABSPATH', dirname(__FILE__) . '/../../../');
        include_once(ABSPATH . "wp-config.php");
        include_once(ABSPATH . "wp-load.php");
        include_once(ABSPATH . "wp-includes/wp-db.php");

        global $wpdb;

        $time_difference = get_settings('gmt_offset');
        $now = gmdate("Y-m-d H:i:s", time());
        $request = "SELECT comment_ID, comment_post_ID, comment_author, comment_author_url ";
        $request .= "FROM $wpdb->comments WHERE ";
        $request .= "comment_date_gmt < '$now' ORDER BY comment_date DESC LIMIT 0, $no_comments";
        $comments = $wpdb->get_results($request);
        $output = '';

        if ($comments) {
            foreach ($comments as $comment) {
                $comment_author = $comment->comment_author;
                $comment_author_url = $comment->comment_author_url;
                $comment_ID = $comment->comment_ID;
                $comment_post_ID = $comment->comment_post_ID;
                $post = get_post($comment_post_ID);
                $title = $post->post_title;
                $output .= $before . '<a href="' . get_permalink($comment_post_ID) . '#comment-' . $comment_ID .
                        '" title="' . $title . '">' . esc_html($comment_author) . ' on ' . $title . '</a>';
                $output .= $after;
            }
        } else {
            $output .= $before . "None found" . $after;
        }
        return $output;
    }

}
?>
