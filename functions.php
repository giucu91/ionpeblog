<?php
/**
 * Ion Pe Blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ion_Pe_Blog
 */

if ( ! function_exists( 'ionpeblog_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ionpeblog_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Ion Pe Blog, use a find and replace
		 * to change 'ionpeblog' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ionpeblog', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ionpeblog' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Blog list image size
		add_image_size( 'ionpeblog-blog-list', 710, 430, array( 'center', 'center' ) );
		add_image_size( 'ionpeblog-blog-related', 400, 254, array( 'center', 'center' ) );

	}
endif;
add_action( 'after_setup_theme', 'ionpeblog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ionpeblog_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ionpeblog_content_width', 640 );
}
add_action( 'after_setup_theme', 'ionpeblog_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ionpeblog_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ionpeblog' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ionpeblog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ionpeblog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ionpeblog_scripts() {

	wp_enqueue_style( 'ionpeblog-style', get_stylesheet_directory_uri() . '/assets/css/main.min.css' );

	// Scripts
	// wp_enqueue_script( 'ionpeblog-owlcarousel', get_stylesheet_directory_uri() . '/assets/js/owlcarousel/owl.carousel.min.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'ionpeblog-front', get_stylesheet_directory_uri() . '/assets/js/main.min.js', array( 'jquery' ), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ionpeblog_scripts' );

function ionpeblog_views( $id ) {

	if ( ! function_exists( 'pvc_get_post_views' ) ) {
		return 54;
	}

	$views = pvc_get_post_views( $id );
	return $views;

}

/**
 * Implement the Shortcodes.
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom post.
 */
require get_template_directory() . '/inc/custom-post.php';

/**
 * Breadcrumbs.
 */
require get_template_directory() . '/inc/class-ionpeblog-breadcrumbs.php';

/**
 * Optimization.
 */
require get_template_directory() . '/inc/optimization.php';
