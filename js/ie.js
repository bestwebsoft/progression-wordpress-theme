/**
 *  Adds new HTML5 elements so the Intenet Explorer can use them.
 */

var e = ( "article,aside,figcaption,figure,footer,header,hgroup,nav,section,time" ).split( ',' );
for ( var i = 0; i < e.length; i++ ) {
  	document.createElement( e[i] );
}