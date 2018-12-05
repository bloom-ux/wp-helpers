<?php
/**
 * Helper functions for WordPress
 *
 * @package Bloom_UX_WP_Helpers
 */

if ( ! function_exists( 'substr_full_words' ) ) :
	/**
	 * Return part of a string, cutting the string on full words
	 *
	 * @param string         $str The original string.
	 * @param int            $n      The maximum number of characters to return.
	 * @param boolean|string $hellip Whether to add ellipsis at the end if the string is longer, or provide a custom suffix.
	 * @return string Chopped string, optionally using ellipsis if the original was longer than the limit
	 */
	function substr_full_words( $str, $n, $hellip = false ) {
		if ( strlen( $str ) > $n ) {
			$out = substr( strip_tags( $str ), 0, $n );
			$out = explode( ' ', $out );
			array_pop( $out );
			$out = implode( ' ', $out );
			if ( is_string( $hellip ) ) {
				$out .= ' ' . $hellip;
			} elseif ( is_bool( $hellip ) && $hellip ) {
				$out .= ' [&hellip;]';
			}
		} else {
			$out = $str;
		}
		return $out;
	}
endif;

if ( ! function_exists( 'do_excerpt' ) ) :
	/**
	 * Generate a exceprt from whatever argument it's passed to it
	 *
	 * @param WP_Post|string      $post Post object with excerpt and/or content OR string.
	 * @param object|array|string $args Arguments: length, echo, strict mode.
	 * @return string Formatted excerpt
	 */
	function do_excerpt( $post, $args = null ) {
		$out    = '';
		$wrap   = '';
		$params = wp_parse_args(
			$args, array(
				'length'     => 255,
				'echo'       => false,
				'strict'     => false,
				'wrap'       => null,
				'wrap_id'    => null,
				'wrap_class' => 'entry-excerpt',
				'hellip'     => false,
				'append'     => null,
			)
		);
		$post   = apply_filters( 'do_excerpt_post', $post, $args );
		$params = apply_filters( 'do_excerpt_args', $args, $post );
		if ( isset( $params['wrap'] ) ) {
			$wrap_id    = $params['wrap_id'] ? ' id="' . esc_attr( $params['wrap_id'] ) . '"' : null;
			$wrap_class = $params['wrap_class'] ? ' class="' . esc_attr( $params['wrap_class'] ) . '"' : null;
			$wrap       = '<' . $params['wrap'] . $wrap_id . $wrap_class . '>';
		}
		if ( is_string( $post ) ) {
			$excerpt = strip_shortcodes( $post );
			$excerpt = wp_strip_all_tags( $excerpt, true );
			$excerpt = trim( $excerpt );
			if ( strlen( $excerpt ) > $params['length'] ) {
				$excerpt = substr_full_words( $excerpt, $params['length'] );
				if ( $params['hellip'] ) {
					$excerpt .= ' ' . $params['hellip'];
				}
			}
			if ( $params['append'] ) {
				$excerpt .= ' ' . $params['append'];
			}
			$out .= apply_filters( 'the_excerpt', $excerpt );
		} elseif ( is_object( $post ) ) {
			if ( isset( $post->post_excerpt ) && ! empty( $post->post_excerpt ) ) {
				if ( $params['strict'] && strlen( $post->post_excerpt ) > $params['length'] ) {
					$buff = substr_full_words( $post->post_excerpt, $params['length'] );
					if ( $params['hellip'] ) {
						$buff .= ' ' . $params['hellip'];
					}
					if ( $params['append'] ) {
						$buff .= ' ' . $params['append'];
					}
					$out .= apply_filters( 'the_excerpt', $buff );
				} else {
					if ( $params['append'] ) {
						$post->post_excerpt .= ' ' . $params['append'];
					}
					$out .= apply_filters( 'the_excerpt', $post->post_excerpt );
				}
			} elseif ( isset( $post->post_content ) && ! empty( $post->post_content ) ) {
				return do_excerpt( $post->post_content, $params );
			}
		}

		if ( ! $out ) {
			return false;
		}

		if ( $out ) {
			if ( isset( $params['wrap'] ) ) {
				$wrap .= $out . '</' . $params['wrap'] . '>';
				$out   = $wrap;
			}
			if ( $params['echo'] ) {
				echo esc_html( $out );
			} else {
				return $out;
			}
		}
	}
endif;
