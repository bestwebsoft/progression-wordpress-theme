<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements
 *
 * @subpackage Progression
 * @since      Progression 1.3
 */
?>
<footer id="footer-wrap">
	<div id="footer-content" class="clearfix">
		<p class="copyright">
			<?php echo '&copy;' . '&nbsp;' . date_i18n( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '<br />';
			printf( __( 'Powered by %1$s and %2$s', 'progression' ), '<a href="' . esc_url( wp_get_theme()->get( 'AuthorURI' ) ) . '">' . wp_get_theme()->get( 'Author' ) . '</a>', '<a href="' . esc_url( 'http://wordpress.org' ) . '">WordPress</a>' ); ?>
		</p>
		<?php wp_footer(); ?>
		<!-- Don't forget analytics -->
		<div> <!-- END footer-content -->
</footer>
</div><!-- END main-page-wrap -->
</body>
</html>
