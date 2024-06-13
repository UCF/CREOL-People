<?php

function people_display() {
    $args = array(
        'posts_per_page' => -1,
        'post_type'      => 'person',
        'post_status'    => 'publish',
        'category_name'  => 'core-faculty',
        'meta_key'       => 'person_orderby_name',
        'orderby'        => 'meta_value',
        'order'          => 'ASC'
    );

    $posts = get_posts($args);

    if (!empty($posts)) {
        echo '<style>
            .custom-card {
                border: none;
                border-radius: 10px;
                text-align: center;
            }
            .custom-card img {
                width: 200px;
                height: 250px;
                object-fit: cover;
                border-radius: 10px;
                display: block;
                margin: 0 auto;
            }
            .custom-card .card-body {
                padding-top: 10px;
                width: 100%;
            }
            .custom-card .card-title a {
                color: #333;
                text-decoration: none;
                font-size: 1rem;
                display: block;
                margin-bottom: 0;
            }
            .custom-card .card-title a:hover {
                color: #555;
            }
            .job-title {
                font-size: 0.85rem;
                color: #666;
                margin-top: 5px;
                display: block;
            }
        </style>';

        echo '<div class="row">';
        foreach ($posts as $post) {
            setup_postdata($post);
            $featured_image = get_the_post_thumbnail($post->ID, 'full');
            $job_title = get_field('person_jobtitle', $post->ID);

            echo '<div class="col-lg-2 col-md-3 col-sm-4 col-6">';
            echo '<div class="card custom-card">';
            if (!empty($featured_image)) {
                echo $featured_image;
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title"><a href="' . get_permalink($post) . '">' . get_the_title($post) . '</a></h5>';
            if (!empty($job_title)) {
                echo '<div class="job-title">' . esc_html($job_title) . '</div>';
            }
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
