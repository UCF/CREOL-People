<?php

function people_display() {
    $args = array(
        'posts_per_page' => -1,
        'post_type'      => 'person',
        'post_status'    => 'publish',
        'category_name'  => 'core-faculty'
    );

    $posts = get_posts($args);

    if (!empty($posts)) {
        // Include custom styles
        echo '<style>
            .custom-card {
                border: none; 
                border-radius: 10px;  
            }
            .custom-card img {
                width: 300px; 
                height: 200px;
				object-fit: cover; 
                border-radius: 10px;
            }
            .custom-card .card-body {
                padding: 10px;  
            }
            .custom-card .card-title a {
                color: #333; 
                text-decoration: none;  
            }
            .custom-card .card-title a:hover {
                color: #555;
            }
        </style>';

        echo '<div class="row">';
        foreach ($posts as $post) {
            setup_postdata($post);
            $featured_image = get_the_post_thumbnail($post->ID, 'full');

            echo '<div class="col-lg-2 col-md-3 col-sm-4 col-6">';
            echo '<div class="card custom-card">';
            if (!empty($featured_image)) {
                echo $featured_image;
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
