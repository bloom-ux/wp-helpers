<?php
/**
 * Default hooks.
 * Makes some opinionated decisions about WordPress admin or other stuff.
 * Using a namespace to keep things tidy.
 *
 * @package Bloom_UX_WP_Helpers;
 */

namespace Bloom_UX\WP_Helpers\Hooks;

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
