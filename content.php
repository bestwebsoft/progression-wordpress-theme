<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @subpackage Progression
 * @since      Progression 1.3
 */

$first_page = true; ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'post main' ); ?>>
		<h1>
			<?php if ( ! is_singular() ) {
				echo '<a href="' . get_the_permalink() . '" >' . get_the_title() . '</a>';
			} else {
				the_title();
			} ?>
		</h1>
		<!-- Post meta info "Posted on 7 of January, 2012 by Paul in Uncategorized" for example -->
		<div class="meta">
			<?php if ( is_sticky() ) : ?>
				<em class="sticky"><?php _e( 'Sticky Post', 'progression' ); ?></em>
			<?php endif; ?>
			<em><?php _e( 'Posted on', 'progression' ); ?></em>
			<?php if ( is_singular() ) {
				$prgrssn_date_link = get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) );
			} else {
				$prgrssn_date_link = get_the_permalink();
			} ?>
			<a href="<?php echo esc_url( $prgrssn_date_link ); ?>" title="<?php the_title_attribute(); ?>">
				<?php _e( 'of', 'progression' );
				echo get_the_date(); ?>
			</a>
			<em><?php _e( 'by', 'progression' ); ?></em> <?php the_author_posts_link();
			if ( ! is_page() && has_category() ) : ?>
				<em><?php _e( 'in', 'progression' ); ?></em> <?php the_category( ', ' );
			endif; ?>
		</div>
		<!-- Featured image -->
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="featured-image">
				<?php the_post_thumbnail( 'featured-image' );
				do_action( 'progression_post_thumbnail_caption' ); ?>
			</div>
		<?php endif; ?>

		<article class="entry clearfix">
			<?php if ( is_category() || is_archive() ) :
				the_excerpt();
			else :
				the_content( __( 'Read more...', 'progression' ) );
			endif; ?>
			<div class="link-pages">
				<?php wp_link_pages( array(
					'before'         => __( 'Pages:', 'progression' ) . ' ',
					'next_or_number' => 'number',
				) ); ?>
			</div>
		</article>

		<div class="post-footer clearfix">
			<?php the_tags( '<div class="post-tags">', ', ', '</div>' );
			if ( comments_open() ) : ?>
				<div class="comments-link">
					<?php comments_popup_link( '<span class="leave-comment">' . __( 'Leave a comment', 'progression' ) . '</span>', __( '1 Comment', 'progression' ), __( '% Comments', 'progression' ) ); ?>
				</div><!-- .comments-link -->
			<?php endif; // comments_open() ?>
			<div class="scroll-edit-container">
				<?php if ( ! is_singular() && ! $first_page ) : ?>
					<div class="scroll-up"><a href="#content"><?php _e( '[Top]', 'progression' ); ?></a></div>
				<?php endif;
				if ( current_user_can( 'edit_post', $post->ID ) ) :
					edit_post_link( __( '[Edit this entry]', 'progression' ), '<div class="edit-entry">', '</div>' );
				endif; ?>
			</div>
			<?php if ( is_singular() ) : ?>
				<div class="pagination">
					<?php if ( is_attachment() ) : ?>
						<div class="prev-image"><?php previous_image_link( false, '&#8592; ' . __( 'Previous Image', 'progression' ) ); ?></div>
						<div class="next-image"><?php next_image_link( false, __( 'Next Image', 'progression' ) . '&#8594;' ); ?></div>
					<?php else : ?>
						<div class="prev-posts"><?php previous_post_link( '&#8592; %link' ); ?></div>
						<div class="next-posts"><?php next_post_link( '%link &#8594;' ); ?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( is_singular() ) :
			comments_template();
		endif; ?>

	</div><!-- End main -->
	<?php $first_page = false;
endwhile;
else : ?>
	<h1><?php _e( 'No posts found.', 'progression' ) ?></h1>
	<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'progression' ); ?></p>
	<p><?php the_widget( 'WP_Widget_Search' ); ?></p>
<?php endif;
