<?php
/**
 * Pagination Trait file
 *
 * @category   Pagination
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Traits\Pagination;

use CodexShaper\Framework\Support\Helper;

/**
 *  Pagination trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Pagination {

	use PaginationControls;

	/**
	 * Get base url for pagination
	 *
	 * @return string Base url.
	 */
	public function get_base_url() {

		if ( is_page() || is_single() ) {
			return get_permalink();
		}

		if ( is_year() ) {
			return get_year_link( get_query_var( 'year' ) );
		}

		if ( is_month() ) {
			return get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
		}

		if ( is_day() ) {
			return get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
		}

		if ( is_category() || is_tag() || is_tax() ) {
			$queried_object = get_queried_object();
			return get_term_link( $queried_object->term_id, $queried_object->taxonomy );
		}

		if ( is_author() ) {
			return get_author_posts_url( get_the_author_meta( 'ID' ) );
		}

		if ( is_search() ) {
			return get_search_link();
		}

		if ( is_archive() ) {
			return get_post_type_archive_link( get_post_type() );
		}

		if ( is_singular() && 'post' !== get_post_type() && 'page' !== get_post_type() ) {
			$post_type = get_post_type_object( get_post_type() );

			if ( $post_type->has_archive ) {
				return get_post_type_archive_link( get_post_type() );
			}

			return get_permalink();
		}

		if ( $this->is_posts_page() ) {
			return get_permalink( get_option( 'page_for_posts' ) );
		}

		return home_url( '/' );
	}

	/**
	 * Determines whether the query is for an existing blog posts index page
	 *
	 * @param bool $custom_page_option Whether to check for a custom page option.
	 *
	 * @return bool True if blog posts index page.
	 */
	private function is_posts_page( $custom_page_option = true ) {
		if ( $custom_page_option ) {
			return ! is_front_page() && is_home();
		}

		$posts_page_id = (int) get_option( 'page_for_posts' );
		$base_url      = get_query_var( 'pagination_base_url' );

		if ( ! empty( $base_url ) ) {
			$post_id = url_to_postid( $base_url );

			return $posts_page_id === $post_id;
		}

		return false;
	}

	/**
	 * Get current page url
	 *
	 * @return string Current page URL.
	 */
	public function get_current_page() {
		if ( '' === $this->get_settings_for_display( 'pagination_type' ) ) {
			return 1;
		}

		return max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
	}

	/**
	 * Is allow to use custom page option
	 *
	 * @return boolean True if allow to use custom page option.
	 */
	public function is_allow_to_use_custom_page_option() {
		return 'ajax' === $this->get_settings_for_display( 'pagination_load_type' ) ||
				'yes' === $this->get_settings_for_display( 'pagination_individual_handle' );
	}

	/**
	 * Get base url for rest request
	 *
	 * @param int    $post_id Post ID.
	 * @param string $url     URL.
	 *
	 * @return string Base url.
	 */
	protected function get_base_url_for_rest_request( $post_id, $url ) {
		if ( $post_id > 0 ) {
			return get_permalink( $post_id );
		}

		global $wp_rewrite;

		if ( $wp_rewrite->using_permalinks() && ( $this->current_url_contains_taxonomy_filter() || $this->referer_contains_taxonomy_filter() ) ) {
			$url = $this->is_allow_to_use_custom_page_option() ? get_query_var( 'pagination_base_url' ) : get_query_var( 'pagination_base_url' ) . user_trailingslashit( "$wp_rewrite->pagination_base/", 'single_paged' );
		} else {
			$url = remove_query_arg( 'p', $url );
		}

		return $url;
	}

	/**
	 * Get wp link page url for normal page load
	 *
	 * @param string $url URL.
	 * @param array  $query_args Query args.
	 * @param string $url URL.
	 *
	 * @return string URL.
	 */
	protected function get_wp_link_page_url_for_preview( $post, $query_args, $url, $nonce_key = 'preview_nonce', $nonce = '' ) {

		if ($nonce && ! wp_verify_nonce( Helper::get_super_global_value($_GET, $nonce_key), $nonce ) ) {
			return;
		}

		if ( 'draft' === $post->post_status || ! isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
			return $url;
		}

		$query_args['preview_id']    = Helper::get_super_global_value( $_GET, 'preview_id' );
		$query_args['preview_nonce'] = Helper::get_super_global_value( $_GET, 'preview_nonce' );

		if ( $this->is_rest_request() || ! $this->current_url_contains_taxonomy_filter() ) {
			return get_preview_post_link( $post, $query_args, $url );
		}

		wp_parse_str( htmlspecialchars_decode( Helper::get_super_global_value( $_SERVER, 'QUERY_STRING' ) ), $query_params );

		foreach ( $query_params as $param_key => $param_value ) {
			if ( false !== strpos( $param_key, 'e-filter-' ) ) {
				$query_args[ $param_key ] = $param_value;
			}
		}

		return get_preview_post_link( $post, $query_args, $url );
	}

	/**
	 * Get wp link page url for rest request
	 *
	 * @param string $url URL.
	 * @param string $link_unescaped Link unescaped.
	 *
	 * @return string URL.
	 */
	protected function get_wp_link_page_url_for_rest_request( $url, $link_unescaped ) {
		$url_components = wp_parse_url( $link_unescaped );
		$query_args     = array();

		if ( isset( $url_components['query'] ) ) {
			wp_parse_str( $url_components['query'], $query_args );
		}

		$url = ! empty( $query_args ) ? $url . '&' . http_build_query( $query_args ) : $url;

		return $this->format_query_string_concatenation( $url );
	}

	/**
	 * Get wp link page url for normal page load
	 *
	 * @param string $url URL.
	 * @param int    $index Index.
	 * @param int    $post_id Post ID.
	 *
	 * @return string URL.
	 */
	private function get_wp_link_page_url_for_custom_page_option( $url, $index, $post_id ) {
		$base_raw_url   = $this->is_rest_request() ? $this->get_base_url_for_rest_request( $post_id, $url ) : $this->get_base_url();
		$pagination_key = 'e-page-' . $this->get_id();

		if ( 'yes' === $this->get_settings_for_display( 'pagination_individual_handle' ) ) {
			$base_raw_url .= $this->get_pagination_query_vars_for_others_individually_paginated_widgets( $pagination_key );
		}

		return $this->format_query_string_concatenation( $base_raw_url . '&' . $pagination_key . '=' . $index );
	}

	/**
	 * Get pagination query vars for others individually paginated widgets
	 *
	 * @param string $pagination_key Pagination.
	 *
	 * @return string $e_page Elements page.
	 */
	private function get_pagination_query_vars_for_others_individually_paginated_widgets( string $pagination_key ): string {
		wp_parse_str( htmlspecialchars_decode( Helper::get_super_global_value( $_SERVER, 'QUERY_STRING' ) ), $query_params );

		$e_page = '';

		foreach ( $query_params as $param_key => $param_value ) {
			if ( false !== strpos( $param_key, 'e-page' ) && $pagination_key !== $param_key ) {
				$e_page .= '&' . $param_key . '=' . $param_value;
			}
		}

		return $e_page;
	}

	/**
	 * Get wp link page url for custom page option
	 *
	 * @param int $index Index.
	 *
	 * @return string URL.
	 */
	public function get_wp_link_page( $index ) {
		if ( ( ! is_singular() || is_front_page() ) && ! $this->is_rest_request() && ! $this->is_allow_to_use_custom_page_option() ) {
			return get_pagenum_link( $index );
		}

		// Based on wp-includes/post-template.php:957 `_wp_link_page`.
		global $wp_rewrite;
		$post       = get_post();
		$query_args = array();
		$url        = get_permalink();

		if ( $this->is_rest_request() ) {
			$link_unescaped = wp_get_referer();
			$post_id        = url_to_postid( $link_unescaped );

			if ( $post_id > 0 ) {
				$post = get_post( $post_id );
			}

			$url = $this->get_base_url_for_rest_request( $post_id, $url );
		}

		if ( $index > 1 ) {
			if ( '' === get_option( 'permalink_structure' ) || in_array( $post->post_status, array( 'draft', 'pending' ) ) ) {
				$url = add_query_arg( $this->get_wp_pagination_query_var(), $index, $url );
			} elseif ( get_option( 'show_on_front' ) === 'page' && (int) get_option( 'page_on_front' ) === $post->ID ) {
				$url = trailingslashit( $url ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . $index, 'single_paged' );
			} else {
				$url = trailingslashit( $url ) . user_trailingslashit( $index, 'single_paged' );
			}
		}

		if ( $index > 1 && $this->is_allow_to_use_custom_page_option() ) {
			$url = $this->get_wp_link_page_url_for_custom_page_option( $url, $index, $post_id ?? 0 );
		}

		if ( 1 === $index && $this->is_allow_to_use_custom_page_option() ) {
			$url = $this->get_base_url();
		}

		if ( is_preview() ) {
			$url = $this->get_wp_link_page_url_for_preview( $post, $query_args, $url );
		}

		if ( $this->is_rest_request() ) {
			$url = $this->get_wp_link_page_url_for_rest_request( $url, $link_unescaped );
		}

		if ( ! $this->is_rest_request() && $this->current_url_contains_taxonomy_filter() && ! is_preview() ) {
			$url = $this->get_wp_link_page_url_for_normal_page_load( $url );
		}

		return esc_url( $url );
	}

	/**
	 * Get post nav link
	 *
	 * @param int $page_limit Page limit.
	 *
	 * @return array Post nav link.
	 */
	public function get_posts_nav_link( $page_limit = null ) {
		if ( ! $page_limit ) {
			$page_limit = $this->query->max_num_pages;
		}

		$return = array();

		$paged = $this->get_current_page();

		$link_template     = '<a class="page-numbers %s" href="%s">%s</a>';
		$disabled_template = '<span class="page-numbers %s">%s</span>';

		if ( $paged > 1 ) {
			$next_page = intval( $paged ) - 1;
			if ( $next_page < 1 ) {
				$next_page = 1;
			}

			$return['prev'] = sprintf(
				$link_template,
				'prev',
				$this->get_wp_link_page( $next_page ),
				$this->get_settings_for_display( 'pagination_prev_label' )
			);
		} else {
			$return['prev'] = sprintf( $disabled_template, 'prev', $this->get_settings_for_display( 'pagination_prev_label' ) );
		}

		$next_page = intval( $paged ) + 1;

		if ( $next_page <= $page_limit ) {
			$return['next'] = sprintf( $link_template, 'next', $this->get_wp_link_page( $next_page ), $this->get_settings_for_display( 'pagination_next_label' ) );
		} else {
			$return['next'] = sprintf( $disabled_template, 'next', $this->get_settings_for_display( 'pagination_next_label' ) );
		}

		return $return;
	}

	/**
	 * Current URL contains taxonomy filter
	 *
	 * @return boolean True if current URL contains taxonomy filter.
	 */
	public function current_url_contains_taxonomy_filter() {
		return false !== strpos( Helper::get_super_global_value( $_SERVER, 'QUERY_STRING' ), 'e-filter-' );
	}

	/**
	 * Referer contains taxonomy filter
	 *
	 * @return boolean True if referer contains taxonomy filter.
	 */
	public function referer_contains_taxonomy_filter() {
		return false !== strpos( Helper::get_super_global_value( $_SERVER, 'HTTP_REFERER' ), 'e-filter-' );
	}
}
