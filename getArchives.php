<?php

if (!function_exists('get_my_archives')) {

    function get_my_archives($before = '<li>' , $after = '</li>') {

        $args = array(
        'type' => 'monthly',
        'format' => 'html',
        'show_post_count' => false,
        'echo' => 0 );

        $archives = wp_get_archives($args);
        $output = $archives;
        return $output;
    }

}
?>
