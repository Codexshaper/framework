<?php
/**
 * Taxonomy Base file
 *
 * @category   Taxonomy
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cmf
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation;

use WP_Error;
use WP_Taxonomy;
use CodexShaper\Framework\Contracts\TaxonomyContract;
use CodexShaper\Framework\Foundation\Traits\Caller;
use CodexShaper\Framework\Foundation\Traits\Getter;
use CodexShaper\Framework\Foundation\Traits\Hook;
use CodexShaper\Framework\Foundation\Traits\Setter;
use CodexShaper\Framework\Foundation\Traits\Taxonomy\Options;

/**
 * Taxonomy Base Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cmf
 * @since      1.0.0
 */
abstract class Taxonomy implements TaxonomyContract {

	use Hook;
	use Getter;
	use Setter;
	use Caller;
	use Options;

	/**
	 * Taxonomy key. Must not exceed 32 characters and may only contain lowercase
	 * alphanumeric characters, dashes, and underscores. See sanitize_key() .
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @see sanitize_key() https://developer.wordpress.org/reference/functions/sanitize_key/
	 *
	 * @var string  The taxonomy name.
	 */
	protected $taxonomy;

	/**
	 * Object type or array of object types with which the taxonomy should be associated.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array|string  The taxonomy name.
	 */
	protected $object_type;

	/**
	 * Post Plural Title
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The taxonomy plural name.
	 */
	protected $plural_title;

	/**
	 * Taxonomy title.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The taxonomy title.
	 */
	protected $taxonomy_title;

	/**
	 * Taxonomy Active status
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The Taxonomy is active?
	 */
	protected $is_active = true;

	/**
	 * Constructs the new widget.
	 * 
	 * @param array $args Options array.
	 * 
	 * @since 1.0.0
	 * @access public
	 * 
	 * @return void
	 */
	public function __construct($args = array()) {
		
		$this->prepare_options($args);
		// Register the taxonomy.
		$this->add_action( 'init', 'register' );

		// Unregister the post type
		if ( method_exists( $this, 'is_unregister' ) && true === $this->is_unregister() ) {
			$this->add_action( 'init', 'unregister' );
		}
	}	

	/**
	 * Prepare options
	 *
	 * @param array $args Options array.
	 * 
	 * @since 1.0.0
	 * @access protected
	 * 
	 * @return void
	 */
	protected function prepare_options( $args = array() ) {

		if ( is_array($args) && !empty($args) ) {
			// Set taxonomy name.
			$taxonomy = $args['taxonomy'] ?? '';
			// Check if taxonomy exists.
			if ( ! $taxonomy ) {
				return;
			}
			// Set taxonomy labels.
			foreach($args as $label => $value) {
				$setter = "set_label_{$label}";

				if (method_exists($this, $setter)) {
					$this->{$setter}($value);
					unset($args[$label]);
				}
			}

			// Set other options.
			foreach($args as $option => $value) {
				if (property_exists($this, $option)) {
					$this->{$option} = $value;
				}
			}
		}

		$this->taxonomy = substr(sanitize_key(str_replace([' ', '-'], '_', $this->get_name())), 0, 32);

		if ( ! $this->taxonomy_title ) {
			$this->taxonomy_title = join( ' ', array_map( 'ucfirst', explode( '_', $this->taxonomy ) ) );
		}

		if ( method_exists( $this, 'get_title' ) ) {
			$this->taxonomy_title = $this->get_title();
		}

		$this->plural_title = csmf_pluralize( $this->taxonomy_title );

		if ( method_exists( $this, 'get_plural_title' ) ) {
			$this->plural_title = $this->get_plural_title();
		}

		if ( ! $this->public ) {
			$this->public = true;
		}

		if ( method_exists( $this, 'is_public' ) ) {
			$this->public = $this->is_public();
		}

		if ( ! $this->publicly_queryable ) {
			$this->publicly_queryable = true;
		}

		if ( ! $this->show_ui ) {
			$this->show_ui = true;
		}

		if ( method_exists( $this, 'is_show_ui' ) ) {
			$this->show_ui = $this->is_show_ui();
		}

		if ( ! $this->show_in_rest ) {
			$this->show_in_rest = true;
		}

		if ( method_exists( $this, 'is_show_in_rest' ) ) {
			$this->show_in_rest = $this->is_show_in_rest();
		}

		if ( ! $this->query_var ) {
			$this->query_var = true;
		}

		if ( method_exists( $this, 'is_query_var' ) ) {
			$this->query_var = $this->is_query_var();
		}

		if ( method_exists( $this, 'is_hierarchical' ) ) {
			$this->hierarchical = $this->is_hierarchical();
		}

		if ( method_exists( $this, 'is_show_in_menu' ) ) {
			$this->show_in_menu = $this->is_show_in_menu();
		}

		if ( method_exists( $this, 'is_show_in_nav_menus' ) ) {
			$this->show_in_nav_menus = $this->is_show_in_nav_menus();
		}

		// Set default labels and must be call before get_options().
		if ( empty( $this->labels ) ) {
			$this->set_default_labels();
		}

		// Get all options and must be call at the end of all settings.
		$this->options = $this->get_options();
	}

	/**
	 * Creates or modifies a taxonomy object.
	 *
	 * Note: Do not use before the {@see 'init'} hook.
	 *
	 * A simple function for creating or modifying a taxonomy object based on
	 * the parameters given. If modifying an existing taxonomy object, note
	 * that the `$object_type` value from the original registration will be
	 * overwritten.
	 *
	 * @since 2.3.0
	 * @since 4.2.0 Introduced `show_in_quick_edit` argument.
	 * @since 4.4.0 The `show_ui` argument is now enforced on the term editing screen.
	 * @since 4.4.0 The `public` argument now controls whether the taxonomy can be queried on the front end.
	 * @since 4.5.0 Introduced `publicly_queryable` argument.
	 * @since 4.7.0 Introduced `show_in_rest`, 'rest_base' and 'rest_controller_class'
	 *              arguments to register the taxonomy in REST API.
	 * @since 5.1.0 Introduced `meta_box_sanitize_cb` argument.
	 * @since 5.4.0 Added the registered taxonomy object as a return value.
	 * @since 5.5.0 Introduced `default_term` argument.
	 * @since 5.9.0 Introduced `rest_namespace` argument.
	 *
	 * @global WP_Taxonomy[] $wp_taxonomies Registered taxonomies.
	 *
	 * @param string       $taxonomy    Taxonomy key. Must not exceed 32 characters and may only contain
	 *                                  lowercase alphanumeric characters, dashes, and underscores. See sanitize_key().
	 * @param array|string $object_type Object type or array of object types with which the taxonomy should be associated.
	 * @param array|string $args        {
	 *     Optional. Array or query string of arguments for registering a taxonomy.
	 *
	 *     @type string[]      $labels                An array of labels for this taxonomy. By default, Tag labels are
	 *                                                used for non-hierarchical taxonomies, and Category labels are used
	 *                                                for hierarchical taxonomies. See accepted values in
	 *                                                get_taxonomy_labels(). Default empty array.
	 *     @type string        $description           A short descriptive summary of what the taxonomy is for. Default empty.
	 *     @type bool          $public                Whether a taxonomy is intended for use publicly either via
	 *                                                the admin interface or by front-end users. The default settings
	 *                                                of `$publicly_queryable`, `$show_ui`, and `$show_in_nav_menus`
	 *                                                are inherited from `$public`.
	 *     @type bool          $publicly_queryable    Whether the taxonomy is publicly queryable.
	 *                                                If not set, the default is inherited from `$public`
	 *     @type bool          $hierarchical          Whether the taxonomy is hierarchical. Default false.
	 *     @type bool          $show_ui               Whether to generate and allow a UI for managing terms in this taxonomy in
	 *                                                the admin. If not set, the default is inherited from `$public`
	 *                                                (default true).
	 *     @type bool          $show_in_menu          Whether to show the taxonomy in the admin menu. If true, the taxonomy is
	 *                                                shown as a submenu of the object type menu. If false, no menu is shown.
	 *                                                `$show_ui` must be true. If not set, default is inherited from `$show_ui`
	 *                                                (default true).
	 *     @type bool          $show_in_nav_menus     Makes this taxonomy available for selection in navigation menus. If not
	 *                                                set, the default is inherited from `$public` (default true).
	 *     @type bool          $show_in_rest          Whether to include the taxonomy in the REST API. Set this to true
	 *                                                for the taxonomy to be available in the block editor.
	 *     @type string        $rest_base             To change the base url of REST API route. Default is $taxonomy.
	 *     @type string        $rest_namespace        To change the namespace URL of REST API route. Default is wp/v2.
	 *     @type string        $rest_controller_class REST API Controller class name. Default is 'WP_REST_Terms_Controller'.
	 *     @type bool          $show_tagcloud         Whether to list the taxonomy in the Tag Cloud Widget controls. If not set,
	 *                                                the default is inherited from `$show_ui` (default true).
	 *     @type bool          $show_in_quick_edit    Whether to show the taxonomy in the quick/bulk edit panel. It not set,
	 *                                                the default is inherited from `$show_ui` (default true).
	 *     @type bool          $show_admin_column     Whether to display a column for the taxonomy on its taxonomy listing
	 *                                                screens. Default false.
	 *     @type bool|callable $meta_box_cb           Provide a callback function for the meta box display. If not set,
	 *                                                post_categories_meta_box() is used for hierarchical taxonomies, and
	 *                                                post_tags_meta_box() is used for non-hierarchical. If false, no meta
	 *                                                box is shown.
	 *     @type callable      $meta_box_sanitize_cb  Callback function for sanitizing taxonomy data saved from a meta
	 *                                                box. If no callback is defined, an appropriate one is determined
	 *                                                based on the value of `$meta_box_cb`.
	 *     @type string[]      $capabilities {
	 *         Array of capabilities for this taxonomy.
	 *
	 *         @type string $manage_terms Default 'manage_categories'.
	 *         @type string $edit_terms   Default 'manage_categories'.
	 *         @type string $delete_terms Default 'manage_categories'.
	 *         @type string $assign_terms Default 'edit_posts'.
	 *     }
	 *     @type bool|array    $rewrite {
	 *         Triggers the handling of rewrites for this taxonomy. Default true, using $taxonomy as slug. To prevent
	 *         rewrite, set to false. To specify rewrite rules, an array can be passed with any of these keys:
	 *
	 *         @type string $slug         Customize the permastruct slug. Default `$taxonomy` key.
	 *         @type bool   $with_front   Should the permastruct be prepended with WP_Rewrite::$front. Default true.
	 *         @type bool   $hierarchical Either hierarchical rewrite tag or not. Default false.
	 *         @type int    $ep_mask      Assign an endpoint mask. Default `EP_NONE`.
	 *     }
	 *     @type string|bool   $query_var             Sets the query var key for this taxonomy. Default `$taxonomy` key. If
	 *                                                false, a taxonomy cannot be loaded at `?{query_var}={term_slug}`. If a
	 *                                                string, the query `?{query_var}={term_slug}` will be valid.
	 *     @type callable      $update_count_callback Works much like a hook, in that it will be called when the count is
	 *                                                updated. Default _update_post_term_count() for taxonomies attached
	 *                                                to taxonomys, which confirms that the objects are published before
	 *                                                counting them. Default _update_generic_term_count() for taxonomies
	 *                                                attached to other object types, such as users.
	 *     @type string|array  $default_term {
	 *         Default term to be used for the taxonomy.
	 *
	 *         @type string $name         Name of default term.
	 *         @type string $slug         Slug for default term. Default empty.
	 *         @type string $description  Description for default term. Default empty.
	 *     }
	 *     @type bool          $sort                  Whether terms in this taxonomy should be sorted in the order they are
	 *                                                provided to `wp_set_object_terms()`. Default null which equates to false.
	 *     @type array         $args                  Array of arguments to automatically use inside `wp_get_object_terms()`
	 *                                                for this taxonomy.
	 *     @type bool          $_builtin              This taxonomy is a "built-in" taxonomy. INTERNAL USE ONLY!
	 *                                                Default false.
	 * }
	 * @return WP_Taxonomy|WP_Error The registered taxonomy object on success, WP_Error object on failure.
	 */
	public function register( $taxonomy = '', $object_type = '', $args = array() ) {
		
		if ( ! empty( $taxonomy ) ) {
			$this->taxonomy    = $taxonomy;
		}

		if ( ! empty( $object_type ) ) {
			$this->object_type = $object_type;
		}

		if ( ! empty( $this->args ) ) {
			$this->options     = $args;
		}

		if (empty($this->taxonomy)) {
			$this->taxonomy = $this->get_name();
		}

		if (empty($this->object_type)) {
			$this->object_type = $this->get_object_type();
		}

		if( empty($this->options) ) {
			$this->options = $this->get_options();
		}

		register_taxonomy( $this->taxonomy, $this->object_type, $this->options );
	}

	/**
	 * Unregisters a taxonomy.
	 *
	 * Can not be used to unregister built-in taxonomies.
	 *
	 * @since 4.5.0
	 *
	 * @global WP_Taxonomy[] $wp_taxonomies List of taxonomies.
	 *
	 * @param string $taxonomy Taxonomy name.
	 * @return true|WP_Error True on success, WP_Error on failure or if the taxonomy doesn't exist.
	 */
	public function unregister( $taxonomy = '' ) {
		$this->taxonomy = $taxonomy;

		if ( empty( $this->taxonomy ) ) {
			$this->taxonomy = $this->get_name();
		}

		unregister_taxonomy( $this->taxonomy );
	}

	/**
	 * Get post type activation status.
	 *
	 * @return bool  is activate?
	 */
	public static function is_active() {
		return true;
	}
}
