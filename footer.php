<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements
 *
 * @subpackage Progression
 * @since Progression 1.3
 */
?>
		<footer id="footer-wrap">
			<div id="footer-content" class="clearfix">
				<p class="copyright">
					<?php _e( 'Progression Theme, Copyright', 'progression' ); ?> <?php echo date(" Y"); ?> <a href="<?php echo wp_get_theme()->get( 'AuthorURI' ); ?>">BestWebSoft</a><br>
					<?php printf( __( 'Proudly powered by', 'progression' ) ) ?><a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>"> WordPress</a>
				</p>
				<?php wp_footer(); ?>	
				<!-- Don't forget analytics -->
			<div> <!-- END footer-content -->
		</footer>
	</div><!-- END main-page-wrap -->
</body>
</html>