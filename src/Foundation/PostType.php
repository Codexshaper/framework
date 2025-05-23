<?php
/**
 * Base post type file
 *
 * @category   Classes
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/csmf
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation;

use CodexShaper\Framework\Contracts\PostTypeContract;
use CodexShaper\Framework\Foundation\Traits\Caller;
use CodexShaper\Framework\Foundation\Traits\Getter;
use CodexShaper\Framework\Foundation\Traits\Hook;
use CodexShaper\Framework\Foundation\Traits\PostType\Options;
use CodexShaper\Framework\Foundation\Traits\Setter;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class post type
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/csmf
 * @since      1.0.0
 */
abstract class PostType implements PostTypeContract {


	use Hook;
	use Options;
	use Getter;
	use Setter;
	use Caller;

	/**
	 * Post type key. Must not exceed 20 characters and may only contain
	 * lowercase alphanumeric characters, dashes, and underscores.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @see sanitize_key() https://developer.wordpress.org/reference/functions/sanitize_key/
	 *
	 * @var string  The post type name.
	 */
	protected $post_type;

	/**
	 * Post Title
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The post type title.
	 */
	protected $post_title;

	/**
	 * Post Plural Title
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The post type plural name.
	 */
	protected $plural_title;

	/**
	 * Post Active status
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The post is active?
	 */
	protected $is_active = true;

	/**
	 * Constructs the new widget.
	 * 
	 * @param array $args Post type arguments.
	 * 
	 * @since 1.0.0
	 * @access public
	 * 
	 * @return void
	 */
	public function __construct($args = array()) {
		// Prepare options.
		$this->prepare_options($args);
		// Register the post type.
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
	protected function prepare_options($args = array()) {
		
		if ( is_array($args) && !empty($args) ) {

			$post_type = $args['post_type'] ?? '';

			if ( ! $post_type ) {
				return;
			}
			
			foreach($args as $label => $value) {

				$setter = "set_label_{$label}";

				if (method_exists($this, $setter)) {
					$this->{$setter}($value);
					unset($args[$label]);
				}
			}

			foreach($args as $option => $value) {
				if (property_exists($this, $option)) {
					$this->{$option} = $value;
				}
			}
		}
		
		$this->post_type = substr(str_replace([' ', '_'], '-', $this->get_name()), 0, 20);


		if ( ! $this->post_title ) {
			$this->post_title = join( ' ', array_map( 'ucfirst', explode( '-', $this->post_type ) ) );
		}

		if ( method_exists( $this, 'get_title' ) ) {
			$this->post_title = $this->get_title();
		}

		$this->plural_title = csmf_pluralize( $this->post_title );

		if ( method_exists( $this, 'get_plural_title' ) ) {
			$this->plural_title = $this->get_plural_title();
		}

		if ( ! $this->public ) {
			$this->public = true;
		}

		if ( ! $this->publicly_queryable ) {
			$this->publicly_queryable = true;
		}

		if ( ! $this->show_ui ) {
			$this->show_ui = true;
		}

		if ( ! $this->show_in_rest ) {
			$this->show_in_rest = true;
		}

		if ( ! $this->query_var ) {
			$this->query_var = true;
		}

		if ( method_exists( $this, 'get_post_type' ) ) {
			$this->post_type = $this->get_post_type();
		}

		if ( method_exists( $this, 'is_public' ) ) {
			$this->public = $this->is_public();
		}

		if ( method_exists( $this, 'is_publicly_queryable' ) ) {
			$this->publicly_queryable = $this->is_publicly_queryable();
		}

		if ( method_exists( $this, 'is_show_ui' ) ) {
			$this->show_ui = $this->is_show_ui();
		}

		if ( method_exists( $this, 'is_show_in_rest' ) ) {
			$this->show_in_rest = $this->is_show_in_rest();
		}

		if ( method_exists( $this, 'is_query_var' ) ) {
			$this->query_var = $this->is_query_var();
		}

		// Set default labels and must be call before get_options().
		if ( empty( $this->labels )) {
			$this->set_default_labels();
		}

		// Get all options and must be call at the end of all settings.
		$this->options = $this->get_options();
	}

	/**
	 * Registers a post type.
	 *
	 * Note: Post type registrations should not be hooked before the
	 * {@see 'init'} action. Also, any taxonomy connections should be
	 * registered via the `$taxonomies` argument to ensure consistency
	 * when hooks such as {@see 'parse_query'} or {@see 'pre_get_posts'}
	 * are used.
	 *
	 * Post types can support any number of built-in core features such
	 * as meta boxes, custom fields, post thumbnails, post statuses,
	 * comments, and more. See the `$supports` argument for a complete
	 * list of supported features.
	 *
	 * @since 1.0.0
	 *
	 * @global array $wp_post_types List of post types.
	 *
	 * @param string       $post_type Post type key. Must not exceed 20 characters and may only contain
	 *                                lowercase alphanumeric characters, dashes, and underscores. See sanitize_key().
	 * @param array|string $args {
	 *     Array or string of arguments for registering a post type.
	 *
	 *     @type string       $label                           Name of the post type shown in the menu. Usually plural.
	 *                                                         Default is value of $labels['name'].
	 *     @type string[]     $labels                          An array of labels for this post type. If not set, post
	 *                                                         labels are inherited for non-hierarchical types and page
	 *                                                         labels for hierarchical ones. See get_post_type_labels() for a full
	 *                                                         list of supported labels.
	 *     @type string       $description                     A short descriptive summary of what the post type is.
	 *                                                         Default empty.
	 *     @type bool         $public                          Whether a post type is intended for use publicly either via
	 *                                                         the admin interface or by front-end users. While the default
	 *                                                         settings of $exclude_from_search, $publicly_queryable, $show_ui,
	 *                                                         and $show_in_nav_menus are inherited from $public, each does not
	 *                                                         rely on this relationship and controls a very specific intention.
	 *                                                         Default false.
	 *     @type bool         $hierarchical                    Whether the post type is hierarchical (e.g. page). Default false.
	 *     @type bool         $exclude_from_search             Whether to exclude posts with this post type from front end search
	 *                                                         results. Default is the opposite value of $public.
	 *     @type bool         $publicly_queryable              Whether queries can be performed on the front end for the post type
	 *                                                         as part of parse_request(). Endpoints would include:
	 *                                                          * ?post_type={post_type_key}
	 *                                                          * ?{post_type_key}={single_post_slug}
	 *                                                          * ?{post_type_query_var}={single_post_slug}
	 *                                                         If not set, the default is inherited from $public.
	 *     @type bool         $show_ui                         Whether to generate and allow a UI for managing this post type in the
	 *                                                         admin. Default is value of $public.
	 *     @type bool|string  $show_in_menu                    Where to show the post type in the admin menu. To work, $show_ui
	 *                                                         must be true. If true, the post type is shown in its own top level
	 *                                                         menu. If false, no menu is shown. If a string of an existing top
	 *                                                         level menu ('tools.php' or 'edit.php?post_type=page', for example), the
	 *                                                         post type will be placed as a sub-menu of that.
	 *                                                         Default is value of $show_ui.
	 *     @type bool         $show_in_nav_menus               Makes this post type available for selection in navigation menus.
	 *                                                         Default is value of $public.
	 *     @type bool         $show_in_admin_bar               Makes this post type available via the admin bar. Default is value
	 *                                                         of $show_in_menu.
	 *     @type bool         $show_in_rest                    Whether to include the post type in the REST API. Set this to true
	 *                                                         for the post type to be available in the block editor.
	 *     @type string       $rest_base                       To change the base URL of REST API route. Default is $post_type.
	 *     @type string       $rest_namespace                  To change the namespace URL of REST API route. Default is wp/v2.
	 *     @type string       $rest_controller_class           REST API controller class name. Default is 'WP_REST_Posts_Controller'.
	 *     @type string|bool  $autosave_rest_controller_class  REST API controller class name. Default is 'WP_REST_Autosaves_Controller'.
	 *     @type string|bool  $revisions_rest_controller_class REST API controller class name. Default is 'WP_REST_Revisions_Controller'.
	 *     @type bool         $late_route_registration         A flag to direct the REST API controllers for autosave / revisions
	 *                                                         should be registered before/after the post type controller.
	 *     @type int          $menu_position                   The position in the menu order the post type should appear. To work,
	 *                                                         $show_in_menu must be true. Default null (at the bottom).
	 *     @type string       $menu_icon                       The URL to the icon to be used for this menu. Pass a base64-encoded
	 *                                                         SVG using a data URI, which will be colored to match the color scheme
	 *                                                         -- this should begin with 'data:image/svg+xml;base64,'. Pass the name
	 *                                                         of a Dashicons helper class to use a font icon, e.g.
	 *                                                        'dashicons-chart-pie'. Pass 'none' to leave div.wp-menu-image empty
	 *                                                         so an icon can be added via CSS. Defaults to use the posts icon.
	 *     @type string|array $capability_type                 The string to use to build the read, edit, and delete capabilities.
	 *                                                         May be passed as an array to allow for alternative plurals when using
	 *                                                         this argument as a base to construct the capabilities, e.g.
	 *                                                         array('story', 'stories'). Default 'post'.
	 *     @type string[]     $capabilities                    Array of capabilities for this post type. $capability_type is used
	 *                                                         as a base to construct capabilities by default.
	 *                                                         See get_post_type_capabilities().
	 *     @type bool         $map_meta_cap                    Whether to use the internal default meta capability handling.
	 *                                                         Default false.
	 *     @type array|false  $supports                        Core feature(s) the post type supports. Serves as an alias for calling
	 *                                                         add_post_type_support() directly. Core features include 'title',
	 *                                                         'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt',
	 *                                                         'page-attributes', 'thumbnail', 'custom-fields', and 'post-formats'.
	 *                                                         Additionally, the 'revisions' feature dictates whether the post type
	 *                                                         will store revisions, the 'autosave' feature dictates whether the post type
	 *                                                         will be autosaved, and the 'comments' feature dictates whether the
	 *                                                         comments count will show on the edit screen. For backward compatibility reasons,
	 *                                                         adding 'editor' support implies 'autosave' support too. A feature can also be
	 *                                                         specified as an array of arguments to provide additional information
	 *                                                         about supporting that feature.
	 *                                                         Example: `array( 'my_feature', array( 'field' => 'value' ) )`.
	 *                                                         If false, no features will be added.
	 *                                                         Default is an array containing 'title' and 'editor'.
	 *     @type callable     $register_meta_box_cb            Provide a callback function that sets up the meta boxes for the
	 *                                                         edit form. Do remove_meta_box() and add_meta_box() calls in the
	 *                                                         callback. Default null.
	 *     @type string[]     $taxonomies                      An array of taxonomy identifiers that will be registered for the
	 *                                                         post type. Taxonomies can be registered later with register_taxonomy()
	 *                                                         or register_taxonomy_for_object_type().
	 *                                                         Default empty array.
	 *     @type bool|string  $has_archive                     Whether there should be post type archives, or if a string, the
	 *                                                         archive slug to use. Will generate the proper rewrite rules if
	 *                                                         $rewrite is enabled. Default false.
	 *     @type bool|array   $rewrite                         {
	 *         Triggers the handling of rewrites for this post type. To prevent rewrite, set to false.
	 *         Defaults to true, using $post_type as slug. To specify rewrite rules, an array can be
	 *         passed with any of these keys:
	 *
	 *         @type string $slug       Customize the permastruct slug. Defaults to $post_type key.
	 *         @type bool   $with_front Whether the permastruct should be prepended with WP_Rewrite::$front.
	 *                                  Default true.
	 *         @type bool   $feeds      Whether the feed permastruct should be built for this post type.
	 *                                  Default is value of $has_archive.
	 *         @type bool   $pages      Whether the permastruct should provide for pagination. Default true.
	 *         @type int    $ep_mask    Endpoint mask to assign. If not specified and permalink_epmask is set,
	 *                                  inherits from $permalink_epmask. If not specified and permalink_epmask
	 *                                  is not set, defaults to EP_PERMALINK.
	 *     }
	 *     @type string|bool  $query_var                      Sets the query_var key for this post type. Defaults to $post_type
	 *                                                        key. If false, a post type cannot be loaded at
	 *                                                        ?{query_var}={post_slug}. If specified as a string, the query
	 *                                                        ?{query_var_string}={post_slug} will be valid.
	 *     @type bool         $can_export                     Whether to allow this post type to be exported. Default true.
	 *     @type bool         $delete_with_user               Whether to delete posts of this type when deleting a user.
	 *                                                          * If true, posts of this type belonging to the user will be moved
	 *                                                            to Trash when the user is deleted.
	 *                                                          * If false, posts of this type belonging to the user will *not*
	 *                                                            be trashed or deleted.
	 *                                                          * If not set (the default), posts are trashed if post type supports
	 *                                                            the 'author' feature. Otherwise posts are not trashed or deleted.
	 *                                                        Default null.
	 *     @type array        $template                       Array of blocks to use as the default initial state for an editor
	 *                                                        session. Each item should be an array containing block name and
	 *                                                        optional attributes. Default empty array.
	 *     @type string|false $template_lock                  Whether the block template should be locked if $template is set.
	 *                                                        * If set to 'all', the user is unable to insert new blocks,
	 *                                                          move existing blocks and delete blocks.
	 *                                                       * If set to 'insert', the user is able to move existing blocks
	 *                                                         but is unable to insert new blocks and delete blocks.
	 *                                                         Default false.
	 *     @type bool         $_builtin                     FOR INTERNAL USE ONLY! True if this post type is a native or
	 *                                                      "built-in" post_type. Default false.
	 *     @type string       $_edit_link                   FOR INTERNAL USE ONLY! URL segment to use for edit link of
	 *                                                      this post type. Default 'post.php?post=%d'.
	 * }
	 *
	 * @return WP_Post_Type|WP_Error The registered post type object on success,
	 *                               WP_Error object on failure.
	 */
	public function register( $post_type = '', $args = array() ) {

		if ( ! empty( $post_type ) ) {
			$this->post_type = $post_type;
		}

		if ( ! empty( $args ) ) {
			$this->options = $args;
		}

		if ( ! is_array( $this->options ) || empty( $this->options ) ) {
			$this->options = $this->get_options();
		}

		if ( !$this->post_type || strlen( $this->post_type ) < 1 ) {
			return;
		}

		register_post_type( $this->post_type, $this->options );

		flush_rewrite_rules();
	}

	/**
	 * Unregister a post type.
	 *
	 * Cannot be used to unregister built-in post types.
	 *
	 * @since 1.0.0
	 *
	 * @global array $wp_post_types List of post types.
	 *
	 * @param string $post_type Post type to unregister.
	 *
	 * @return true|WP_Error True on success, WP_Error on failure or if the post type doesn't exist.
	 */
	public function unregister( $post_type = '' ) {
		if ( empty( $post_type ) ) {
			$post_type = $this->get_name();
		}

		unregister_post_type( $post_type );
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
