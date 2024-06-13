<?php

function people_display() {
    $args = array(
        'posts_per_page' => -1, 
        'post_type' => 'person',   
        'post_status' => 'publish',
        'category_name'  => 'core-faculty'
    );

    $posts = get_posts($args);

    if (!empty($posts)) {
        echo '<ul>';
        foreach ($posts as $post) {
            setup_postdata($post);
            $featured_image = get_the_post_thumbnail($post->ID, 'thumbnail');

            echo '<li>';
            if (!empty($featured_image)) {
                echo $featured_image; 
            }
            echo '<a href="' . get_permalink($post) . '">' . get_the_title($post) . '</a>';
            echo '</li>';
        }
        echo '</ul>';
        wp_reset_postdata(); 
    } else {
        echo 'No posts found.';
    }
}
