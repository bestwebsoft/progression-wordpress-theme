<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main-section-wrap">
 *
 * @subpackage Progression
 * @since Progression 1.3
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri() . '/js/ie.js'; ?>"></script>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/ie/ie.css'; ?>">
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page-wrap">	
		<header id="page-header">
			<!-- Main Navigation -->
			<?php if ( has_nav_menu( 'main-nav' ) ) :
				wp_nav_menu( array( 
					'theme_location' => 'main-nav',
					'container' => 'nav',
					'container_id' =>  'main-nav',
					'menu_class' => 'menu clearfix'
					)
				);
			else : ?>
				<nav id="main-nav">
					<ul class="clearfix">
						<?php wp_list_pages( 'title_li=' ); ?>
					</ul>
				</nav>
			<?php endif;
			/* END of Main Navigation */
			
			/* Site logo and description */
			if ( get_header_image() ) : ?>
				<div id="progression-custom-header" style="background: url(<?php header_image(); ?>); background-size: cover;">
			<?php endif; ?>
					<hgroup id="progression-logo" class="clearfix">
						<h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
						<h2><?php bloginfo('description'); ?></h2>
					</hgroup> <!-- END of logo and description -->
			<?php if ( get_header_image() ) : ?>
				</div><!-- END custom header -->
			<?php endif; ?>

			<!-- breadcrumbs goes here -->
			<nav id="breadcrumbs">
				<?php do_action( 'progression_main_breadcrumbs' ); ?>
			</nav>
		</header>