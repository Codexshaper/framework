<?php
/**
 * PostType Options Trait file
 *
 * @category   PostType
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Traits\PostType;

/**
 *  PostType Options trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Options {

	use Labels;
	use Capabilities;

	/**
	 * Name of the post type shown in the menu. Usually plural.
	 *
	 * @default $this->labels['name'].
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The post type label.
	 */
	protected $label;

	/**
	 * A short descriptive summary of what the post type is.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The post type short description.
	 */
	protected $description;

	/**
	 * Whether a post type is intended for use publicly either via the admin interface or by front-end users.
	 * While the default settings of $exclude_from_search, $publicly_queryable, $show_ui, and $show_in_nav_menus are
	 * inherited from $public, each does not rely on this relationship and controls a very specific intention.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool  Is public?
	 */
	protected $public = false;

	/**
	 * Whether the post type is hierarchical (e.g. page).
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool  Is hierarchical?
	 */
	protected $hierarchical = false;

	/**
	 * Whether to exclude posts with this post type from front end search results.  Default is the opposite value of $public.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool  Is exclude from search?
	 */
	protected $exclude_from_search;

	/**
	 * Whether queries can be performed on the front end for the post type as part of parse_request().
	 * Endpoints would include: * ?post_type={post_type_key} * ?{post_type_key}={single_post_slug} * ?{post_type_query_var}={single_post_slug}
	 * If not set, the default is inherited from $public.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool  is publicly queryable?
	 */
	protected $publicly_queryable;

	/**
	 * Whether to generate and allow a UI for managing this post type in the admin. Default is value of $public.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool  Is show ui?
	 */
	protected $show_ui;

	/**
	 * Where to show the post type in the admin menu. To work, $show_ui must be true.
	 * If true, the post type is shown in its own top level menu. If false, no menu is shown.
	 * If a string of an existing top level menu ('tools.php' or 'edit.php?post_type=page', for example),
	 * the post type will be placed as a sub-menu of that.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool|string  Is show in menu?
	 */
	protected $show_in_menu;

	/**
	 * Makes this post type available for selection in navigation menus. Default is value of $public.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool  Is show in nav menus?
	 */
	protected $show_in_nav_menus;

	/**
	 * Makes this post type available via the admin bar. Default is value of $show_in_menu.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool|string  Is show in admin bar?
	 */
	protected $show_in_admin_bar;

	/**
	 * Whether to include the post type in the REST API.
	 * Set this to true for the post type to be available in the block editor.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool  Is show in rest?
	 */
	protected $show_in_rest;

	/**
	 * To change the base URL of REST API route. Default is $post_type.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The post type rest base.
	 */
	protected $rest_base;

	/**
	 * To change the namespace URL of REST API route. Default is wp/v2.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The post type rest namespace.
	 */
	protected $rest_namespace = 'wp/v2';

	/**
	 * REST API controller class name. Default is 'WP_REST_Posts_Controller'.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The post type rest controller class.
	 */
	protected $rest_controller_class = 'WP_REST_Posts_Controller';

	/**
	 * REST API controller class name. Default is 'WP_REST_Autosaves_Controller.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string|bool  The post type autosave rest controller class.
	 */
	protected $autosave_rest_controller_class = 'WP_REST_Autosaves_Controller';

	/**
	 * REST API controller class name. Default is 'WP_REST_Revisions_Controller'.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The post type revisions rest controller class.
	 */
	protected $revisions_rest_controller_class = 'WP_REST_Revisions_Controller';

	/**
	 * A flag to direct the REST API controllers for autosave / revisions should be registered before/after the post type controller.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool  Is late route registration?
	 */
	protected $late_route_registration;

	/**
	 * The position in the menu order the post type should appear. To work, $show_in_menu must be true. Default null (at the bottom).
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var int  The post type menu position.
	 */
	protected $menu_position;

	/**
	 * The URL to the icon to be used for this menu.
	 * Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme —
	 * this should begin with 'data:image/svg+xml;base64,'. Pass the name of a Dashicons helper class to use a font icon,
	 * e.g. 'dashicons-chart-pie'. Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
	 * Defaults to use the posts icon.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The post type menu icon.
	 */
	protected $menu_icon;

	/**
	 * Whether to use the internal default meta capability handling.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool  Is map meta cap?
	 */
	protected $map_meta_cap = false;

	/**
	 * supports array|false
	 * Core feature(s) the post type supports. Serves as an alias for calling add_post_type_support() directly.
	 * Core features include 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields', and 'post-formats'.
	 * Additionally, the 'revisions' feature dictates whether the post type will store revisions, the 'autosave' feature
	 * dictates whether the post type will be autosaved, and the 'comments' feature dictates whether the comments count will
	 * show on the edit screen. For backward compatibility reasons, adding 'editor' support implies 'autosave' support too.
	 * A feature can also be specified as an array of arguments to provide additional information about supporting that feature.
	 * Example: array( 'my_feature', array( 'field' => 'value' ) ).
	 * If false, no features will be added.
	 * Default is an array containing 'title' and 'editor'.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @see calling add_post_type_support() https://developer.wordpress.org/reference/functions/add_post_type_support/
	 *
	 * @var array|false  The post type supports.
	 */
	protected $supports = array( 'title', 'editor' );

	/**
	 * Provide a callback function that sets up the meta boxes for the edit form.
	 * Do remove_meta_box() and add_meta_box() calls in the callback. Default null.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @see remove_meta_box() https://developer.wordpress.org/reference/functions/remove_meta_box/
	 * @see add_meta_box() https://developer.wordpress.org/reference/functions/add_meta_box/
	 *
	 * @var callable  The post type register_meta_box_cb.
	 */
	protected $register_meta_box_cb = null;

	/**
	 * An array of taxonomy identifiers that will be registered for the post type.
	 * Taxonomies can be registered later with register_taxonomy() or register_taxonomy_for_object_type().
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @see register_taxonomy() https://developer.wordpress.org/reference/functions/register_taxonomy/
	 * @see register_taxonomy_for_object_type() https://developer.wordpress.org/reference/functions/register_taxonomy_for_object_type/
	 *
	 * @var string[]  The post type taxonomies.
	 */
	protected $taxonomies;

	/**
	 * Whether there should be post type archives, or if a string, the archive slug to use.
	 * Will generate the proper rewrite rules if $rewrite is enabled. Default false.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool|string  has archive?
	 */
	protected $has_archive = false;

	/**
	 * Triggers the handling of rewrites for this post type. To prevent rewrite, set to false.
	 * Defaults to true, using $post_type as slug. To specify rewrite rules, an array can be passed with any of these keys:
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * Triggers the handling of rewrites for this post type. To prevent rewrite, set to false.
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
	 *
	 * @var bool|array  The post type rewrite.
	 */
	protected $rewrite;

	/**
	 * Sets the query_var key for this post type. Defaults to $post_type key.
	 * If false, a post type cannot be loaded at ?{query_var}={post_slug}.
	 * If specified as a string, the query ?{query_var_string}={post_slug} will be valid.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string|bool The post type query var.
	 */
	protected $query_var;

	/**
	 * Works much like a hook, in that it will be called when the count is updated.
	 * Default _update_post_term_count() for taxonomies attached to post types,
	 * which confirms that the objects are published before counting them.
	 * Default _update_generic_term_count() for taxonomies attached to other object types, such as users.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @see _update_post_term_count() https://developer.wordpress.org/reference/functions/_update_post_term_count/
	 * @see _update_generic_term_count() https://developer.wordpress.org/reference/functions/_update_generic_term_count/
	 *
	 * @var callable The taxonomy update count callback.
	 */
	protected $update_count_callback;


	/**
	 * Default term to be used for the taxonomy.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool Is delete with user?
	 */
	protected $default_term;


	/**
	 * Array of blocks to use as the default initial state for an editor session.
	 * Each item should be an array containing block name and optional attributes.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array The post type template.
	 */
	protected $template;


	/**
	 * Whether the block template should be locked if $template is set.
	 * If set to 'all', the user is unable to insert new blocks, move existing blocks and delete blocks.
	 * If set to 'insert', the user is able to move existing blocks but is unable to insert new blocks and delete blocks.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string|false The post type template_lock.
	 */
	protected $template_lock = false;


	/**
	 * Options
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array The post type options.
	 */
	protected $options = array();

	/**
	 * Get the post type label.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string The post label.
	 */
	function get_label() {
		return $this->label;
	}

	/**
	 * Get post type options.
	 *
	 * @return array|string
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
	 */
	public function get_options() {

		$properties = array(
			'label',
			'labels',
			'description',
			'public',
			'hierarchical',
			'exclude_from_search',
			'publicly_queryable',
			'show_ui',
			'show_in_menu',
			'show_in_nav_menus',
			'show_in_admin_bar',
			'show_in_rest',
			'rest_base',
			'rest_namespace',
			'rest_controller_class',
			'autosave_rest_controller_class',
			'revisions_rest_controller_class',
			'late_route_registration',
			'menu_position',
			'menu_icon',
			'capability_type',
			'capabilities',
			'map_meta_cap',
			'supports',
			'register_meta_box_cb',
			'taxonomies',
			'has_archive',
			'rewrite',
			'query_var',
			'can_export',
			'delete_with_user',
			'template',
			'template_lock',
		);

		$options = array();

		foreach ( $properties as $property ) {
			$method_name = "get_{$property}";
			if ( property_exists( $this, $property ) && $this->{$method_name}() ) {
				$options[ $property ] = $this->{$method_name}();
			}
		}

		return $options;
	}
}
