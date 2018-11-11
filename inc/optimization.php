<?php

/**
 * Deenqueue scripts and styles.
 */
function ionpeblog_deenqueue() {

	// instagram-feed
	wp_dequeue_style( 'sb_instagram_styles' );
	wp_dequeue_style( 'sb-font-awesome' );

	// CF7
	wp_dequeue_style( 'contact-form-7' );

	// Post Views Counter
	wp_dequeue_style( 'post-views-counter-frontend' );

	// Google Fonts
	wp_dequeue_style( 'tp-open-sans' );
	wp_dequeue_style( 'tp-raleway' );
	wp_dequeue_style( 'tp-droid-serif' );

}

add_action( 'wp_enqueue_scripts', 'ionpeblog_deenqueue', 9999 );