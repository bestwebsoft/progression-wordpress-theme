<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * @subpackage Progression
 * @since Progression 1.3
 */
get_header(); ?>
<div id="main-section-wrap" class="clearfix">
	<!-- Content goes here -->
	<div id="content">
		<?php get_template_part( 'content' );
		do_action( 'progression_pagination' ); ?>
	</div> <!-- END content -->
	<!-- Sidebar goes here -->
	<?php get_sidebar(); ?>
</div>  <!-- END main-section-wrap -->
<?php get_footer(); ?>