<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ion_Pe_Blog
 */

get_header();
?>

	<div id="primary" class="content-area row">
		<main id="main" class="site-main col-lg-8">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->

		<div id="sidebar" class="col-lg-4">
			<?php get_sidebar(); ?>
		</div>
		
	</div><!-- #primary -->

<?php
get_footer();
