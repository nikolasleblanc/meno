<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Markup
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

/**
 * Output markup conditionally.
 *
 * Supported keys for `$args` are:
 *
 *  - `html5` (`sprintf()` pattern markup),
 *  - `xhtml` (XHTML markup),
 *  - `context` (name of context),
 *  - `echo` (default is true).
 *
 * If the child theme supports HTML5, then this function will output the `html5` value, with a call to `genesis_attr()`
 * with the same context added in. Otherwise, it will output the `xhtml` value.
 *
 * Applies a `genesis_markup_{context}` filter early to allow shortcutting the function.
 *
 * Applies a `genesis_markup_{context}_output` filter at the end.
 *
 * @since 1.9.0
 *
 * @uses genesis_html5() Check for HTML5 support.
 * @uses genesis_attr()  Contextual attributes.
 *
 * @param array $args Array of arguments.
 *
 * @return string Markup.
 */
function genesis_markup( $args = array() ) {

	$defaults = array(
		'html5'   => '',
		'xhtml'   => '',
		'context' => '',
		'echo'    => true,
	);

	$args = wp_parse_args( $args, $defaults );

	//* Short circuit filter
	$pre = apply_filters( 'genesis_markup_' . $args['context'], false, $args );
	if ( false !== $pre )
		return $pre;

	if ( ! $args['html5'] || ! $args['xhtml'] )
		return '';

	//* If HTML5, return HTML5 tag. Maybe add attributes. Else XHTML.
	if ( genesis_html5() ) {
		$tag = $args['context'] ? sprintf( $args['html5'], genesis_attr( $args['context'] ) ) : $args['html5'];
	}
	else {
		$tag = $args['xhtml'];
	}

	//* Contextual filter
	$tag = $args['context'] ? apply_filters( 'genesis_markup_' . $args['context'] . '_output', $tag, $args ) : $tag;

	if ( $args['echo'] )
		echo $tag;
	else
		return $tag;

}

/**
 * Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * The contextual filter is of the form `genesis_attr_{context}`.
 *
 * @since 2.0.0
 *
 * @param  string $context    The context, to build filter name.
 * @param  array  $attributes Optional. Extra attributes to merge with defaults.
 *
 * @return array Merged and filtered attributes.
 */
function genesis_parse_attr( $context, $attributes = array() ) {

    $defaults = array(
        'class' => sanitize_html_class( $context ),
    );

    $attributes = wp_parse_args( $attributes, $defaults );

    //* Contextual filter
    return apply_filters( 'genesis_attr_' . $context, $attributes, $context );

}

/**
 * Build list of attributes into a string and apply contextual filter on string.
 *
 * The contextual filter is of the form `genesis_attr_{context}_output`.
 *
 * @since 2.0.0
 *
 * @uses genesis_parse_attr() Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * @param  string $context    The context, to build filter name.
 * @param  array  $attributes Optional. Extra attributes to merge with defaults.
 *
 * @return string String of HTML attributes and values.
 */
function genesis_attr( $context, $attributes = array() ) {

    $attributes = genesis_parse_attr( $context, $attributes );

    $output = '';

    //* Cycle through attributes, build tag attribute string
    foreach ( $attributes as $key => $value ) {
        if ( ! $value )
            continue;
        $output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
    }

    $output = apply_filters( 'genesis_attr_' . $context . '_output', $output, $attributes, $context );

    return trim( $output );

}

add_filter( 'genesis_attr_body', 'genesis_attributes_body' );
/**
 * Add attributes for body element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_body( $attributes ) {

	$attributes['class']     = join( ' ', get_body_class() );
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WebPage';

	return $attributes;

}

add_filter( 'genesis_attr_site-header', 'genesis_attributes_header' );
/**
 * Add attributes for site header element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_header( $attributes ) {

	$attributes['role']      = 'banner';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WPHeader';

	return $attributes;

}

add_filter( 'genesis_attr_site-title', 'genesis_attributes_site_title' );
/**
 * Add attributes for site title element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_site_title( $attributes ) {

	$attributes['itemprop'] = 'headline';

	return $attributes;

}

add_filter( 'genesis_attr_site-description', 'genesis_attributes_site_description' );
/**
 * Add attributes for site description element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_site_description( $attributes ) {

	$attributes['itemprop'] = 'description';

	return $attributes;

}

add_filter( 'genesis_attr_header-widget-area', 'genesis_attributes_header_widget_area' );
/**
 * Add attributes for header widget area element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_header_widget_area( $attributes ) {

	$attributes['class'] = 'widget-area header-widget-area';

	return $attributes;

}

add_filter( 'genesis_attr_nav-primary', 'genesis_attributes_nav_primary' );
/**
 * Add attributes for primary navigation element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_nav_primary( $attributes ) {

	$attributes['role']      = 'navigation';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/SiteNavigationElement';

	return $attributes;

}

add_filter( 'genesis_attr_nav-secondary', 'genesis_attributes_nav_secondary' );
/**
 * Add attributes for secondary navigation element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_nav_secondary( $attributes ) {

	$attributes['role']      = 'navigation';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/SiteNavigationElement';

	return $attributes;

}

add_filter( 'genesis_attr_structural-wrap', 'genesis_attributes_structural_wrap' );
/**
 * Add attributes for structural wrap element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_structural_wrap( $attributes ) {

	$attributes['class'] = 'wrap';

	return $attributes;

}

add_filter( 'genesis_attr_content', 'genesis_attributes_content' );
/**
 * Add attributes for main content element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_content( $attributes ) {

	$attributes['role']     = 'main';
	$attributes['itemprop'] = 'mainContentOfPage';

	//* Blog microdata
	if ( is_singular( 'post' ) || is_archive() || is_home() || is_page_template( 'page_blog.php' ) ) {
		$attributes['itemscope'] = 'itemscope';
		$attributes['itemtype']  = 'http://schema.org/Blog';
	}

	//* Search results pages
	if ( is_search() ) {
		$attributes['itemscope'] = 'itemscope';
		$attributes['itemtype'] = 'http://schema.org/SearchResultsPage';
	}

	return $attributes;

}

add_filter( 'genesis_attr_entry', 'genesis_attributes_entry' );
/**
 * Add attributes for entry element.
 *
 * @since 2.0.0
 *
 * @global WP_Post $post Post object.
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry( $attributes ) {

	global $post;

	$attributes['class']     = join( ' ', get_post_class() );
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/CreativeWork';

	//* Blog posts microdata
	if ( 'post' == $post->post_type ) {

		$attributes['itemtype']  = 'http://schema.org/BlogPosting';

		//* If main query,
		if ( is_main_query() )
			$attributes['itemprop']  = 'blogPost';

	}

	return $attributes;

}

add_filter( 'genesis_attr_entry-image', 'genesis_attributes_entry_image' );
/**
 * Add attributes for entry image element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry_image( $attributes ) {

	$attributes['class']    = 'alignleft post-image entry-image';
	$attributes['itemprop'] = 'image';

	return $attributes;

}

add_filter( 'genesis_attr_entry-image-widget', 'genesis_attributes_entry_image_widget' );
/**
 * Add attributes for entry image element shown in a widget.
 *
 * @since 2.0.0
 *
 * @global WP_Post $post Post object.
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry_image_widget( $attributes ) {

	global $post;

	$attributes['class']    = 'entry-image attachment-' . $post->post_type;
	$attributes['itemprop'] = 'image';

	return $attributes;

}

add_filter( 'genesis_attr_entry-image-grid-loop', 'genesis_attributes_entry_image_grid_loop' );
/**
 * Add attributes for entry image element shown in a grid loop.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry_image_grid_loop( $attributes ) {

	$attributes['itemprop'] = 'image';

	return $attributes;

}

add_filter( 'genesis_attr_entry-author', 'genesis_attributes_entry_author' );
/**
 * Add attributes for author element for an entry.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry_author( $attributes ) {

	$attributes['itemprop']  = 'author';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/Person';

	return $attributes;

}

add_filter( 'genesis_attr_entry-author-link', 'genesis_attributes_entry_author_link' );
/**
 * Add attributes for entry author link element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry_author_link( $attributes ) {

	$attributes['itemprop'] = 'url';
	$attributes['rel']      = 'author';

	return $attributes;

}

add_filter( 'genesis_attr_entry-author-name', 'genesis_attributes_entry_author_name' );
/**
 * Add attributes for entry author name element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry_author_name( $attributes ) {

	$attributes['itemprop'] = 'name';

	return $attributes;

}

add_filter( 'genesis_attr_entry-time', 'genesis_attributes_entry_time' );
/**
 * Add attributes for time element for an entry.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry_time( $attributes ) {

	$attributes['itemprop'] = 'datePublished';
	$attributes['datetime'] = get_the_time( 'c' );

	return $attributes;

}

add_filter( 'genesis_attr_entry-title', 'genesis_attributes_entry_title' );
/**
 * Add attributes for entry title element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry_title( $attributes ) {

	$attributes['itemprop'] = 'headline';

	return $attributes;

}

add_filter( 'genesis_attr_entry-content', 'genesis_attributes_entry_content' );
/**
 * Add attributes for entry content element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry_content( $attributes ) {

	$attributes['itemprop'] = 'text';

	return $attributes;

}

add_filter( 'genesis_attr_entry-comments', 'genesis_attributes_entry_comments' );
/**
 * Add attributes for entry comments element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_entry_comments( $attributes ) {

	$attributes['id'] = 'comments';

	return $attributes;

}

add_filter( 'genesis_attr_comment', 'genesis_attributes_comment' );
/**
 * Add attributes for single comment element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_comment( $attributes ) {

	$attributes['class']     = '';
	$attributes['itemprop']  = 'comment';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/UserComments';

	return $attributes;

}

add_filter( 'genesis_attr_comment-author', 'genesis_attributes_comment_author' );
/**
 * Add attributes for comment author element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_comment_author( $attributes ) {

	$attributes['itemprop']  = 'creator';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/Person';

	return $attributes;

}

add_filter( 'genesis_attr_author-box', 'genesis_attributes_author_box' );
/**
 * Add attributes for author box element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_author_box( $attributes ) {

	$attributes['itemprop']  = 'author';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/Person';

	return $attributes;

}

add_filter( 'genesis_attr_sidebar-primary', 'genesis_attributes_sidebar_primary' );
/**
 * Add attributes for primary sidebar element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_sidebar_primary( $attributes ) {

	$attributes['class']     = 'sidebar sidebar-primary widget-area';
	$attributes['role']      = 'complementary';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WPSideBar';

	return $attributes;

}

add_filter( 'genesis_attr_sidebar-secondary', 'genesis_attributes_sidebar_secondary' );
/**
 * Add attributes for secondary sidebar element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_sidebar_secondary( $attributes ) {

	$attributes['class']     = 'sidebar sidebar-secondary widget-area';
	$attributes['role']      = 'complementary';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WPSideBar';

	return $attributes;

}

add_filter( 'genesis_attr_site-footer', 'genesis_attributes_site_footer' );
/**
 * Add attributes for site footer element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function genesis_attributes_site_footer( $attributes ) {

	$attributes['role']      = 'contentinfo';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WPFooter';

	return $attributes;

}
