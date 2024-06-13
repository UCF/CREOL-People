<?php

function people_display() {
    $args = array(
        'posts_per_page' => -1, 
        'post_type' => 'person',   
        'post_status' => 'publish',
		'category_name'  => 'core-faculty'
    );

    $posts = get_posts($args);

	ob_start();
    var_dump($posts);
    $result = ob_get_clean();

    echo "<script>console.log(" . json_encode($result) . ");</script>";

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