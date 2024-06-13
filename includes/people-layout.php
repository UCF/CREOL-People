<?php

function all_posts_display() {
    $args = array(
        'posts_per_page' => -1, // Retrieve all posts
        'post_type' => 'post',  // Only posts, not pages
        'post_status' => 'publish' // Only published posts
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo 'No posts found.';
    }

    wp_reset_postdata(); // Reset the global post object
}
