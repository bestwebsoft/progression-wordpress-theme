<?php 
 /**
  * The template for displaying 404 pages (Not Found).
  *
  * @subpackage Progression
  * @since Progression 1.3
  */
get_header(); ?>
<div id="main-section-wrap" class="clearfix">
	<div id="content">
		<main class="error">
			<h1><?php _e( 'Error 404 - Page Not Found', 'progression' ); ?></h1>
		</main>
	</div> <!-- END content -->
	<?php get_sidebar(); ?> 
</div> <!-- END main-section-wrap -->
<?php get_footer(); ?>