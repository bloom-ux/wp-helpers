<?php
/**
 * Plugin Name: Bloom UX WP Helpers
 * Plugin URI: https://github.com/bloom-ux/bloom-ux-wp-helpers/
 * Description: A collection of helper functions and classes for WordPress
 * Version: 0.1.0
 * Author: Bloom User Experience
 * Author URI: https://www.bloom-ux.com
 * License: GPL-3.0-or-later
 */

/**
 * Use default hooks
 */
 if ( ! defined( 'BLOOM_UX_WP_HELPERS_USE_HOOKS' ) || BLOOM_UX_WP_HELPERS_USE_HOOKS ) {
	require_once __DIR__ .'/src/hooks.php';
}

if ( ! defined( 'BLOOM_UX_WP_HELPERS_USE_POLYFILLS' ) || BLOOM_UX_WP_HELPERS_USE_POLYFILLS ) {
	require_once __DIR__ .'/src/polyfills.php';
}
