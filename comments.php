<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Allout_Travel
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

<div id="comments" class="comments-area">

	<?php // You can start editing here -- define how comments are displayed. ?>

	<?php if ( have_comments() ) : // Check if there are comments. ?>
		<h2 class="comments-title">
			<?php
			$allouttravel_comment_count = get_comments_number();
			if ( '1' === $allouttravel_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'allout-travel' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $allouttravel_comment_count, 'comments title', 'allout-travel' ) ),
					number_format_i18n( $allouttravel_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><?php the_comments_navigation(); // Navigation for paginated comments. ?>

		<ol class="comment-list">
			<?php
			// Display the list of comments.
			wp_list_comments(
				array(
					'style'       => 'ol', // Use an ordered list.
					'short_ping'  => true, // Use a shorter display for pings and trackbacks.
					'avatar_size' => 60,   // Avatar size in pixels.
                    'reply_text'  => esc_html__( 'Reply', 'allout-travel' ), // Text for the reply link.
                    // You can also use a custom callback function here for full HTML control of each comment.
				)
			);
			?>
		</ol><?php
		the_comments_navigation(); // Navigation for paginated comments (bottom).

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'allout-travel' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().
	?>

	<?php
	// Display the comment form.
	comment_form(
		array(
			'title_reply'         => esc_html__( 'Leave a Reply', 'allout-travel' ),
			'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'allout-travel' ),
			'cancel_reply_link'   => esc_html__( 'Cancel Reply', 'allout-travel' ),
			'label_submit'        => esc_html__( 'Post Comment', 'allout-travel' ),
			'comment_field'       => '<p class="comment-form-comment"><label for="comment">' . esc_html_x( 'Comment', 'noun', 'allout-travel' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
            // You can customize fields, notes, etc. here.
            // For example, to change the note before fields:
            // 'comment_notes_before' => '<p class="comment-notes">' . esc_html__( 'Your email address will not be published. Required fields are marked *', 'allout-travel' ) . '</p>',
		)
	);
	?>

</div>