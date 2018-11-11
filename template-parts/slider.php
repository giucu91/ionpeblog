<?php

$slider_query = new WP_Query( array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 5,
	'meta_query'     => array(
		array(
			'key'     => '_thumbnail_id',
			'value'   => '',
			'compare' => '!=',
		)
	),
) );

if ( $slider_query->have_posts() ) {
	echo '<ul id="main-slider" class="owl-carousel">';
	while ( $slider_query->have_posts() ) {
		$slider_query->the_post();

		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

		echo '<li>';
		// the_post_thumbnail( 'full' );
		echo '<img class="owl-lazy" data-src="' . $image_src[0] . '" alt="' . esc_html ( get_the_title() ) . '">';
		echo '<div class="slide-content">';
		echo '<h2>' . get_the_title() . '</h2>';
		echo '<p>' . get_the_date() . '</p>';
		echo '</div>';
		echo '<a class="slider-link" href="' . get_permalink() . '"></a>';
		echo '</li>';
	}
	echo '</ul>';
	/* Restore original Post Data */
	wp_reset_postdata();
}