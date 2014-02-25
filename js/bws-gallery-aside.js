/**
 * This Script is loaded only when the BestWebSoft plugon gallery is placed into the sidebar of the page.
 * This script jystifies images in the BestwebSoft gallery plugin when they are placed in the sidebar.
 * The goal of this script is to make gallery look prettier in the sidebar.
 */
( function( $ ) {
	$( document ).ready( function() {	
		/*if there is a gallery in the sidebar*/
		if ( $( '#sidebar .gallery_box_single' ).length > 0 ) {
			var galleryWidth = $( '#sidebar .gallery' ).width();
			var galleryImgWidth = $( '#sidebar .gallery .gllr_image_block img:first' ).outerWidth();
			var galleryImg = $( '#sidebar .gllr_image_row:first .gllr_image_block');		
			/*find the quantity of images in the row*/
			if ( galleryImg.length > Math.floor( galleryWidth / galleryImgWidth ) ) {
				var	imgAmount = Math.floor( galleryWidth / galleryImgWidth );
			} else {
				var imgAmount = galleryImg.length;
			}
			/*find the remaining free space int the row*/
			var freeSpace = ( Math.floor( galleryWidth - ( galleryImgWidth * imgAmount ) ) );
			var galleryRows = $( '#sidebar .gllr_image_row');
			/*set appropriate margins for images*/
			galleryRows.each( function() {
				galleryImg = $( this ).find( '.gllr_image_block' );
				if ( imgAmount > 1 ) {
					freeSpace = ( Math.floor( galleryWidth - ( galleryImgWidth * imgAmount ) ) );
					var i = 0;
					galleryImg.each( function() {
						/*every first image in a row*/
						if ( i % imgAmount == 0 ) {
							$( this ).css( 'margin-right', freeSpace / (( imgAmount - 1 ) * 2 ) );
						/*every last item in a row*/
						} else if ( i % (imgAmount-1) == 0 ) {
							$( this ).css( 'margin-left', freeSpace / (( imgAmount - 1 ) * 2 ) );
						/*images in the middle*/
						} else {
							$( this ).css( 'margin-right', freeSpace / (( imgAmount - 1 ) * 2 ) ).css( 'margin-left', freeSpace / (( imgAmount - 1 ) * 2 ) );
						}
						i++;
					});
				}
			});
		}
		/*delete redundant twitter, google+, facebook buttons*/
		$( '.main.post .gallery_box_single #fcbk_share' ).remove();
		$( '#sidebar .gallery_box_single #fcbk_share' ).remove();
		$( '.main.post .gallery_box_single .twttr_button' ).remove();
		$( '#sidebar .gallery_box_single .twttr_button' ).remove();
		$( '.main.post .gallery_box_single .gglplsn_share' ).remove();
		$( '#sidebar .gallery_box_single .gglplsn_share' ).remove();
	});
})( jQuery );