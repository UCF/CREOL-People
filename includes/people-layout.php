<?php

function people_display() {
    $sections = [
        'core-faculty' => 'Core Faculty',
        'joint-faculty' => 'Joint Faculty',
        'emeritus-faculty' => 'Emeritus Faculty',
        'courtesy-faculty' => 'Courtesy Faculty'
    ];

    foreach ($sections as $slug => $title) {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'person',
            'post_status'    => 'publish',
            'category_name'  => $slug, 
            'meta_key'       => 'person_orderby_name',
            'orderby'        => 'meta_value',
            'order'          => 'ASC'
        );

        $posts = get_posts($args);

        if (!empty($posts)) {
            echo "<h2>$title</h2>";
            echo '<style>
                .custom-card {
                    border: none;
                    border-radius: 10px;
                    text-align: center;
                    background: transparent;
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
                .custom-card a {
                    color: #fff;
                    text-decoration: none;
                    font-size: 0.85rem;
                    display: block;
                }
                .custom-card a:hover {
                    color: #f5f5f5;
                }
                .job-title {
                    font-size: 0.85rem;
                    color: #666;
                    margin-top: -1em;
                    margin-bottom: 0.5em;
                    display: block;
                }
                .card-title {
                    font-size: 1rem;
                }
            </style>';

            echo '<div class="row">';
            foreach ($posts as $post) {
                setup_postdata($post);
                $permalink = get_permalink($post);
                $featured_image = get_the_post_thumbnail($post->ID, 'full');
                $job_title = get_field('person_jobtitle', $post->ID);

                echo '<div class="col-lg-2 col-md-3 col-sm-4 col-6">';
                echo '<div class="card custom-card">';
                echo '<a href="' . $permalink . '">';
                if (!empty($featured_image)) {
                    echo $featured_image;
                }
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . get_the_title($post) . '</h5>';
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
}