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
        // Use a div with row class for the grid
        echo '<div class="row">';
        foreach ($posts as $post) {
            setup_postdata($post);
            $featured_image = get_the_post_thumbnail($post->ID, 'thumbnail');

            echo '<div class="col-md-2">';
            echo '<div class="card">';
            if (!empty($featured_image)) {
                echo '<div class="card-img-top">' . $featured_image . '</div>'; 
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title"><a href="' . get_permalink($post) . '">' . get_the_title($post) . '</a></h5>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>'; // Close row
        wp_reset_postdata();
    } else {
        echo 'No posts found.';
    }
}
