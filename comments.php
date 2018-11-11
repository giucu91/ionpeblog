<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ion_Pe_Blog
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<?php if ( have_comments() ) : ?>
<div id="comments" class="comments-area">
		<h3 class="comments-title">
			Comentarii <span class="accent-color">( <?php echo get_comments_number() ?> )</span>
		</h3><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'callback'    => 'ionpeblog_comment_html',
				'avatar_size' => 70,
			) );
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'ionpeblog' ); ?></p>
			<?php
		endif;
	?>

</div><!-- #comments -->

<?php endif; ?>

<?php
comment_form( array(
	'title_reply' => 'Ce zici?',
	'format' => 'html5',
	'fields' => array(
		'author'  => '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="' . __( 'Nume' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $html_req . ' /></p>',
		'email'   => '<p class="comment-form-email"><input id="email" name="email" type="email" placeholder="' . __( 'Email' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $html_req . ' /></p>',
		'url'     => '<p class="comment-form-url"><input id="url" name="url" type="url"  placeholder="' . __( 'Website' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
	),
	'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" placeholder="' . _x( 'Comment', 'noun' ) . '" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
	'label_submit' => 'Postează Comentariu',
	'comment_notes_before' => '',
) );
?>