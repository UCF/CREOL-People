<?php

/*
Shortcode Plugin widget: fetches faculty by group and displays people as cards on the faculty page 
*/

// Styling and displays the faculty cards
function people_display() {
    $sections = [ // Array
        'core-faculty' => 'Core Faculty',
        'joint-faculty' => 'Joint Faculty',
        'emeritus-faculty' => 'Emeritus Faculty',
        'courtesy-faculty' => 'Courtesy Faculty'
    ];

    // Collect people explicitly excluded by the ACF "Exclude" field.
    $excluded_people = [];

    echo '<style>
        .section-title {
            border-bottom: 3px solid #ffcc00;
        }
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
        .job-title {
            font-size: 0.85rem;
            color: #f5f5f5;
            margin-top: -1em;
            margin-bottom: 0.5em;
            display: block;
        }
        .card-title {
            font-size: 1rem;
        }
        
    </style>';

    // For each group of faculty fetch the posts and display cards 
    foreach ($sections as $slug => $title) { // Accessing the category name 
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

        $firstWord = explode(' ', $title)[0];
        echo "<h2 class='section-title auto-section mb-3 mt-3 pb-2' data-section-link-title='$firstWord' id='$firstWord'>$title</h2>";

        if (!empty($posts)) {
            
            echo '<div class="row mb-5">';
            foreach ($posts as $post) {
                setup_postdata($post);
                $exclude_field = get_field('exclude', $post->ID);

                // Treat truthy/yes values (including checkbox arrays) as excluded.
                $should_exclude = false;
                if (is_array($exclude_field)) {
                    $normalized_values = array_map('strtolower', array_map('strval', $exclude_field));
                    $should_exclude = array_intersect($normalized_values, ['1', 'true', 'yes', 'on']) ? true : false;
                } elseif (is_bool($exclude_field)) {
                    $should_exclude = $exclude_field;
                } elseif (is_string($exclude_field)) {
                    $should_exclude = in_array(strtolower($exclude_field), ['1', 'true', 'yes', 'on'], true);
                } elseif (is_numeric($exclude_field)) {
                    $should_exclude = ((int) $exclude_field) === 1;
                }

                if ($should_exclude) {
                    $excluded_people[] = $post->ID;
                    continue;
                }
                $permalink = get_permalink($post);
                $featured_image = get_the_post_thumbnail($post->ID, 'medium');
                $job_title = get_field('person_jobtitle', $post->ID);

                echo '<div class="card-box col-lg-2 col-md-3 col-sm-4 col-6">';
                echo '<div class="card custom-card">';
                echo '<a href="' . $permalink . '">';
                if (!empty($featured_image)) {
                    echo $featured_image;
                }
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . get_the_title($post) . '</h5>';
                if (!empty($job_title)) {
                    echo '<div class="job-title"><i>' . esc_html($job_title) . '</i></div>';
                }
                echo '</div>';
                echo '</a>';
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