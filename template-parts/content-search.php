<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ion_Pe_Blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="category-container">
		<?php echo get_the_category_list(); ?>
	</div>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		
		<div class="entry-meta">
			<?php ionpeblog_entry_meta(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ): ?>
	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php

		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'ionpeblog-blog-list' );
		echo '<img class="ionpeblog-lazy" data-src="' . $image_src[0] . '" alt="' . esc_html ( get_the_title() ) . '">';

		?>
	</a>	
	<?php endif ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php ionpeblog_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
