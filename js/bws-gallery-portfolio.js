/**
 *
 * Script is loaded only when the portfolio.php, portfolio-post.php, 
 * gallery-single-template.php or gallery-template.php is opened.
 * It appends the sidebar into the container. Otherwise it will drop down.
 *
 */

( function( $ ) {
	$( document ).ready( function() {
		var container = document.getElementById( 'container' );
		if ( container && container.className == 'site-content' ) {
			/*append sidebar into the container*/
			var sidebar = document.getElementById( 'sidebar' );
			sidebar.parentNode.removeChild( sidebar );
			container.appendChild( sidebar );
			container.className = container.className + ' clearfix';
		}
		/*if this is a gallery*/
		if ( document.body.className.match( /\bsingle-gallery\b/ ) 
		|| document.body.className.match( /\bpage-template-gallery-template-php\b/ ) ) {
			/*set apropriate paddings to the comment block*/
			var comments = document.getElementById( 'comments' );
			if ( comments ) {
				comments.style.borderTop = '1px solid rgb(229, 229, 229)';
				comments.style.paddingTop = '18px';
			} else {
				/*if there are no comments, set apropriate paddings to the respond block*/
				var respond = document.getElementById( 'respond' );
				if ( respond ) {
					respond.style.borderTop = '1px solid rgb(229, 229, 229)';
					respond.style.paddingTop = '18px';
				} /*end if respond*/
			} /*end if comments*/
		} /*end if this is gallery*/
	});
})( jQuery );