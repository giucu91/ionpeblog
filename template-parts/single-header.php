<?php

global $post;

$style = '';
if ( has_post_thumbnail( $post ) ) {
	$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	$style = 'style="background-image:url(' . $image_src[0] . ')"';
}

?>
<div id="post-header" <?php echo $style ?>>
	<div class="post-header-content">
		<h1><?php the_title() ?></h1>
		<div class="post-header-meta">
			<?php ionpeblog_entry_meta(); ?>
		</div>
	</div>
</div>