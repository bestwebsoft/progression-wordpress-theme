<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @subpackage Progression
 * @since      Progression 1.3
 */
// If the current post is protected by a password and the visitor has not yet
// entered the password we will return early without loading the comments.
if ( post_password_required() ) :
	_e( 'This post is password protected. Enter the password to view comments.', 'progression' );

	return;
endif;
if ( have_comments() ) : ?>
	<div id="comments" class="comments-area">
		<h3>
			<?php printf( _n( 'One comment', '%s comments', get_comments_number(), 'progression' ), number_format_i18n( get_comments_number() ) ); ?>
		</h3>
		<div class="navigation">
			<?php paginate_comments_links(); ?>
		</div>
		<ol class="commentlist">
			<?php wp_list_comments( array(
				'reply_text' => __( 'Reply', 'progression' ),
			) ); ?>
		</ol>
		<div class="navigation">
			<?php paginate_comments_links(); ?>
		</div><!-- END lower navigation -->
	</div><!-- END comments -->
<?php else : // this is displayed if there are no comments so far
	if ( comments_open() ) :
		// If comments are open, but there are no comments.
	else :
		// comments are closed -->
		if ( ! is_page() ) : ?>
			<p><?php __( 'Comments are closed.', 'progression' ); ?></p>
		<?php endif; // end if is page
	endif; // end if comments open
endif; // end if have comments
if ( comments_open() ) :
	comment_form( array(
		'comment_field'       => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'comment_notes_after' => false,
	) );
endif;
