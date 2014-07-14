<?php 
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @subpackage Progression
 * @since Progression 1.3
 */
get_header(); ?>
<div id="main-section-wrap" class="clearfix">
	<!-- Slider goes here --> 
	<?php if ( is_front_page() ) :
		do_action( 'progression_get_slider' );
	endif; ?>
	<!-- Content goes here -->
	<div id="content">
		<?php get_template_part( 'content' );
		do_action( 'progression_pagination' ); ?>
	</div> <!-- END content -->
	<!-- Sidebar goes here -->
	<?php get_sidebar(); ?>
</div>  <!-- END main-section-wrap -->
<?php get_footer(); ?>