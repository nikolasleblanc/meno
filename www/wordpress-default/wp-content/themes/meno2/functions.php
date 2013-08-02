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
	wp_enqueue_style( 'google-font', 'http://fonts.googleapis.com/css?family=Lato:300,400,700|Merriweather:300,400|PT+Sans:100,200,300,400', array(), CHILD_THEME_VERSION );
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
add_action( 'genesis_entry_header', 'genesis_do_breadcrumbs', 0 );

//* Register newsletter widget area
genesis_register_sidebar( array(
	'id'		=> 'newsletter',
	'name'		=> __( 'Newsletter', 'meno' ),
	'description'	=> __( 'This is the newsletter section.', 'meno' ),
) );
 
//* Add the newsletter widget after the post content
add_action( 'genesis_after_comment_form', 'custom_add_newsletter_box' );
function custom_add_newsletter_box() {
	if ( is_singular( 'post' ) )
	genesis_widget_area( 'newsletter', array(
		'before' => '<div id="newsletter">',
		'after' => '</div>'
	) );
}

//* Add the band widget after the post content
add_action( 'genesis_after_header', 'custom_add_band_box', 10 );
function custom_add_band_box() {
	?>
		<!--
		<div style="background-color: #F0DBC8">
			<div class="wrap">
				<div class="one-half first">
					a
				</div>
				<div class="one-half">
					b <?php custom_add_newsletter_box(); ?>
				</div>
			</div>
		</div>
		-->
	<?php
}

//*Filter the breadcrumb trail to remove "You are here"
add_filter('genesis_breadcrumb_args', 'custom_breadcrumb_args');
function custom_breadcrumb_args($args) {
    $args['labels']['prefix'] = ''; //marks the spot
    $args['sep'] = ' / ';
    return $args;
}

