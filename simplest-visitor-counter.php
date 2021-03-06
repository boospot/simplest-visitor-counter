<?php
/*
Plugin Name: Simplest Visitor Counter
Plugin URI: https://nzahid.com
Description: This is the most simplest visitor counter in WordPress History since 1801
Author: Numan
Version: 0.0.1
Author URI: https://nzahid.com
*/


// Shortcode_display :  simplest_visitor_counter    // like: show_post_list

function simplest_visitor_counter_cb( $atts = [], $content = null, $tag = '' ) {
	// normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );


	$atts = shortcode_atts( array(
		// Update the default Values
		'start' => 0,
		'reset' => 'no'
	), $atts );

	// is reset required?
	if ( 'yes' === sanitize_key( $atts['reset'] ) ) {
		delete_option( 'simplest_visitor_count' );
	}


	$visitor_count = get_option( 'simplest_visitor_count' );

	// Set the Starter value if not set
	if ( ! $visitor_count ) {
		$start = isset( $atts['start'] ) ? absint( $atts['start'] ) : 1;
		update_option( 'simplest_visitor_count', $start );
	}

	// start output
	$output = '';
	// Update output
	$output .= '<div class="simplest-visitor-counter">';
	$output .= $visitor_count;
	$output .= '</div>';

	// return output
	return $output;
}

add_shortcode( 'simplest_visitor_counter', 'simplest_visitor_counter_cb' );


add_action( 'wp_head', function () {

	$visitor_count = get_option( 'simplest_visitor_count' );
	// Set the Starter value if not set
	if ( ! $visitor_count ) {
		update_option( 'simplest_visitor_count', 1 );
	}

	if ( ! isset( $_SESSION['views'] ) ) {
		$_SESSION['views'] = 1;
		$visitor_count ++;
		update_option( 'simplest_visitor_count', $visitor_count );
	}

} );
