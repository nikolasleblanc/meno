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

genesis_register_sidebar( array(
	'id'				=> 'banner',
	'name'			=> __( 'Banner', 'meno' ),
	'description'	=> __( 'This is the banner.', 'meno' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'newsletter',
	'name'			=> __( 'Newsletter', 'meno' ),
	'description'	=> __( 'This is the newsletter.', 'meno' ),
) );

function meno_banner_genesis() {
	
}
add_action( 'genesis_after_header', 'meno_banner_genesis', 9 );

add_action( 'genesis_before_content_sidebar_wrap', 'meno_do_big_banner' );

add_action( 'genesis_header', 'meno_do_logo', 6 );

function meno_do_logo() {
	echo '<img class="logo" src="' . get_bloginfo('stylesheet_directory') . '/images/squarelogo.png"/>';
}

function meno_do_big_banner() {
	
}
//* Add the band widget after the post content
//add_action( 'genesis_after_header', 'custom_add_band_box', 9 );
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
add_action( 'genesis_entry_content', 'meno_do_post_image', 0 );

function meno_do_post_image() {
	$img = genesis_get_image( 
		array( 
			'format' => 'html', 
			'size' => 'feature', 
			'attr' => array( 'class' => 'aligncenter post-image' ) 
		) 
	);
	printf( '<a title="%s" href="%s">%s</a><div class="clear"></div>', get_permalink(), the_title_attribute('echo=0'), $img );
}

add_image_size('feature', 566, 250, true);
add_image_size('thumb', 256, 70, true);

//* Reposition the secondary navigation menu
//remove_action( 'genesis_after_header', 'genesis_do_subnav' );
//add_action( 'genesis_after_header', 'genesis_do_subnav', 10 );

/** Show category descriptions */
function minimum_cat_description () {
    if (is_category() ) {  
    	echo '<h4 class="widgettitle">Category archive</h4>';
    	echo '<h1 class="entry-title" itemprop="headline">' . single_cat_title( null, false ) . '</h1>';      
        echo category_description( $category-id );
        echo '<hr style="margin-bottom: 35px;"/>';
}}
add_action( 'genesis_before_loop', 'minimum_cat_description'); 

add_action( 'genesis_before_loop', 'meno_do_recent_posts_title' );

function meno_do_recent_posts_title() {
	if( is_home() ) {
		echo '<h4 class="widgettitle">Recent posts</h4>';
	}
}

genesis_register_sidebar( array(
'id' => 'home-before',
'name' => __( 'Home Slider Widget', 'wpsites' ),
'description' =>  __( 'Content On Home Page Before Posts.', 'wpsites' ),
) );
/**
* @author Brad Dalton - WP Sites
* @learn more http://wp.me/p1lTu0-9Na
*/
add_action( 'genesis_before_content', 'wpsites_home_before_widget', 5 );
function wpsites_home_before_widget() {
	if ( is_home() ) {
		echo '<div class="home-before" style="margin-bottom: 25px; border-bottom: 1px dotted #666;">';
		dynamic_sidebar( 'home-before' );
		echo '</div><!-- end .home-before -->';
 	}
}

/**
 * Genesis Next/Previous Post Navigation (after post, before comments)
 * 
 */
add_action( 'genesis_entry_footer', 'ac_next_prev_post_nav' );
 
function ac_next_prev_post_nav() {
	
	if ( is_single() ) {
 
		echo '<div class="loop-nav">';
		previous_post_link( '<div class="previous">Previous: %link</div>', '%title' );
		next_post_link( '<div class="next">Next: %link</div>', '%title' );
		echo '</div><!-- .loop-nav -->';
 
	}
 
}