<?php

function people_display() {
    $args = array(
        'posts_per_page' => -1, 
        'post_type' => 'people',   
        'post_status' => 'publish'
    );

    $posts = get_posts($args);

    if (!empty($posts)) {
        echo '<ul>';
        foreach ($posts as $post) {
            setup_postdata($post);
            echo '<li><a href="' . get_permalink($post) . '">' . get_the_title($post) . '</a></li>';
        }
        echo '</ul>';
        wp_reset_postdata(); 
    } else {
        echo 'No posts found.';
    }
}