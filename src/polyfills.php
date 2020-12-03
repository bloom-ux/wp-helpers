<?php
/**
 * Polyfills backport specific functionalities to older WordPress versions
 */

if ( ! function_exists( 'wp_get_environment_type') ) :
	/**
	 * Retrieve the current environment type.
	 *
 	 * The type can be set via the `WP_ENVIRONMENT_TYPE` global system variable,
	 * or a constant of the same name.
	 *
	 * Possible values are 'local', 'development', 'staging', and 'production'.
	 * If not set, the type defaults to 'production'.
	 *
	 * @return string The current environment type.
	 */
	function wp_get_environment_type() {
		static $current_env = '';

		if ( $current_env ) {
			return $current_env;
		}

		$wp_environments = array(
			'local',
			'development',
			'staging',
			'production',
		);

		// Check if the environment variable has been set, if `getenv` is available on the system.
		if ( function_exists( 'getenv' ) ) {
			$has_env = getenv( 'WP_ENVIRONMENT_TYPE' );
			if ( false !== $has_env ) {
				$current_env = $has_env;
			}
		}

		// Fetch the environment from a constant, this overrides the global system variable.
		if ( defined( 'WP_ENVIRONMENT_TYPE' ) ) {
			$current_env = WP_ENVIRONMENT_TYPE;
		}

		// Make sure the environment is an allowed one, and not accidentally set to an invalid value.
		if ( ! in_array( $current_env, $wp_environments, true ) ) {
			$current_env = 'production';
		}

		return $current_env;
	}
endif;
