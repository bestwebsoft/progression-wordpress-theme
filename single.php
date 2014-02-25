<?php
/**
 * The Template for displaying all single posts.
 *
 * @subpackage Progression
 * @since Progression 1.3
 */
get_header(); ?>
<div id="main-section-wrap" class="clearfix">
	<!-- Content goes here -->
	<div id="content">
		<?php get_template_part( 'content' ); ?>
	</div> <!-- END content -->
	<!-- Sidebar goes here -->
	<?php get_sidebar(); ?>
</div>  <!-- END main-section-wrap -->
<?php get_footer(); ?>