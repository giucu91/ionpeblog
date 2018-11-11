<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ion_Pe_Blog
 */

get_header();
?>

	<div id="primary" class="content-area row">
		<main id="main" class="site-main col-md-12">
		<div class="portfolio-grid row">

		<?php
		if ( have_posts() ) :

			/* Start the Loop */
			while ( have_posts() ) : the_post();
				echo '<div class="portfolio-item">';
				echo '<a href="' . get_permalink() . '"></a>';
				the_post_thumbnail( 'full' );
				echo '</div>';
			endwhile;

			ionpeblog_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
