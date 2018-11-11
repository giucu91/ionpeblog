<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Ion_Pe_Blog
 */

if ( ! function_exists( 'ionpeblog_entry_meta' ) ) :

	function ionpeblog_entry_meta() {
		global $post;

		$author_id = get_the_author_meta( 'ID' );
		if ( ! $author_id ) {
			$author_id = $post->post_author;
		}

		// Author
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'De : %s', 'post author', 'ionpeblog' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $author_id ) ) . '</a></span>'
		);

		// Date
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		$date = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		// Comments
		$ionpeblog_comment_count = get_comments_number();
		$comments = '<a href="' . get_permalink() . '#respond">' . $ionpeblog_comment_count . '</a> <span>' . _nx( 'Commentariu', 'Commentarii', $ionpeblog_comment_count, 'comments title', 'ionpeblog' ) . '</span>';

		// Vizualizare
		$numar_vizualizari = ionpeblog_views( get_the_ID() );
		$vizualizari = $numar_vizualizari . ' ' . _nx( 'Vizualizare', 'Vizualizari', $numar_vizualizari, 'comments title', 'ionpeblog' );

		printf( '<span class="ionpeblog-author">%s</span><span class="ionpeblog-separator">&bull;</span><span class="ionpeblog-date">%s</span><span class="ionpeblog-separator">&bull;</span></span><span class="ionpeblog-comments">%s</span><span class="ionpeblog-separator">&bull;</span><span class="ionpeblog-vizualizari">%s</span>', $byline, $date, $comments, $vizualizari );

	}

endif;

if ( ! function_exists( 'ionpeblog_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ionpeblog_entry_footer() {
		
		echo '<a href="' . get_permalink() . '" class="ionpeblog-readmore ionpeblog-button">Citeste tot</a>';

		ionpeblog_social_share( get_permalink() );

	}
endif;

if ( ! function_exists( 'ionpeblog_pagination' ) ) {
	function ionpeblog_pagination() {
		// Get total number of pages
		global $wp_query;
		$total = $wp_query->max_num_pages;
		// Only paginate if we have more than one page
		if ( $total > 1 )  {
		     // Get the current page
		     if ( !$current_page = get_query_var('paged') )
		          $current_page = 1;
		     // Structure of “format” depends on whether we’re using pretty permalinks
		     $format = empty( get_option('permalink_structure') ) ? '&page=%#%' : 'page/%#%/';
		     echo paginate_links(array(
		        'base'      => get_pagenum_link(1) . '%_%',
		        'format'    => $format,
		        'current'   => $current_page,
		        'total'     => $total,
		        'mid_size'  => 4,
		        'type'      => 'list',
		        'prev_text' => __('Previous'),
				'next_text' => __('Next'),
		     ));
		}
	}
}

if ( ! function_exists( 'ionpeblog_single_entry_footer' ) ) {

	function ionpeblog_single_entry_footer() {

		echo '<div class="ionpeblog-tags">';
		echo '<svg aria-hidden="true" data-prefix="fas" data-icon="tags" class="svg-inline--fa fa-tags fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M497.941 225.941L286.059 14.059A48 48 0 0 0 252.118 0H48C21.49 0 0 21.49 0 48v204.118a48 48 0 0 0 14.059 33.941l211.882 211.882c18.744 18.745 49.136 18.746 67.882 0l204.118-204.118c18.745-18.745 18.745-49.137 0-67.882zM112 160c-26.51 0-48-21.49-48-48s21.49-48 48-48 48 21.49 48 48-21.49 48-48 48zm513.941 133.823L421.823 497.941c-18.745 18.745-49.137 18.745-67.882 0l-.36-.36L527.64 323.522c16.999-16.999 26.36-39.6 26.36-63.64s-9.362-46.641-26.36-63.64L331.397 0h48.721a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882z"></path></svg>';
		echo get_the_tag_list('<span>TAGS: ',', ','</span>');
		echo '</div>';

		ionpeblog_social_share( get_permalink() );

	}

}

if ( ! function_exists( 'ionpeblog_comment_html' ) ) {
	function ionpeblog_comment_html( $comment, $args, $depth ) {
	    if ( 'div' === $args['style'] ) {
	        $tag       = 'div';
	        $add_below = 'comment';
	    } else {
	        $tag       = 'li';
	        $add_below = 'div-comment';
	    }?>
	    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php 
	    if ( 'div' != $args['style'] ) { ?>
	        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
	    } ?>
	    	<div class="comment-author-image">
	    		<?php
	    		if ( $args['avatar_size'] != 0 ) {
	                echo get_avatar( $comment, $args['avatar_size'] ); 
	            }
	            ?>
	    	</div>
	    	<div class="comment-informations">
	    		<div class="comment-author vcard">
		        	<?php printf( __( '<span class="fn">%s</span>' ), get_comment_author_link() ); ?>
		        </div><?php 
		        if ( $comment->comment_approved == '0' ) { ?>
		            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em><br/><?php 
		        } ?>
		        <div class="comment-meta comment-metadata">
		            <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
		                /* translators: 1: date, 2: time */
		                printf( 
		                    __('%1$s at %2$s'), 
		                    get_comment_date(),  
		                    get_comment_time() 
		                ); ?>
		            </a><?php 
		            edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
		        </div>
		        <div class="comment-content">
		        	<?php comment_text(); ?>
		        </div>
		        <div class="reply"><?php 
		                comment_reply_link( 
		                    array_merge( 
		                        $args, 
		                        array( 
		                            'add_below' => $add_below, 
		                            'depth'     => $depth, 
		                            'max_depth' => $args['max_depth'] 
		                        ) 
		                    ) 
		                ); ?>
		        </div>
	    	</div>
	        <?php 
	    if ( 'div' != $args['style'] ) : ?>
	        </div><?php 
	    endif;
	}
}

function ionpeblog_social_share( $url ){

	$gplus_url = '//plus.google.com/share?url=' . rawurlencode( $url );
	$fb_url    = '//www.facebook.com/sharer.php?u=' . rawurlencode( $url );

	?>

	<div class="ionpeblog-social-icons ionpeblog-social-share">
		<a href="<?php echo $fb_url ?>">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 512"><path d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229"></path></svg>
		</a>
		<a href="<?php echo $gplus_url ?>">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M386.061 228.496c1.834 9.692 3.143 19.384 3.143 31.956C389.204 370.205 315.599 448 204.8 448c-106.084 0-192-85.915-192-192s85.916-192 192-192c51.864 0 95.083 18.859 128.611 50.292l-52.126 50.03c-14.145-13.621-39.028-29.599-76.485-29.599-65.484 0-118.92 54.221-118.92 121.277 0 67.056 53.436 121.277 118.92 121.277 75.961 0 104.513-54.745 108.965-82.773H204.8v-66.009h181.261zm185.406 6.437V179.2h-56.001v55.733h-55.733v56.001h55.733v55.733h56.001v-55.733H627.2v-56.001h-55.733z"></path></svg>
		</a>
	</div>
	<?php
}

function ionpeblog_post_navigation() {

	$args = array(
		'prev_text'          => '<span class="meta-nav">Previous Post</span><span class="post-title">%title</span>',
		'next_text'          => '<span class="meta-nav">Next Post</span><span class="post-title">%title</span>',
		'in_same_term'       => false,
		'screen_reader_text' => ' ',
		'excluded_terms'     => '',
		'taxonomy'           => 'category',
	);

	$navigation = '';

	$style_prev = '';
	$style_next = '';
	$prev_post = get_previous_post();
	$next_post = get_next_post();

	if ( $prev_post && has_post_thumbnail( $prev_post ) ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post ), 'ionpeblog-blog-related' );
		$style_prev = 'style="background-image:url(' . $image[0] . ')"';
	}

	if ( $next_post && has_post_thumbnail( $next_post ) ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post ), 'ionpeblog-blog-related' );
		$style_next = 'style="background-image:url(' . $image[0] . ')"';
	}

	$previous = get_previous_post_link(
		'<div class="nav-previous"' . $style_prev . '>%link</div>',
		$args['prev_text'],
		$args['in_same_term'],
		$args['excluded_terms'],
		$args['taxonomy']
	);
	$next = get_next_post_link(
		'<div class="nav-next"' . $style_next . '>%link</div>',
		$args['next_text'],
		$args['in_same_term'],
		$args['excluded_terms'],
		$args['taxonomy']
	);

	// Only add markup if there's somewhere to navigate to.
	if ( $previous || $next ) {
		$navigation = _navigation_markup( $previous . $next, 'post-navigation', $args['screen_reader_text'] );
	}

	echo $navigation;

}