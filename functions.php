<?php
/**
 * Progression functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @subpackage Progression
 * @since Progression 1.3
 */
/** Sets up the content width value based on the theme's design and stylesheet.*/
if ( ! isset( $content_width ) )
	$content_width = 580;

/** Sets up theme defaults and registers the various WordPress features that Progression supports.*/
function progression_setup() {
	// Declare support for HTML5 
	add_theme_support( 'html5', array('search-form' ) );
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	// Declare support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );
	// Register a new image size */
	add_image_size( 'featured-image', 503, 9999 );
	add_image_size( 'slide', 940, 307, true );
	// Enable Custom_Headers support for the theme.
	add_theme_support( 'custom-header', array(
		'width' => 940,
		'height' => 198,
		'flex-height' => true,
		'flex-width' => true,
		'header-text' => true,
		'uploads'  => true,
		'default-text-color' => '303030',
		'wp-head-callback' => 'progression_header_style'
	));
	// Enable Custom_Backgrounds support for the theme.
	add_theme_support( 'custom-background' );
	// Makes Progression available for translation.
	load_theme_textdomain( 'progression', get_template_directory() . '/languages' );
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	// Register menus for Progression theme
	register_nav_menus( array( 'main-nav' => 'Main Navigation' ) );
}

/** Declare sidebar widget zone */
function progression_widgets_init() {
	register_sidebar( array(
			'name' 			=> 'Sidebar Widgets',
			'id'  			=> 'sidebar-widgets',
			'description'   => 'These are widgets for the sidebar.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		)
	);
}

/** Styles the header image displayed on the Appearance > Header admin panel. */
function progression_admin_header_style() { ?>
	<style type="text/css" id="progression-admin-header-css">
		.appearance_page_custom-header #headimg {
			border: none;
			font-family: "Open Sans", Helvetica, Arial, sans-serif;
			height: 98px !important;
			overflow: hidden;
			width: 940px;
		}
		#headimg h1,
		#desc {
			color: #<?php echo get_header_textcolor(); ?>;
			margin: 0;
			min-height: 32px;
			line-height: 32px;
			padding: 31px 0 35px 0;
			position: relative;
			top: 1px;
		}
		#headimg h1 {
			float: left;
			font-weight: bold;
			font-size: 18px;
			letter-spacing: .02em;
			max-width: 580px;
		}
		#headimg h1 a {
			text-decoration: none;
		}
		#desc {
			color: rgb(127, 127, 127);
			float: right;
			font-style: italic;
			font-size: 13px;
			letter-spacing: .02em;
			max-width: 270px;
			-moz-opacity: .6; /*mozilla 1.6 and lower*/
			-khtml-opacity: .6; /*safari 1.1*/
			opacity: .6;
			text-align: right;
		}
		#headimg img {
			left: 0;
			overflow: hidden;
			position: absolute;
			top: 0;
			z-index: -1;
		}
	</style>
<?php } // end progression_admin_header_style()

/** SLider functions */
/** Adds metabox to the main column on the Post and Page edit screens. */
function progression_add_custom_box() {
	$screens = array( 'post', 'page' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'slider-section',
			'Slider Settings',
			'progression_slider_custom_box',
			$screen
		);
	}
}

/** When the post is saved, saves our custom data. */
function progression_slider_save_postdata( $post_id ) {
	//We need to verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times.
	//
	// Check if our nonce is set.
	if ( ! isset( $_POST['progression_slider_custom_box_nonce'] ) )
		return $post_id;
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;
	// OK, its safe for us to save the data now.
	// Update the meta field in the database.
	update_post_meta( $post_id, 'add-to-slider', $_POST['add-to-slider'] );
	// Update slide-description field in the database.
	update_post_meta( $post_id, 'slide-description', sanitize_text_field( $_POST['slide-description'] ) );
}

/** Creates a nicely formatted and more specific title element text for output
	in head of document, based on current view. */
function progression_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() )
		return $title;
	// Add the site name.
	$title .= get_bloginfo( 'name' );
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = $title . ' ' . $sep . ' ' . $site_description;
	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = $title . ' ' . $sep . ' ' . sprintf( __( 'Page %s', 'progression' ), max( $paged, $page ) );
	return $title;
}

/** Register scripts and styles for Progression theme */
function progression_scripts() {
	// main css styles
	wp_enqueue_style( 'progression-style', get_stylesheet_uri() );
	// script for main navigation, custom forms and slider
	wp_enqueue_script( 'progression-script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ) );
	// comment reply script
	if ( is_singular() ) {
		wp_enqueue_script( "comment-reply" );
	}
	// script for BWS plugins Portfolio and Gallery
	if ( get_post_type() == 'portfolio'
	|| get_post_type() == 'gallery'
	|| in_array( 'page-template-portfolio-php', get_body_class() )
	|| in_array( 'page-template-gallery-template-php', get_body_class() ) ) {
		wp_enqueue_script( 'progression-bws-gallery-portfolio', get_template_directory_uri() . '/js/bws-gallery-portfolio.js', array( 'jquery' ) );
	}
	// script for BWS plugin Gallery in the sidebar
	if ( is_active_widget( false, false, 'text' ) ) {
		global $wpdb;
		$progression_rows = $wpdb->get_results( "SELECT option_value FROM wp_options WHERE option_name = 'widget_text'" );  
		if ( strpos( $progression_rows[0]->option_value, 'print_gllr' ) ) {
			wp_enqueue_script( 'progression-bws-gallery-aside', get_template_directory_uri() . '/js/bws-gallery-aside.js', array( 'jquery' ) );
		}
	}
	// script localization
	wp_localize_script( 'progression-script', 'progression_localize', array(
		'chooseFile' => __( 'Choose file...', 'progression' ),
		'fileIsNot' => __( 'File is not selected.', 'progression' )
	));
}

/** Breadcrumbs */
function progression_main_breadcrumbs() {
	if ( is_page() || is_single() ) :
		do_action( 'progression_get_breadcrumbs' );				
	/* If this is a search results */
	elseif ( is_search() ) : ?>
		<ul class="clearfix">
			<li><a href="<?php home_url() ?>"><?php _e( 'Home', 'progression' ) ?></a></li>
			<li>&#8196;-&#8196;<span><?php _e( 'Search results for ', 'progression' ) ?>"<?php echo $_GET[ 's' ]; ?>"</span></li>
		</ul>
	<!-- If this is a category archive -->
	<?php elseif( is_category() ) :
		$category = get_queried_object();
		do_action( 'progression_get_category_breadcrumbs', $category );
	/* If this is a tag archive */
	elseif ( is_tag() ) : ?>
		<ul class="clearfix">
			<li><a href="<?php home_url() ?>"><?php _e( 'Home', 'progression' ); ?></a></li>
			<li>&#8196;-&#8196;<span><?php _e( 'Posts Tagged ', 'progression' ); ?>"<?php single_tag_title(); ?>"</span></li>
		</ul>
	<!-- If this is a daily archive -->
	<?php elseif ( is_day() ) : ?>
		<ul class="clearfix">
			<li><a href="<?php home_url() ?>"><?php _e( 'Home', 'progression' ) ?></a></li>
			<li>&#8196;-&#8196;<span><?php _e( 'Archive for', 'progression' ) ?> <?php the_time( 'F jS, Y' ); ?></span></li>
		</ul>
	<!-- If this is a monthly archive -->
	<?php elseif ( is_month() ) : ?>
		<ul class="clearfix">
			<li><a href="<?php home_url() ?>"><?php _e( 'Home', 'progression' ) ?></a></li>
			<li>&#8196;-&#8196;<span><?php _e( 'Archive for', 'progression' ) ?> <?php the_time( 'F, Y' ); ?></span></li>
		</ul>
	<!-- If this is a yearly archive -->
	<?php elseif ( is_year() ) : ?>
		<ul class="clearfix">
			<li><a href="<?php home_url() ?>"><?php _e( 'Home', 'progression' ) ?></a></li>
			<li>&#8196;-&#8196;<span><?php _e( 'Archive for', 'progression' ) ?> <?php the_time( 'Y' ); ?></span></li>
		</ul>
	<!-- If this is an author archive -->
	<?php elseif ( is_author() ) : ?>
		<ul class="clearfix">
			<li><a href="<?php home_url() ?>"><?php _e( 'Home', 'progression' ) ?></a></li>
			<li>&#8196;-&#8196;<span><?php _e( 'Author Archive', 'progression' ) ?></span></li>
		</ul>
	<!-- If this is a paged archive -->
	<?php elseif ( isset($_GET[ 'paged' ] ) && !empty( $_GET[ 'paged' ] ) ) : ?>
		<ul class="clearfix">
			<li><a href="<?php home_url() ?>"><?php _e( 'Home', 'progression' ) ?></a></li>
			<li>&#8196;-&#8196;<span><?php _e( 'Blog Archives', 'progression' ) ?></span></li>
		</ul>
	<?php endif;
}

/* Adds breadcrumbs to the page. */
function progression_get_breadcrumbs() {
	echo '<ul class="clearfix">';
	echo '<li><a href="' . home_url() . '">' . __( 'Home', 'progression' ) . '</a></li>';
	$breadcrumbs = array();
	if ( have_posts() ) {
		global $post;
		while ( have_posts() ) {
			the_post();
			$p_ID = $post->ID;
			$parent = progression_get_parent( $p_ID );
			while ( $parent != false ) {
				$p_ID = $parent->ID;
				array_push( $breadcrumbs,  '<li>&#8196;-&#8196;<a href="' . get_permalink( $p_ID ) . '" title="' . esc_attr( get_the_title( $p_ID ) ) . '">' . get_the_title( $p_ID ) . '</a></li>' );
				$parent = progression_get_parent( $p_ID );                                            
			}
			for ( $i = count( $breadcrumbs ) - 1; $i >= 0; $i-- ) {
				echo $breadcrumbs[$i];
			}
			echo '<li>&#8196;-&#8196;<span class="current-page">' . get_the_title( $post->ID ) . '</span></li>';                          
		}
	}
	echo '</ul>';
}

/** Adds breadcrumbs for the queried category on archive.php. */
function progression_get_category_breadcrumbs( $category ) {
	echo '<ul class="clearfix">';
	echo '<li><a href="' . home_url() . '">' . __( 'Home', 'progression' ) . '</a></li>';
	$this_cat = $category->name;
	$cat_bread = array();
	if ( $category->parent ) {
		while ( $category->parent ) {
			$category = get_category( $category->parent );
			array_push( $cat_bread, '<li>&#8196;-&#8196;<a href="' . esc_url( get_category_link( $category->cat_ID ) ) . '" title="' . esc_attr( $category->slug ) . '">' . $category->name . '</a></li>' );       
		}
		for ( $i = count( $cat_bread ) - 1; $i >= 0; $i-- ) {
			echo $cat_bread[$i];
		}      
	}
	echo '<li>&#8196;-&#8196;<span class="current-category">' . $this_cat . '</span></li>';
	echo '</ul>';
} // END breadcrumbs

/** Adds slider to the frontpage */
function progression_get_slider() {
	if ( have_posts() ) {
		$query = new WP_Query( array( 
			'posts_per_page' => -1,
			'post_type' => 'any',
			'meta_key' => 'add-to-slider',
			'meta_value' => 'on',
			'ignore_sticky_posts' => 1
		) );
		// The Loop
		if ( $query->have_posts() ) {
			$switch_slides = ''; ?>
			<div id="slider">
				<?php while ( $query->have_posts() ) {
				$query->next_post();
				$p = $query->post; ?>
				<div id="slide-<?php echo $query->current_post ?>" class="slide">
					<?php echo get_the_post_thumbnail( $p->ID, 'slide' ); ?>
					<div class="slide-description">
						<h1><?php echo $p->post_title ?></h1>
						<p><?php echo get_post_meta( $p->ID, 'slide-description', true ) ?></p>
					</div>
					<div class="learn-more">
						<a href="<?php echo get_permalink( $p->ID ) ?>"><?php _e( "Learn More", "progression" ); ?></a>
					</div>
					<?php $switch_slides .= '<div id="switch-slide-' . $query->current_post . '"></div>'; ?>
				</div>
				<?php } // End while.
				wp_reset_postdata(); // restore the global $post variable ?>
				<div class="switch-slides-container"><?php echo $switch_slides; ?></div>
			</div><?php // close id="slider"
		} // End if.
	}
} // END slider

/** Adds post thumbnail caption */
function progression_post_thumbnail_caption() {
	global $post;
	$thumbnail_id = get_post_thumbnail_id( $post->ID );
	$thumbnail_image = get_posts( array( 'p' => $thumbnail_id, 'post_type' => 'attachment' ) );
	$thumbnail_caption = $thumbnail_image[0]->post_excerpt;
	if ( $thumbnail_image && isset( $thumbnail_image[0] ) && strlen( $thumbnail_caption ) > 0 ) {
		echo '<span>' . $thumbnail_caption . '</span>';
	} 
}

/** Adds pagination to the frontend */
function progression_pagination() {
	/* If pages to show exist, display pagination */
	if ( get_previous_posts_link() || get_next_posts_link() ) : ?>
		<div class="pagination">
			<div class="prev-posts"><?php previous_posts_link( '&laquo; ' . __( 'Previous Page', 'progression' ) ); ?></div>
			<div class="next-posts"><?php next_posts_link( __( 'Next Page', 'progression' ) . ' &raquo;' ); ?></div>
		</div>
	<?php endif;
}

/** Styles the header text displayed on the blog. */
function progression_header_style() {
	if ( ! display_header_text() ) : ?>
		<style type="text/css" id="progression-header-css">
			#progression-logo h1,
			#progression-logo h2 {
				position: absolute;
				clip: rect(1px 1px 1px 1px); /* IE7 */
				clip: rect(1px, 1px, 1px, 1px);
			}
			#progression-custom-header {
				-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php header_image(); ?>',sizingMethod='scale')";
			}
		</style> 
	<?php else : ?>
		<style type="text/css" id="progression-header-css">
			#progression-logo h1 a,
			#progression-logo h2 {
				color: #<?php echo get_header_textcolor(); ?>;
			}
			#progression-logo h2 {
				-moz-opacity: .6; /*mozilla 1.6 and lower*/
				-khtml-opacity: .6; /*safari 1.1*/
				opacity: .6;
			}
			#progression-custom-header {
				-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php header_image(); ?>',sizingMethod='scale')";
			}
		</style> 
	<?php endif; ?>
<?php } // end progression_header_style()

/** Prints the box content. */
function progression_slider_custom_box( $post ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'progression_slider_custom_box', 'progression_slider_custom_box_nonce' );    
	// Use get_post_meta() to retrieve an existing value
	// from the database and use the value for the form.
	$edited_post_ID = $post->ID;
	$value = get_post_meta( $edited_post_ID, 'slide-description', true ); ?>
	<input type="text" id="slide-description" name="slide-description" value="<?php echo esc_attr( $value ) ?>" maxlength="105" size="85" >
	<?php $value = get_post_meta( $edited_post_ID, 'add-to-slider', true ); ?>
	<input type="checkbox" id="add-to-slider" name="add-to-slider"<?php if ( $value == 'on' ) echo 'checked ';?>>
	<label for="add-to-slider">
		<?php echo _e(' Check if you want featured image of this post to be shown in the slider. You can add text description as well.', 'progression' ) ?><br>
	</label>
<?php }

/** Returns parent page. Used in the get_breadcrumbs() function. */
function progression_get_parent( $p_ID ) {
	$parent = false;
	$p = get_post( $p_ID );
	if ( $p->post_parent != false ) {
		$p_ID = $p->post_parent;
		$parent = get_post( $p_ID );            
	} 
	return $parent;
}

/** Actions */
add_action( 'after_setup_theme', 'progression_setup' );
add_action( 'widgets_init', 'progression_widgets_init' );
add_action( 'admin_head', 'progression_admin_header_style' );
add_action( 'add_meta_boxes', 'progression_add_custom_box' );
add_action( 'save_post', 'progression_slider_save_postdata' );
add_action( 'wp_title', 'progression_wp_title', 10, 2 );
add_action( 'wp_enqueue_scripts', 'progression_scripts' );
add_action( 'progression_main_breadcrumbs', 'progression_main_breadcrumbs' );
add_action( 'progression_get_breadcrumbs', 'progression_get_breadcrumbs' );
add_action( 'progression_get_category_breadcrumbs', 'progression_get_category_breadcrumbs' );
add_action( 'progression_get_slider', 'progression_get_slider' );
add_action( 'progression_post_thumbnail_caption', 'progression_post_thumbnail_caption' );
add_action( 'progression_pagination', 'progression_pagination' );
?>