<?php

function people_display() {
	$array = array();

	$args         = array(
		'post_type'      => 'resources',
		'post_status'    => array( 'publish' ),
		'nopaging'       => true,
		'posts_per_page' => '-1',
		'order'          => 'ASC',
		'orderby'        => 'ID',

	);
	$queryResults = new WP_Query( $args );

	if ( $queryResults->have_posts() ) {
		$counter = 0;
		while ( $queryResults->have_posts() ) {
			$queryResults->the_post();
			$array[ $counter ][ 'ID' ]           = get_the_ID();
			$array[ $counter ][ 'name' ]         = get_the_title();
			$array[ $counter ][ 'thumbnailURL' ] = get_the_post_thumbnail_url();
			$array[ $counter ][ 'place' ]        = get_field( 'resource_location' );
			//etc etc etc

			$counter++;
		}

		$jasoned = json_encode( $array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
		echo $jasoned;
		?>
		<script>
			console.log(<?= json_encode($foo); ?>);
		</script>
		<?php
	} else {
		//nothing found
	}
	wp_reset_postdata();
}