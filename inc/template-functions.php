<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Ion_Pe_Blog
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ionpeblog_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// If is homepage
	if ( is_front_page() && is_home() ) {
		$classes[] = 'front-page';
	}

	if ( ! is_front_page() && ! is_singular( 'post' ) && ! is_post_type_archive( 'portfoliu' ) ) {
		$classes[] = 'have-breadcrumbs';
	}

	return $classes;
}
add_filter( 'body_class', 'ionpeblog_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ionpeblog_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ionpeblog_pingback_header' );


function ionpeblog_before_comm_fields() {
	echo '<div class="comments-fields">';
}

add_action( 'comment_form_before_fields', 'ionpeblog_before_comm_fields' );

function ionpeblog_after_comm_fields() {
	echo '</div>';
}
add_action( 'comment_form_after_fields', 'ionpeblog_after_comm_fields' );