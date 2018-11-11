<?php
/**
 * Template part for displaying portfolios
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ion_Pe_Blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-gallery owl-carousel">
		<?php

		$images = get_post_meta( get_the_ID(), 'ionpeblog-portfolio-gallery', true );
		$images_ids = explode( ',', $images );
		if ( count( $images_ids ) > 0 ) {
			foreach ( $images_ids as $image_id ) {
				$url = wp_get_attachment_image_src( $image_id, 'full' );
				if ( $url ) {
					echo '<div class="ionpeblog-portfolio-item"><img src="' . $url[0] . '"></div>';
				}
			}
		}

		?>
	</div>
	<div class="ionpeblog-navigation">
		<div id="ionpeblog-navigation-prev"><svg aria-hidden="true" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="#252525" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path></svg></div>
		<div id="ionpeblog-navigation-next"><svg aria-hidden="true" data-prefix="fas" data-icon="chevron-right" class="svg-inline--fa fa-chevron-right fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="#252525" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path></svg></div>
	</div>
	<div class="entry-content row">
		<div class="col-md-9">
			<?php

			the_title( '<h1 class="entry-title">', '</h1>' );

			the_content();

			?>
		</div>
		<div class="col-md-3">
			<?php

			$clients = wp_get_object_terms( $post->ID,  'portfolio_clients' );
			if ( ! empty( $clients ) ) {
				if ( ! is_wp_error( $clients ) ) {
					echo '<div class="portfolio-item-part">';
					echo '<span class="accent-color">Client</span>';
					echo implode( ',', wp_list_pluck( $clients, 'name' ) );
					echo '</div>';
				}
			}

			$skills = wp_get_object_terms( $post->ID,  'portfolio_skills' );
			if ( ! empty( $skills ) ) {
				if ( ! is_wp_error( $skills ) ) {
					echo '<div class="portfolio-item-part">';
					echo '<span class="accent-color">Skills</span>';
					echo implode( ',', wp_list_pluck( $skills, 'name' ) );
					echo '</div>';
				}
			}

			$categories = wp_get_object_terms( $post->ID,  'portfolio_categories' );
			if ( ! empty( $categories ) ) {
				if ( ! is_wp_error( $categories ) ) {
					echo '<div class="portfolio-item-part">';
					echo '<span class="accent-color">Categorie</span>';
					echo implode( ',', wp_list_pluck( $categories, 'name' ) );
					echo '</div>';
				}
			}

			?>
			<div class="portfolio-item-part">
				<span class="accent-color">Da mai departe</span>
				<?php ionpeblog_social_share( get_permalink() ) ?>
			</div>
		</div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
