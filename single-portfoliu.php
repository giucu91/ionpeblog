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
		<main id="main" class="site-main col-md-12">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		endwhile; // End of the loop.
		?>
		</main><!-- #main -->

	</div><!-- #primary -->

<?php
get_footer();
