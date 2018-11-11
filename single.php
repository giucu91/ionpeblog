<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

			get_template_part( 'template-parts/content', 'single' );

			ionpeblog_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->

		<div id="sidebar" class="col-lg-4">
			<?php get_sidebar(); ?>
		</div>

	</div><!-- #primary -->


<?php
get_footer();
