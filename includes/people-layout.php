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
        echo '<div class="row">';
        foreach ($posts as $post) {
            setup_postdata($post);
            $featured_image = get_the_post_thumbnail($post->ID, 'thumbnail');

            echo '<div class="col-lg-2 col-md-3 col-sm-4 col-6">';
            echo '<div class="card mb-4">'; 
            if (!empty($featured_image)) {
                echo '<img src="' . get_the_post_thumbnail_url($post->ID, 'thumbnail') . '" class="card-img-top" alt="' . get_the_title($post) . '">'; 
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title"><a href="' . get_permalink($post) . '">' . get_the_title($post) . '</a></h5>';
            echo '</div>'; 
            echo '</div>'; 
            echo '</div>'; 
        }
        echo '</div>'; 
        wp_reset_postdata();
    } else {
        echo 'No posts found.';
    }
}
