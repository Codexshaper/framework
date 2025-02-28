<?php
/**
 * Query Builder file
 *
 * @category   Database
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Builder\Database;

use WP_Query;

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Query Builder class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Query extends WP_Query {

	/**
	 * Constructor.
	 *
	 * Sets up the WordPress query, if parameter is not empty.
	 *
	 * @since 1.5.0
	 *
	 * @see WP_Query::parse_query() for all available arguments.
	 *
	 * @param string|array $query URL query string or array of vars.
	 */
	public function __construct( $query = '' ) {
		// Do your settings here
		parent::__construct( $query );
	}

	/**
	 * Retrieves an array of the latest posts, or posts matching the given criteria.
	 *
	 * For more information on the accepted arguments, see the
	 * {@link https://developer.wordpress.org/reference/classes/wp_query/
	 * WP_Query} documentation in the Developer Handbook.
	 *
	 * The `$ignore_sticky_posts` and `$no_found_rows` arguments are ignored by
	 * this function and both are set to `true`.
	 *
	 * The defaults are as follows:
	 *
	 * @since 1.2.0
	 *
	 * @see WP_Query
	 * @see WP_Query::parse_query()
	 *
	 * @param array $args {
	 *     Optional. Arguments to retrieve posts. See WP_Query::parse_query() for all available arguments.
	 *
	 *     @type int        $numberposts      Total number of posts to retrieve. Is an alias of `$posts_per_page`
	 *                                        in WP_Query. Accepts -1 for all. Default 5.
	 *     @type int|string $category         Category ID or comma-separated list of IDs (this or any children).
	 *                                        Is an alias of `$cat` in WP_Query. Default 0.
	 *     @type int[]      $include          An array of post IDs to retrieve, sticky posts will be included.
	 *                                        Is an alias of `$post__in` in WP_Query. Default empty array.
	 *     @type int[]      $exclude          An array of post IDs not to retrieve. Default empty array.
	 *     @type bool       $suppress_filters Whether to suppress filters. Default true.
	 * }
	 * @return WP_Post[]|int[] Array of post objects or post IDs.
	 */
	public static function get_post_types( $args ) {
		$defaults = array(
			'numberposts'      => 5,
			'category'         => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'include'          => array(),
			'post_type'        => 'post',
			'suppress_filters' => false,
		);

		$parsed_args = wp_parse_args( $args, $defaults );

		return get_posts( $parsed_args );
	}

	/**
	 * Destroys the previous query and sets up a new query.
	 *
	 * This should be used after query_posts() and before another query_posts().
	 * This will remove obscure bugs that occur when the previous WP_Query object
	 * is not destroyed properly before another is set up.
	 *
	 * @since 2.3.0
	 *
	 * @global WP_Query $wp_query     WordPress Query object.
	 * @global WP_Query $wp_the_query Copy of the global WP_Query instance created during wp_reset_postdata().
	 */
	public function reset() {
		wp_reset_postdata();
	}
}
