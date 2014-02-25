( function( $ ) {
	$( document ).ready( function() {
	
/**********************************************
 * Script for main navigation.
 **********************************************/

		var menuItems;
		/*If menu is enable*/
		if ( menuItems = document.getElementById( 'main-nav' ) ) {
			menuItems = menuItems.getElementsByTagName( 'li' );
			/*Figure out which menu items have sub items and mark them with .has-sub-items class.*/
			for ( var i = 0; i < menuItems.length; i++ ) {
				if ( menuItems[i].getElementsByTagName( 'li' ).length >= 1 ) {
					menuItems[i].className += ' has-sub-items';
				}
			}

			reverseMenu();
			$( window ).on( 'resize', reverseMenu );

		}/*End IF menu is enable*//*Конец IF Если есть меню*/

		/* Function that reflects the menu in the opposite direction, if it reaches the end of the screen. */
		function reverseMenu() {
			var vpWidth; /*viewport width*/
			var subMenu;
			var leftOffset; /*left offset of sub-menu item*/

			vpWidth = $( window ).width();
			subMenu = $( '#main-nav .has-sub-items ul ul' );
			if ( subMenu.length > 0 ) {
				subMenu.removeClass( 'reverse' ).removeClass( 'forward' );
				subMenu.each( function() {
					leftOffset = $( this ).offset().left;
					if ( ( vpWidth - leftOffset ) < 176 ) {
						$( this ).addClass( 'reverse' ).removeClass( 'forward' );
					} else if ( leftOffset < 10 ) {
						$( this ).addClass( 'forward' ).removeClass( 'reverse' );
					}
				});
			}
		}/* end reverseMenu */

		/*SCROLL UP button picks us up to the first post of the page.*/
		var scrolls =  $( '.scroll-up' );
		if ( scrolls.length > 0 ) {
			scrolls.click( function( event ) {
				event = event || window.event;
				event.preventDefault();
				$( 'html, body' ).animate({
	    			scrollTop: $( '#content' ).offset().top
				}, 500);
			});
		}



/**********************************************
 * Script to customize forms.
 **********************************************/

		var fakeDiv;

		/*** RADIO BUTTONS ***/
		/*target all default browser radios*/
		var dRadio = $( 'input[type=radio]' );
		/*if there is at least one radio on page*/
		if ( dRadio.length > 0 ) {
			/*create fake div with unchecked background*/
			fakeDiv = $( '<div class="j-radio">' );
			/*insert fake divs before each default radio*/
			dRadio.before(fakeDiv).hide(); /*HIDE HERE!*/
			/*target all fake divs that have been inserted -- call it jQuery Radio*/
			var jRadio = $( 'div.j-radio' );

			dRadio.each( function() {
				if ( $( this ).is( ':checked' ) ) {
					$( this ).prev().toggleClass( 'j-radio-checked' );
				}
			});
			/*target all default disabled radio*/
			dRadio = $( 'input[type=radio][disabled]' )
			/*all fake disabled will have j-radio-disabled class*/
			dRadio.prev().addClass( 'j-radio-disabled' ).fadeTo( 0, .25 );
			
			/*when user clicks fake div*/
			jRadio.click( function() {
			    /*if clicked radio was disabled */
			    if ( $( this ).hasClass( 'j-radio-disabled' ) ) {
			    	return;
			    }
			    /*when user click fake div button make 
				the default radiobutton be clicked as well*/
			    $( this ).next().trigger( 'click' );

			    var radioName = $( this ).next().attr( 'name' );
			    /*target default radio buttons group united by the same name*/
			    var dRadio = 'input[type=radio][name=' + radioName + ']';
			    /*target jQuery radio buttons group united by the same name*/
				var jRadio = $( dRadio ).prev();
				/*make all radiobuttons in particular group unchecked*/	
				jRadio.removeClass( 'j-radio-checked' );
				/*then make this pressed single button be cheked*/
			   	$( this ).toggleClass( 'j-radio-checked' );
			});
			/*when user clicks fake div and holds it down*/
			jRadio.mousedown( function() {
				$( this ).toggleClass( 'j-radio-active' ).one( 'mouseleave', function() {
					$( this ).removeClass( 'j-radio-active' );
				});
			}).mouseup( function() {
				$( this ).removeClass( 'j-radio-active' );
			});	
		}/*END RADIO BUTTONS*/



		/*** CHECKBOXES ***/
		var dCheck = $('input[type=checkbox]');
		/*if there is at least one checkbox on page*/
		if ( dCheck.length > 0 ) {
			fakeDiv = $('<div class="j-checkbox">');
			dCheck.before(fakeDiv).hide(); /*HIDE HERE!*/
			var jCheck = $('div.j-checkbox');

			dCheck.each(function() {
				if ( $(this).is(':checked') ) {
					$(this).prev().toggleClass('j-checkbox-checked');
				}
			});

			dCheck = $('input[type=checkbox][disabled]')
			dCheck.prev().addClass('j-checkbox-disabled').fadeTo(0, .25);

			jCheck.click( function () {
				if ( $( this ).hasClass('j-checkbox-disabled') ) {
			    	return;
			    }
				/*when user click fake div checkbox make 
				the default checkbox be clicked as well*/
			    $( this ).next().trigger('click');
			    $( this ).toggleClass('j-checkbox-checked');
			});

			jCheck.mousedown(function() {
				if ( $(this).hasClass('j-checkbox-disabled') ) {
			    	return;
			    }
				$(this).toggleClass('j-checkbox-active').one('mouseleave', function() {
					$(this).removeClass('j-checkbox-active');
				});
			}).mouseup(function() {
				$(this).removeClass('j-checkbox-active');
			});
		}/*END CHECKBOXES*/

		/*** FILE INPUT ***/
		var dFile = $( 'input[type=file]' );
		/*if there is at least one file input on page*/
		if ( dFile.length > 0 ) {
			//fakeDiv = $( '<div class="j-file"><div class="choose-file">Choose file...</div><div class="selected-file">File is not selected.</div></div>' );
			fakeDiv = $( '<div class="j-file"><div class="choose-file">' + progression_localize.chooseFile + '</div><div class="selected-file">' + progression_localize.fileIsNot + '</div></div>' );
			dFile.before( fakeDiv ).hide(); /*HIDE HERE!*/
			var jFile = $( 'div.j-file' );

			function cutChosenFilePath( chosenFileName ) {
				var index = chosenFileName.lastIndexOf( '\\' );
				if ( index != -1 ) {
					/*cut off path to the chose file. leave filename only*/
					chosenFileName = chosenFileName.substr( index + 1, chosenFileName.length );
				} else {
					/*try to search backslash, maybe windows*/  
					index = chosenFileName.lastIndexOf( '/' );			
					if ( index != -1 ) {
						chosenFileName = chosenFileName.substr( index + 1, chosenFileName.length );
					}
				}
				return chosenFileName;
			}

			dFile.each( function() {
				if ( $( this ).prop( 'value' ) ) {
					var chosenFileName = $( this ).prop( 'value' );
					chosenFileName = cutChosenFilePath( chosenFileName );
					$( this ).prev().find( '.selected-file' ).text( chosenFileName );
				}
			});

			dFile.change( function() {
				var chosenFileName = $( this ).prop( 'value' );
				chosenFileName = cutChosenFilePath( chosenFileName );
				$( this ).prev().find( '.selected-file' ).text( chosenFileName) ;
			});

			jFile.click( function() {
				$( this ).next().trigger( 'click' );
			});
		}/*END FILE INPUT*/

		/*** SELECT ***/
		var dSelect = $( 'select' );
		/*if there is at least one select on page*/
		if ( dSelect.length > 0 ) {
			/**BUILD FAKE DIVS**/
			var dOptgroup;
			var dOption;

			function selectedOptionToSpan( dOption ) {
				if ( dOption.is( ':selected' ) ) {
					dOption.parentsUntil( ':has(select)' ).prev().find( '.selected-option' ).text( dOption.text() );
					return;
				}		
			} 

			dSelect.each( function() {
				fakeDiv = $( '<div class="j-select"><span class="selected-option"></span><div class="optwrapper"></div></div>' );
				$( this ).before( fakeDiv ).hide(); /*HIDE HERE*/
				var i; /*count options*/
				dOptgroup = $( this ).find( 'optgroup' );
				if ( dOptgroup.length > 0 ) {
					var optGroupLabel;
					var thisOptGroup;
					var j = 0; /*count optgroups*/
						i = 0; /*count options*/
				 	dOptgroup.each( function() {

				 		fakeDiv.find( '.optwrapper' ).append( '<dl class="j-dropdown"><dt class="j-optgroup">' + $(this).attr( "label" ) + '</dt></dl>' );
						dOption = $(this).find( 'option' );
						if ( dOption.length > 0 ) {
							
							dOption.each( function() {
								optGroupLabel = $( this ).parent( '[label]' ).attr( 'label' );
								thisOptGroup = fakeDiv.find( '.j-dropdown:contains(' + optGroupLabel + ')' );
								thisOptGroup.append( '<dd class="j-option index-' + i + ' value-' + $( this ).val() + ' has-optgroup optgroup-' + j + '" title="' + $( this ).text() + '">' + $( this ).text() + '</dd>');
								selectedOptionToSpan( $(this) );
								i++;
							}); /*dOption.each function()*/
						} /*END if*/

						j++;

				 	}); /*END dOptgroup.each function()*/
				} else {
					fakeDiv.find( '.optwrapper' ).append( '<dl class="j-dropdown"></dl>' );
					dOption = $( this ).find( 'option' );
					if ( dOption.length > 0 ) {
						i = 0;
						dOption.each( function() {
							fakeDiv.find( '.j-dropdown' ).append( '<dd class="j-option index-' + i +  ' value-' + $( this ).val() + '" title="' + $( this ).text() + '">' + $( this ).text() + '</dd>' );
							selectedOptionToSpan( $( this ) );
							i++;
						});
					}
				}/*END else*/
			}); /*END dSelect.each function()*/
			
			dSelect.change( function() {
				dOption = $( this ).find( 'option:selected' );
				selectedOptionToSpan( dOption );
			});

			/**SHOWING AND HIDING DROPDOWN LIST**/
			var jSelect = $( 'div.j-select' );
			jSelect.find( '.j-dropdown' ).hide();

			var numClicks;
			var dropDown;
			var jOption;

			jSelect.mousedown( function( event ) {
				if ( !event ) {
					event = window.event;
				}
				if ( ( event.target || event.srcElement ).className != 'j-optgroup'  && ( event.target || event.srcElement ).className != 'optwrapper' ) {
					$( 'html' ).unbind( 'click' );
				}

				numClicks = 0;
				dropDown = $( this ).find( '.j-dropdown' );

				if ( dropDown.is( ':hidden' ) ) {
					$( 'dl.j-dropdown' ).hide( 200 );
					dropDown.show( 200 );
					$( 'html' ).click( function( event ) {
						numClicks++;
						if ( numClicks == 2 ) {
							$( 'dl.j-dropdown' ).hide( 200 );
							$(this).unbind( 'click' );
						}					
					}); /*END html click event */
				} else if ( !dropDown.is( ':hidden' ) ) {
					/*if clicked item in the dropdown list is an option (not an optgroup, or  span, or select */
					if ( /^.*j-option.*$/.test( ( event.target || event.srcElement ).className ) ) {
						jOption = ( event.target || event.srcElement );
						jOption = jOption.className.match(/index-\d+/, 'g');
						jOption = jOption[0].split('-');
						jOption = jOption[1]; /*this contains fake option index*/

						if ( $( this ).next().attr('name') != 'archive-dropdown' ) {
							$(this).next().prop( 'selectedIndex', jOption ).change();
						} else if ( jOption != 0 ) {
							$(this).next().prop( 'selectedIndex', jOption ).change();
						}
					}
					if ( ( event.target || event.srcElement ).className != 'j-optgroup' && ( event.target || event.srcElement ).className != 'optwrapper' ) {
						$( 'dl.j-dropdown' ).hide( 300 );
						$( 'html' ).unbind( 'click' );
					} else {
						numClicks = 0;
					}
				} /*end if else */
			}); /*END jSelect.mousedown function(event)*/
		} /*END SELECT */
		/*** RESET BUTTON ***/
		/*when user clicks reset button*/
		$( 'button:reset, input:reset' ).click( function() {
			/*all radio backgrounds unchecked*/
			var thisForm = $( this ).parentsUntil( 'form' ).parent();
			thisForm.find( '.j-radio' ).removeClass( 'j-radio-checked' );
			thisForm.find( '.j-checkbox' ).removeClass( 'j-checkbox-checked' );
			thisForm.find('.selected-file').text( 'File is not selected.' );
			thisForm.find( 'select' ).prop( 'selectedIndex', 0 ).change();
		});
		/*** LABELS ***/
		$( 'label' ).mousedown( function( event ) {
			var labelFor = $( this ).attr( 'for' );
			if ( labelFor != undefined ) {
				var fakeDiv = $( '[id=' + labelFor + ']' ).prev();
				if ( fakeDiv.hasClass( 'j-radio' ) || fakeDiv.hasClass( 'j-checkbox' ) ) {
					fakeDiv.trigger( 'click' );
					fakeDiv.next().trigger( 'click' ); /*checkboxes issue*/			
				}
			} else {
				var inputType = $( this ).find( 'input:first' ).attr( 'type' );
				if ( inputType == 'radio' || inputType == 'checkbox' ) {
					var fakeDiv = $( this ).find( '.j-' + inputType );
					fakeDiv.trigger( 'click' );
				}
			}
		});
		if ( $.browser.msie ) {
  			$( '.commentlist .comment .comment-body p:last-of-type' ).css( 'margin-bottom', '0' );
		}



/**********************************************
 * Script for slider.
 **********************************************/

		if ( $( '#slider' ).length > 0 ) {
			var i = 0;
			var currentSlide;
			var currentSwitch;
			var intervalID;
			//i = 0;
			currentSlide = $( '#slide-' + i );
			currentSlide.toggleClass( 'slide-current' );
			currentSwitch = 'switch-' + currentSlide.attr( 'id' );
			currentSwitch = $( '#' + currentSwitch );
			currentSwitch.toggleClass( 'switch-slide-current' );
			/*if theris more than one slide, set timer*/
			if ( $( '#slider .slide' ).length > 1 ) {	
				intervalID = setInterval( rotate, 6000 );
			}
			/*when user clicks on a switch slide circle show next slide*/
			$( '#slider .switch-slides-container div' ).click( function() {
				nextSlide( $( this ) );
			}); 
		}/*end if slider*/

		/*** rotate slides*/
		function rotate() {
			if ( currentSwitch.next().length > 0 ) {
				i++;
				nextSlide( $( '#switch-slide-' + i ) );
			} else {
				i = 0;
				nextSlide( $( '#switch-slide-' + i ) );
			}
		}

		function nextSlide( clickedCircle ) {
			/*if this is not a current switch*/	
			if ( clickedCircle.hasClass( 'switch-slide-current' ) == false ) {
				currentSwitch.toggleClass( 'switch-slide-current' );
				clickedCircle.toggleClass( 'switch-slide-current' );
				currentSwitch = clickedCircle;
				currentSlide.toggleClass( 'slide-current' ).fadeOut( 'slow' );
				currentSlide = clickedCircle.attr( 'id' ).substring( 7 );
				currentSlide = $( '#' + currentSlide );
				currentSlide.toggleClass( 'slide-current' ).fadeIn( 'slow' );
				i = clickedCircle.attr( 'id' ).substring( clickedCircle.attr( 'id' ).length - 1 );
			}
			/*reset timer if it was set*/
			if ( intervalID ) {			
				clearInterval( intervalID );
				intervalID = setInterval( rotate, 6000 );
			}
		}
		
	});/*end document ready*/
})( jQuery );