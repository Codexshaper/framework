<?php

/**
 * Helper functions
 *
 * @category   Core
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use CodexShaper\Framework\Application;

if (! function_exists('csmf_app')) {
    /**
     * Get the available container instance.
     *
     * @param  string|class|null  $abstract Abstract.
     * @param  array  $parameters Parameters.
	 * 
     * @return mixed|\CodexShaper\Framework\Container\Container Container instance.
     */
    function csmf_app($abstract = null, array $parameters = [], $plugin_base_url = '', $plugin_base_path = '')
    {
		$app = Application::getInstance($plugin_base_url, $plugin_base_path);

        if (is_null($abstract)) {
            return $app;
        }

        return $app->make($abstract, $parameters);
    }
}

if ( ! function_exists( 'csmf_config' ) ) {

	/**
	 * Get core helper function
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_config( $name = '', $value = null ) {
		$config = csmf_app('config');

		if (! $name) {
			return $config;
		}

		if ($name && $value) {
			return $config->set($name, $value);
		}

		return csmf_app('config')->get( $name );
	}
}

if ( ! function_exists( 'csmf_helper' ) ) {

	/**
	 * Get core helper function
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_helper() {
		if ( ! class_exists( '\CodexShaper\Framework\Core\Helper' ) ) {
			return;
		}
		return CodexShaper\Framework\Support\Facades\Helper::instance();
	}
}

if ( ! function_exists( 'csmf_option_builder' ) ) {

	/**
	 * Get page by page title
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_option_builder() {
		if ( ! class_exists( '\CodexShaper\Framework\Builder\COB' ) ) {
			return;
		}

		return CodexShaper\Framework\Builder\COB::instance();
	}
}

if ( ! function_exists( 'csmf_get_page_by_title' ) ) {

	/**
	 * Get page by page title
	 *
	 * @param string $title Page title.
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_get_page_by_title( $title ) {
		$query = new WP_Query(
			array(
				'post_type'              => 'page',
				'title'                  => esc_html( $title ),
				'post_status'            => 'all',
				'posts_per_page'         => 1,
				'no_found_rows'          => true,
				'ignore_sticky_posts'    => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'orderby'                => 'post_date ID',
				'order'                  => 'ASC',
			)
		);

		return $query->post ?? null;
	}
}

if ( ! function_exists( 'csmf_query' ) ) {

	/**
	 * Get query by options
	 *
	 * @param string|array $options Query options.
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_query( $options = '' ) {
		return new CodexShaper\Framework\Builder\Database\Query( $options );
	}
}

if ( ! function_exists( 'csmf_reset_query' ) ) {

	/**
	 * Reset current query
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_reset_query() {
		wp_reset_postdata();
	}
}

/**
 * Retrieves an array of the elementor save template.
 *
 * For more information on the accepted arguments, see the
 * {@link https://developer.wordpress.org/reference/classes/wp_query/
 * WP_Query} documentation in the Developer Handbook.
 *
 * @see WP_Query::parse_query()
 * @see WP_Query
 * @since 1.0.0
 *
 * @param array $args
 *
 * @return WP_Post[]|int[] Array of post objects or post IDs.
 */
if ( ! function_exists( 'csmf_get_elementor_templates' ) ) {

	function csmf_get_elementor_templates( $args = null ) {
		$templates = array();

		$defaults = array(
			'post_type'   => 'elementor_library',
			'post_status' => 'publish',
			'numberposts' => - 1,
		);

		if ( isset( $args['post_type'] ) ) {
			unset( $args['post_type'] ); // Post type always `elementor_library`
		}

		$parsed_args = wp_parse_args( $args, $defaults );

		$posts = csmf_query()->get_post_types( $parsed_args );

		if ( $posts ) {
			foreach ( $posts as $post ) {
				$templates[ $post->ID ] = esc_html( $post->post_title );
			}
		}

		return $templates;
	}
}

if ( ! function_exists( 'csmf_app_base_path' ) ) {

	/**
	 * Get view base
	 *
	 * @return string View base path.
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_app_base_path() {
		return csmf_app()->getAppBasePath();
	}
}

if ( ! function_exists( 'csmf_plugin_base_path' ) ) {

	/**
	 * Get view base
	 *
	 * @return string View base path.
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_plugin_base_path() {
		
		if ( ! defined('CSMF_PLUGIN_BASE_PATH') ) {
			define( 'CSMF_PLUGIN_BASE_PATH', csmf_app()->getPluginBasePath() );
		}

		return trailingslashit(untrailingslashit(CSMF_PLUGIN_BASE_PATH));
	}
}

if ( ! function_exists( 'csmf_plugin_base_url' ) ) {

	/**
	 * Get view base
	 *
	 * @return string View base path.
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_plugin_base_url() {
		return csmf_app()->getPluginBaseUrl();
	}
}

if ( ! function_exists( 'csmf_view_base' ) ) {

	/**
	 * Get view base
	 *
	 * @param array $base View name.
	 *
	 * @return string View base path.
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_view_base( $view_base = '' ) {
		if ( ! $view_base || empty( $view_base ) ) {
			$view_base = csmf_plugin_base_path() . 'views';
		}

		return $view_base;
	}
}

if ( ! function_exists( 'csmf_view_path' ) ) {

	/**
	 * Render View
	 *
	 * @param array  $view View name.
	 * @param string $base View base.
	 *
	 * @return string View path.
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_view_path( $view, $base = '', $extension = 'view.php' ) {
		// Get the view base path.
		$view_base = csmf_view_base( $base );
		// Sanitize the view name.
		$path = str_replace( array( '.', '|' ), DIRECTORY_SEPARATOR, $view );
		$fallback_view_base = csmf_app_base_path() . 'views';
		$view_base = csmf_plugin_base_path() . 'views';
		$elementor_view_base = csmf_plugin_base_path() . 'widgets/elementor/views';
		$wordpress_view_base = csmf_plugin_base_path() . 'widgets/wordpress/views';

		// Check if the view file exists.
		if ( empty( $base ) ) {
			/**
			 * Filter view bases
			 *
			 * @param array $bases View bases.
			 */
			$bases = apply_filters( 
				'csmf/view/bases', 
				array( 
					$elementor_view_base, 
					$wordpress_view_base, 
					$view_base,
					$fallback_view_base,
				) 
			);

			foreach ( $bases as $custom_base ) {

				$view_path = "{$custom_base}/{$path}.{$extension}";
				// Check if the view file exists. If exists, break the loop.
				if ( file_exists( $view_path ) ) {
					break;
				}
			}
		}

		if ( ! file_exists( $view_path ) ) {
			// Define the view path.
			$view_path = "{$view_base}/{$path}.{$extension}";
		}

		return $view_path;
	}
}

if ( ! function_exists( 'csmf_view_exists' ) ) {

	/**
	 * Check view exists
	 *
	 * @param array  $view View name.
	 * @param string $base View base.
	 *
	 * @return bool Is view exists?
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_view_exists( $view, $base = '' ) {

		$view_path = csmf_view_path( $view, $base );

		// Check if the view file exists
		if ( ! file_exists( $view_path ) ) {
			return false;
		}

		return true;
	}
}

if ( ! function_exists( 'csmf_view' ) ) {

    /**
     * Render a View with Full Scope Isolation
     *
     * @param string $view View name.
     * @param array  $data Variables to pass to the view.
     * @param bool   $render Whether to return the rendered content instead of echoing it.
     * @param string $base Base directory for the view files.
     *
     * @return string|void Rendered output or void if rendered directly.
     */
    function csmf_view( $view, $data = [], $render = false, $base = '' ) {
        static $data_stack = []; // Keeps track of view data for nested calls.

        // Resolve the full path to the view file.
        $view_path = csmf_view_path( $view, $base );

        // Check if the view file exists.
        if ( ! file_exists( $view_path ) ) {
            throw new Exception(
                sprintf(
					/* translators: %s: View file path. */
                    esc_html__( 'View file not found: %s', 'codexshaper-framework' ),
                    esc_html( $view_path )
                )
            );
        }

        // Push the current view data onto the stack.
        array_push( $data_stack, $data );

        // Use a closure to isolate the view's scope.
        $output = (function( $view_path ) use ( &$data_stack ) {
            // Extract the latest data on the stack.
            extract( end( $data_stack ), EXTR_SKIP );

            // Start output buffering.
            ob_start();

            // Include the view file.
            include $view_path;

            // Return the buffered content.
            return ob_get_clean();
        })( $view_path );

        // Pop the current view data off the stack after rendering.
        array_pop( $data_stack );

        // Return or echo the output based on the $render flag.
        if ( $render ) {
            return $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

if ( ! function_exists( 'csmf_view_render' ) ) {

	/**
	 * Render View
	 *
	 * @param string $view View name.
	 * @param array  $data View data.
	 * @param string $base View base.
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_view_render( $view, $data = array(), $base = '' ) {
		return csmf_view( $view, $data, true, $base );
	}
}

if ( ! function_exists( 'csmf_get_string_attributes' ) ) {

	/**
	 * Get settings
	 *
	 * @param array $attributes Attributes.
	 *
	 * @return void
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_get_string_attributes( $attributes, $render = false ) {

		$attributes_html = implode( ' ', $attributes );

		if ( $render ) {
			return $attributes_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Intentional unescaped output.
		}

		echo $attributes_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Intentional unescaped output.
	}
}

if ( ! function_exists( 'csmf_settings' ) ) {

	/**
	 * Get settings
	 *
	 * @param string $option_name Option name.
	 * @param string $key Option key.
	 * @param mixed  $default Default value.
	 * @param string $sanitize_callback Sanitize callback.
	 *
	 * @return mixed Option value.
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_settings( $option_name, $key = null, $default = false, $sanitize_callback = '' ) {
		$settings = get_option( $option_name, array() );

		if ( $key !== null && ! empty( $key ) ) {
			$value = $settings[ $key ] ?? $default;
			return $sanitize_callback ? call_user_func( $sanitize_callback, $value ) : $value;
		}

		// If settings is an array, Sanitize the entire array if no specific key is requested.
		if ( is_array( $settings ) ) {
			foreach ( $settings as $setting_name => $setting ) {
				$settings[ $setting_name ] = $sanitize_callback ? call_user_func( $sanitize_callback, $setting ) : $setting;
			}
		}

		return $settings;
	}
}

if ( ! function_exists( 'csmf_get_option' ) ) {

	/**
	 * Get CodexShaper Option Builder option
	 *
	 * @param string $option Option name.
	 * @param mixed  $default Default value if option doesn't exists.
	 *
	 * @package CodexShaper_Framework
	 */
	function csmf_get_option( $option, $parent = null, $default = '' ) {
		if ( $parent ) {
			return  csmf_settings( $parent, $option, $default );
		}

		return get_option( $option, $default );
	}
}

if ( ! function_exists( 'csmf_sanitize_recursive' ) ) {
	/**
	 * Recursively sanitize an array or string.
	 *
	 * @param mixed $data The data to sanitize (string or array).
	 * @return mixed The sanitized data.
	 */
	function csmf_sanitize_recursive( $data ) {
		if ( is_array( $data ) ) {
			return array_map( 'csmf_sanitize_recursive', $data );
		}

		return sanitize_text_field( $data );
	}
}

if(!function_exists('csmf_get_post_types')) {
	/**
	 * Get all post types
	 *
	 * @return array $posts All post types.
	 */
	function csmf_get_post_types() {
		global $wp_post_types;
		$posts = array();
		$skip_post_types = [
			'post',
			'page',        
			'custom_css',
			'wp_navigation',
			'wp_global_styles',
			'wp_template_part',
			'wp_template',
			'wp_block',
			'user_request',
			'oembed_cache',
			'customize_changeset',
			'revision',
			'attachment',
			'elementor_library',
			'csmf-theme-builder',
			'csmf-custom-fonts',
		];
		
		foreach ($wp_post_types as $post_type) {
			// Continue if post type is in skip post types.
			if(in_array($post_type->name, $skip_post_types)){
				continue;
			}
			// Add post type to posts array.
			$posts[$post_type->name] = $post_type->labels->menu_name ?? $post_type->label ?? $post_type->labels->singular_name ?? $post_type->name;
		}
		return $posts;
	}
}

if(!function_exists('csmf_get_taxonomies')) {
	/**
	 * Get all taxonomies
	 *
	 * @return array $taxonomies All taxonomies.
	 */
	function csmf_get_taxonomies() {
		// Get all taxonomies.
		global $wp_taxonomies;
		$taxonomies = array();
		// Loop through all taxonomies.
		foreach ($wp_taxonomies as $key => $cat_type) {
			$taxonomies[$key] = $cat_type->label; 
		}
		// Return all taxonomies.
		return $taxonomies;
	}
}

if(!function_exists('csmf_get_cache_post_types')) {
	/**
	 * Get all post types
	 *
	 * @return array $posts All post types.
	 */
	function csmf_get_cache_post_types() {
		// Get all post types.
		$data = get_option('csmf_post_types_cache');
		// If no data found, return empty array.
		if (! $data) {
			return [];
		}
		// If data is not array, convert it to array.
		if (! is_array($data)) {
			$data = (array) $data;
		}
		// Return all post types.
		return $data;
	}
}

if(!function_exists('csmf_get_cache_taxonomies')) {
	/**
	 * Get all taxonomies
	 *
	 * @return array $taxonomies All taxonomies.
	 */
	function csmf_get_cache_taxonomies() {
		// Get all taxonomies.
		$data = get_option('csmf_taxonomies_cache');
		// If no data found, return empty array.
		if (! $data) {
			return [];
		}
		// If data is not array, convert it to array.
		if (! is_array($data)) {
			$data = (array) $data;
		}
		// Return all taxonomies.
		return $data;
	}
}

if(!function_exists('csmf_get_cache_metaboxes')) {
	/**
	 * Get all taxonomies
	 *
	 * @return array $taxonomies All taxonomies.
	 */
	function csmf_get_cache_metaboxes($field = '') {
		$metabox_prefix = csmf_config('options.metabox.prefix') ?? 'csmf_metabox_settings';
		$metabox_option_name = csmf_config('options.metabox.option_name') ?? 'csmf_metabox_options';
		// Get all settings.
		$data = csmf_settings($metabox_prefix);
		$metaboxes = $data[$metabox_option_name] ?? [];

		if (! empty($field)) {
			$data 				= [];
			foreach ($metaboxes as $metabox) {
				$data[$metabox[$field]] = $metabox['label'] ?? $metabox[$field];
			}

			return $data;
		}

		return $metaboxes;
	}
}

if(!function_exists('csmf_get_cache_sections')) {
	/**
	 * Get all taxonomies
	 *
	 * @return array $taxonomies All taxonomies.
	 */
	function csmf_get_cache_sections($field = '') {
		$section_prefix 		= csmf_config('options.section.prefix') ?? 'csmf_metabox_settings';
		$section_option_name 	= csmf_config('options.section.option_name') ?? 'csmf_section_settings';
		// Get all settings.
		$data 					= csmf_settings($section_prefix);
		$sections 				= $data[$section_option_name] ?? [];

		if ( ! is_array($sections) || empty($sections)) {
			return [];
		}

		if (! empty($field)) {
			$data 				= [];
			foreach ($sections as $section) {
				$data[$section[$field]] = $section['name'] ?? $section[$field];
			}

			return $data;
		}

		return $sections;
	}
}

if(!function_exists('csmf_get_cache_fields')) {
	/**
	 * Get all taxonomies
	 *
	 * @return array $taxonomies All taxonomies.
	 */
	function csmf_get_cache_fields($field = '') {
		$field_prefix = csmf_config('options.field.prefix') ?? 'csmf_metabox_settings';
		$field_option_name = csmf_config('options.field.option_name') ?? 'csmf_metabox_section_field_settings';
		// Get all settings.
		$data = csmf_settings($field_prefix);
		$fields = $data[$field_option_name] ?? [];

		if (empty($field)) {
			return $fields;
		}

		$fields = wp_list_pluck($fields, $field);

		return $fields;
	}
}

if(!function_exists('csmf_get_builder_fields')) {
	/**
	 * Get all taxonomies
	 *
	 * @return array $taxonomies All taxonomies.
	 */
	function csmf_get_builder_fields($keys = '', $skips = array()) {
		$fields = csmf_config('builder.fields') ?? [];

		/**
		 * Filter fields
		 *
		 * @param array $fields Fields.
		 */
		$fields = apply_filters('csmf/builder/fields', $fields);

		// Filter active fields	
		$fields = array_filter($fields, fn($field) => $field['is_active'] ?? true);

		if (! is_array($fields) || empty($fields)) {
			return [];
		}

		if (is_array($skips) && ! empty($skips) ) {
			foreach ($fields as $idx => $field) {

				if (! in_array($idx, $skips)) {
					continue;
				}

				unset($fields[$idx]);
			}
		}

		if (! empty($keys)) {
			
			$data = array();

			// When keys is an array.
			if (is_array($keys)) {
				// Loop through keys.
				foreach($keys as $key) {
					if (key_exists($key, $fields)) {
						$data[$key] = $fields[$key];
					}
				}
				return $data;
			}

			// Loop through fields.
			foreach ($fields as $field_id => $field) {

				// When keys is exact equal to 'id'.
				if ( 'field_id' === $keys || 'id' === $keys || 'ID' === $keys || 'ids' === $keys ) {
					$data[$field_id] = $field['label'] ?? $field['name'] ?? $field_id;
					continue;
				}

				// When keys is exact equal to field key.
				if ($field_id !== $keys) {
					continue;
				}

				$data[$keys] = $field['label'] ?? $field['name'] ?? $keys;
			}

			return $data;
		}

		return $fields;
	}
}

if (! function_exists('csmf_get_json_data')) {
	/**
	 * Get json data
	 *
	 * @param string $file_path File path.
	 *
	 * @return array $data Json data.
	 */
	function csmf_get_json_data( $file_path, $associative = true ) {
		if ( ! file_exists( $file_path ) || ! is_readable( $file_path ) ) {
			return [];
		}
	
		return wp_json_file_decode( $file_path, array( 'associative' => $associative ) ) ?: [];
	}	
}

if (! function_exists('csmf_elementor_modules')) {
	/**
	 * Get json data
	 *
	 * @param string $file_path File path.
	 *
	 * @return array $data Json data.
	 */
	function csmf_elementor_modules( $module_dir ) {

		$module_directory = untrailingslashit($module_dir) . "/*//";
		$modules = [];
		foreach ( glob( $module_directory ) as $path ) {
			if ( is_dir( $path ) ) {
				$parts  = explode( '/', untrailingslashit( $path ) );
				$module = end( $parts );
				if ( ! in_array( $module, $modules, true ) ) {
					$modules[$module] = csmf_get_json_data( $path . 'module.json' );
				}
			}
		}

		return $modules;
	}	
}

if (! function_exists('csmf_builder_template_tab_filter')) {
	/**
	 * Get add tab filter query
	 *
	 * @param \WP_Query $query
	 * @param string $template_type Template type.
	 * @param string $meta_key Meta key.
	 *
	 * @return array $data Json data.
	 */
	function csmf_builder_template_tab_filter(\WP_Query $query, $template_type, $meta_key) {
		if ( ! is_admin() ) {
			return;
		}
		$query->query_vars['meta_key']     = $meta_key;
		$query->query_vars['meta_value']   = $template_type;
		$query->query_vars['meta_compare'] = '=';
	}
}

if (! function_exists('csmf_get_current_post_by_condition')) {
	/**
	 * Get current post by condition
	 *
	 * @param string $post_type Post type.
	 * @param string $template_type Template type.
	 * @param string $meta_key Meta key.
	 *
	 * @return array $data Json data.
	 */
	function csmf_get_current_post_by_condition($post_type, $template_type, $meta_key) {

		$query_args = array(
			'post_type'      => $post_type,
			'fields'         => 'ids',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'orderby'        => 'date',
			'meta_query'     => array(
				array(
					'key'   => $meta_key,
					'value' => $template_type,
				),
			),
		);
		
		$query      = new \WP_Query( $query_args );

		return $query->posts;
	}
}

/**
 * Exports a WordPress option as a downloadable JSON file.
 *
 * @since 1.0.0
 * @return void
 */
if ( ! function_exists( 'csmf_export_option' ) ) {
	function csmf_export_option() {
		// Verify nonce.
		$nonce = isset( $_GET['nonce'] ) ? sanitize_text_field( wp_unslash( $_GET['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'csmf_backup_nonce' ) ) {
			wp_die( esc_html__( 'Error: Invalid nonce verification.', 'codexshaper-framework' ) );
		}

		// Get and validate option name.
		$option_name = isset( $_GET['option_name'] ) ? sanitize_text_field( wp_unslash( $_GET['option_name'] ) ) : '';
		
		if ( empty( $option_name ) && isset( $_GET['identifier'] ) ) {
			$option_name = sanitize_text_field( wp_unslash( $_GET['identifier'] ) );
		}

		if ( empty( $option_name ) ) {
			wp_die( esc_html__( 'Error: Invalid key.', 'codexshaper-framework' ) );
		}

		// Get option content.
		$content = get_option( $option_name );

		if ( empty( $content ) ) {
			wp_die( esc_html__( 'Error: No data found.', 'codexshaper-framework' ) );
		}

		// Generate filename.
		$site_url   = str_replace( array( 'http://', 'https://', 'www.' ), '', get_site_url() );
		$site_url   = sanitize_file_name( $site_url );
		$timestamp  = gmdate( 'Y-m-d-His' );
		$filename   = "{$option_name}-{$site_url}-{$timestamp}.json";
		
		// Check for pretty print option.
		$json_pretty = isset( $_GET['json_pretty'] ) ? (bool) sanitize_text_field( wp_unslash( $_GET['json_pretty'] ) ) : false;
		$json_flag   = $json_pretty ? JSON_PRETTY_PRINT : 0;

		// Send appropriate headers and content.
		if ( ! headers_sent() ) {
			nocache_headers();
			header( 'Content-Type: application/json' );
			header( 'Content-Disposition: attachment; filename=' . $filename );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Pragma: public' );
			header( 'Expires: 0' );
		}

		echo wp_json_encode( $content, $json_flag );

		exit;
	}
}

/**
 * Imports option data from a JSON input.
 *
 * @since 1.0.0
 * @version 1.0.0
 * @return void
 */
if ( ! function_exists( 'csmf_import_option' ) ) {
	function csmf_import_option() {
		// Verify nonce.
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'csmf_backup_nonce' ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'codexshaper-framework' ) ) );
		}

		// Get and validate option name.
		$option_name = isset( $_POST['option_name'] ) ? sanitize_text_field( wp_unslash( $_POST['option_name'] ) ) : '';
		
		if ( empty( $option_name ) && isset( $_POST['identifier'] ) ) {
			$option_name = sanitize_text_field( wp_unslash( $_POST['identifier'] ) );
		}

		if ( empty( $option_name ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid key.', 'codexshaper-framework' ) ) );
		}

		// Get and validate import data.
		$data = isset( $_POST['data'] ) ? wp_kses_post_deep( json_decode( wp_unslash( trim( $_POST['data'] ) ), true ) ) : array();
		
		if ( empty( $data ) || ! is_array( $data ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: The response is not a valid JSON response.', 'codexshaper-framework' ) ) );
		}

		$existing_data = get_option( $option_name );
		// Check the option is exists.
		if ( false === $existing_data || empty( $existing_data ) || ! is_array( $existing_data )) {
			add_option( $option_name, $data );
			// Return success response.
			wp_send_json_success();
		}

		// Import the data.
		update_option( $option_name, $data );
		
		// Return success response.
		wp_send_json_success();
	}
}

/**
 * Resets an option backup to an empty state.
 *
 * @since 1.0.0
 * @version 1.0.0
 * @return void
 */
if ( ! function_exists( 'csmf_reset_option' ) ) {
	function csmf_reset_option() {
		// Verify nonce
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'csmf_backup_nonce' ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'codexshaper-framework' ) ) );
		}

		// Get and validate option name
		$option_name = isset( $_POST['option_name'] ) ? sanitize_text_field( wp_unslash( $_POST['option_name'] ) ) : '';
		
		if ( empty( $option_name ) && isset( $_POST['identifier'] ) ) {
			$option_name = sanitize_text_field( wp_unslash( $_POST['identifier'] ) );
		}

		if ( empty( $option_name ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid option name.', 'codexshaper-framework' ) ) );
		}

		// Reset the option to an empty array
		update_option( $option_name, array() );
		
		// Return success response
		wp_send_json_success();
	}
}

/**
 * Resets and Delete an option backup to an empty state.
 *
 * @since 1.0.0
 * @version 1.0.0
 * @return void
 */
if ( ! function_exists( 'csmf_delete_option' ) ) {
	function csmf_delete_option() {
		// Verify nonce
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'csmf_backup_nonce' ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'codexshaper-framework' ) ) );
		}

		// Get and validate option name
		$option_name = isset( $_POST['option_name'] ) ? sanitize_text_field( wp_unslash( $_POST['option_name'] ) ) : '';
		
		if ( empty( $option_name ) && isset( $_POST['identifier'] ) ) {
			$option_name = sanitize_text_field( wp_unslash( $_POST['identifier'] ) );
		}

		if ( empty( $option_name ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid option name.', 'codexshaper-framework' ) ) );
		}

		// Delete the option to an empty array
		delete_option( $option_name );
		
		// Return success response
		wp_send_json_success();
	}
}

add_action( "wp_ajax_csmf_settings_backup_export", 'csmf_export_option' );
add_action( 'wp_ajax_csmf_import_option', 'csmf_import_option' );
add_action( 'wp_ajax_csmf_reset_option', 'csmf_reset_option' );
add_action( 'wp_ajax_csmf_delete_option', 'csmf_delete_option' );