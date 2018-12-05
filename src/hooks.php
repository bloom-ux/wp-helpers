<?php
/**
 * Default hooks.
 * Makes some opinionated decisions about WordPress admin or other stuff.
 * Using a namespace to keep things tidy.
 *
 * @package Bloom_UX_WP_Helpers;
 */

namespace Bloom_UX\WP_Helpers\Hooks;

// # ADMIN TWEAKS

/**
 * Move Yoast's WordPress SEO metabox lower than other metaboxes
 *
 * @param string $priority Metabox priority.
 * @return string "low" for moving the metaboxes to the bottom
 */
function move_wpseo_to_bottom( $priority = 'low' ) {
	return 'low';
}

add_filter( 'wpseo_metabox_prio', 'Bloom_UX\WP_Helpers\Hooks\move_wpseo_to_bottom' );

// # THEME TWEAKS

/**
 * Every theme should support this stuff, really.
 *
 * @return void
 */
function after_setup_theme() {
	add_post_type_support( 'page', 'excerpt' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'Bloom_UX\WP_Helpers\Hooks\after_setup_theme' );
