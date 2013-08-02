<?php
/**
 * Functions
 *
 * @package 	Menopauseandu
 * @author 		Nikolas LeBlanc <nikolas.leblanc@gmail.com>
 * @copyright 	Copyright (c) 2013, Nikolas LeBlanc
 * @license 	http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Meno.Genesis.2' );
define( 'CHILD_THEME_URL', 'http://menopaueandu.ca' );
define( 'CHILD_THEME_VERSION', '2.0.0-beta2' );

//* Load Lato and Merriweather Google fonts
add_action( 'wp_enqueue_scripts', 'custom_load_google_fonts' );
function custom_load_google_fonts() {
	wp_enqueue_style( 'google-font', 'http://fonts.googleapis.com/css?family=Playball:400|Croissant+One:400|Pathway+Gothic+One:400|Lato:300,400,700|Merriweather:300,400|PT+Sans:100,200,300,400|Quattrocento:400', array(), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'genesis-html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Reposition the breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
//add_action( 'genesis_entry_header', 'genesis_do_breadcrumbs', 0 );

//* Register newsletter widget area
genesis_register_sidebar( array(
	'id'		=> 'newsletter',
	'name'		=> __( 'Newsletter', 'meno' ),
	'description'	=> __( 'This is the newsletter section.', 'meno' ),
) );
 
//* Add the newsletter widget after the post content
function custom_add_newsletter_box() {
	if ( is_singular( 'post' ) )
	genesis_widget_area( 'newsletter', array(
		'before' => '<div id="newsletter">',
		'after' => '</div>'
	) );
}

//* Register newsletter widget area
genesis_register_sidebar( array(
	'id'		=> 'featureBand',
	'name'		=> __( 'Feature Band', 'meno' ),
	'description'	=> __( 'This is the feature band.', 'meno' ),
) );

//* Add the newsletter widget after the post content
function custom_add_featureband_box() {
	if ( is_singular( 'post' ) )
	genesis_widget_area( 'featureBand', array(
		'before' => '<div id="wrap">',
		'after' => '</div>'
	) );
}

//* Add the band widget after the post content
add_action( 'genesis_after_header', 'custom_add_band_box', 9 );
function custom_add_band_box() {
	?>
		<div style="background-color: #e5f3fa; height: 230px; padding: 25px;">
			<div class="wrap">
				<div class="one-half first">
					&nbsp;
				</div>
				<div class="one-fourth">
					&nbsp;
				</div>
				<div class="one-fourth">
					&nbsp;<!--<?php custom_add_newsletter_box(); ?>-->
				</div>
			</div>
		</div>
	<?php
}

//*Filter the breadcrumb trail to remove "You are here"
add_filter('genesis_breadcrumb_args', 'custom_breadcrumb_args');
function custom_breadcrumb_args($args) {
    $args['labels']['prefix'] = ''; //marks the spot
    $args['sep'] = ' / ';
    $args['display'] = false;
    return $args;
}



//*Relocate featured image above post
remove_action( 'genesis_entry_content', 'genesis_do_post_image' );
add_action( 'genesis_entry_header', 'meno_do_post_image', 1 );

function meno_do_post_image() {
	$img = genesis_get_image( 
		array( 
			'format' => 'html', 
			'size' => genesis_get_option('image_size'), 
			'attr' => array( 'class' => 'aligncenter post-image' ) 
		) 
	);
	printf( '<a title="%s" href="%s">%s</a><div class="clear"></div>', get_permalink(), the_title_attribute('echo=0'), $img );
}

add_image_size('feature', 566, 125, true);
add_image_size('thumb', 256, 70, true);

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_after_header', 'genesis_do_subnav', 10 );


