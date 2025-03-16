<?php
/**
 * Taxonomy file
 *
 * @category   ORM
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/csmf
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Models\Taxonomies;

use CodexShaper\Framework\Foundation\Model;
use CodexShaper\Framework\Models\Post\Post;
use WP_Query;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Taxonomy Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/csmf
 * @since      1.0.0
 */
class Taxonomy extends Model {

	/**
	 * Get supported taxonomies
	 *
	 * @param array $public_types Public types.
	 *
	 * @return array Supported taxonomies.
	 */
	public static function get_supported_taxonomies( $public_types = array() ) {
		$supported_taxonomies = array();

		$public_types = $public_types ?? Post::get_public_types();

		foreach ( $public_types as $type => $title ) {
			$taxonomies = get_object_taxonomies( $type, 'objects' );
			foreach ( $taxonomies as $key => $tax ) {
				if ( ! array_key_exists( $key, $supported_taxonomies ) ) {
					$label = $tax->label;
					if ( in_array( $tax->label, $supported_taxonomies ) ) {
						$label = $tax->label . ' (' . $tax->name . ')';
					}
					$supported_taxonomies[ $key ] = $label;
				}
			}
		}

		return $supported_taxonomies;
	}

	/**
	 * Get terms
	 *
	 * @param array $post_types Post types.
	 * @param array $taxonomies Taxonomies.
	 * @param int   $post_ID    Post ID.
	 *
	 * @return array Terms.
	 */
	public static function get_terms( $post_types, $taxonomies = array(), $post_ID = null ) {
		if ( ! is_array( $post_types ) ) {
			$post_types = array_filter( array( $post_types ) );
		}

		if ( ! is_array( $taxonomies ) ) {
			$taxonomies = array_filter( (array) $taxonomies );
		}

		if ( empty( $post_types ) || ( count( $post_types ) === 1 && ( $post_types[0] === 'all' || $post_types === '' ) ) ) {
			return get_terms(
				array(
					'hide_empty' => false,
				)
			);
		}

		$terms = array();
		foreach ( $post_types as $post_type ) {

			$supported_taxonomies = get_object_taxonomies( $post_type, 'objects' );

			// Set all taxonomies if there is no filtered taxonomy.
			if ( empty( $taxonomies ) ) {
				foreach ( $supported_taxonomies as $key => $tax ) {
					if ( ! in_array( $key, $taxonomies ) ) {
						$taxonomies[] = $key;
					}
				}
			}

			foreach ( $taxonomies as $taxonomy ) {
				if ( ! key_exists( $taxonomy, $supported_taxonomies ) ) {
					continue;
				}

				$taxonomy_terms = $post_ID ? get_the_terms( $post_ID, $taxonomy ) : get_terms(
					array(
						'taxonomy'   => $taxonomy,
						'hide_empty' => false,
					)
				);

				if ( is_wp_error( $taxonomy_terms ) ) {
					continue;
				}

				$terms = array_merge( $terms, $taxonomy_terms );
			}
		}

		return $terms;
	}

	/**
	 * Get current terms
	 *
	 * @param array $taxonomies Taxonomies.
	 *
	 * @return array Terms.
	 */
	public static function get_current_terms( $taxonomies ) {
		$query_args = static::get_current_query_args();
		$query      = new WP_Query( $query_args );
		$terms      = array();
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$post_terms = static::get_terms( get_post_type(), $taxonomies, get_the_ID() );

				if ( $post_terms && ! empty( $post_terms ) ) {
					$terms = array_merge( $terms, $post_terms );
				}
			}

			wp_reset_postdata();
		}

		return $terms;
	}

	/**
	 * Get current query args
	 *
	 * @return array Current query args.
	 */
	protected static function get_current_query_args() {
		$current_query_vars = $GLOBALS['wp_query']->query_vars;

		/**
		 * Current query variables.
		 *
		 * Filters the query variables for the current query. This hook allows
		 * developers to alter those variables.
		 *
		 * @since 1.0.0
		 *
		 * @param array $current_query_vars Current query variables.
		 */
		$current_query_vars = apply_filters( 'csmf/query/get_query_args/current_query', $current_query_vars );

		return $current_query_vars;
	}
}
