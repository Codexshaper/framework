<?php
/**
 * Levels file
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
 *  Level trait
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Labels {

	/**
	 * An array of labels for this post type. If not set, post labels are inherited
	 * for non-hierarchical types and page labels for hierarchical ones.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @see get_post_type_labels() https://developer.wordpress.org/reference/functions/get_post_type_labels/ for a full list of supported labels.
	 *
	 * @var string[]  The post type labels.
	 */
	protected $labels;

	/**
	 * Get all post type labels.
	 *
	 * Accepted keys of the label array in the post type object:
	 *
	 * - `name` - General name for the post type, usually plural. The same and overridden
	 *          by `$post_type_object->label`. Default is 'PostTypes'.
	 * - `singular_name` - Name for one object of this post type. Default is 'PostType'.
	 * - `add_new` - Label for adding a new item. Default is 'Add New PostType'.
	 * - `add_new_item` - Label for adding a new singular item. Default is 'Add New PostType'.
	 * - `edit_item` - Label for editing a singular item. Default is 'Edit PostType'.
	 * - `new_item` - Label for the new item page title. Default is 'New PostType'.
	 * - `view_item` - Label for viewing a singular item. Default is 'View PostType'.
	 * - `view_items` - Label for viewing post type archives. Default is 'View PostTypes'.
	 * - `search_items` - Label for searching plural items. Default is 'Search PostTypes'.
	 * - `not_found` - Label used when no items are found. Default is 'No posts found'.
	 * - `not_found_in_trash` - Label used when no items are in the Trash. Default is 'No posts found in Trash'.
	 * - `parent_item_colon` - Label used to prefix parents of hierarchical items. Not used on non-hierarchical
	 *                       post types. Default is 'Parent Page:'.
	 * - `all_items` - Label to signify all items in a submenu link. Default is 'All PostTypes'.
	 * - `archives` - Label for archives in nav menus. Default is 'PostType Archives'.
	 * - `attributes` - Label for the attributes meta box. Default is 'PostType Attributes'.
	 * - `insert_into_item` - Label for the media frame button. Default is 'Insert into post''.
	 * - `uploaded_to_this_item` - Label for the media frame filter. Default is 'Uploaded to this post'.
	 * - `featured_image` - Label for the featured image meta box title. Default is 'Featured image'.
	 * - `set_featured_image` - Label for setting the featured image. Default is 'Set featured image'.
	 * - `remove_featured_image` - Label for removing the featured image. Default is 'Remove featured image'.
	 * - `use_featured_image` - Label in the media frame for using a featured image. Default is 'Use as featured image'.
	 * - `menu_name` - Label for the menu name. Default is the same as `name`.
	 * - `filter_items_list` - Label for the table views hidden heading. Default is 'Filter posts list'
	 * - `filter_by_date` - Label for the date filter in list tables. Default is 'Filter by date'.
	 * - `items_list_navigation` - Label for the table pagination hidden heading. Default is 'PostTypes list navigation'
	 * - `items_list` - Label for the table hidden heading. Default is 'PostTypes list'.
	 * - `item_published` - Label used when an item is published. Default is 'PostType published.'
	 * - `item_published_privately` - Label used when an item is published with private visibility.
	 *                              Default is 'PostType published privately.'
	 * - `item_reverted_to_draft` - Label used when an item is switched to a draft.
	 *                            Default is 'PostType reverted to draft.'
	 * - `item_trashed` - Label used when an item is moved to Trash. Default is 'PostType trashed.'
	 * - `item_scheduled` - Label used when an item is scheduled for publishing. Default is 'PostType scheduled.'
	 * - `item_updated` - Label used when an item is updated. Default is 'PostType updated.'
	 * - `item_link` - Title for a navigation link block variation. Default is 'PostType Link'.
	 * - `item_link_description` - Description for a navigation link block variation. Default is 'A link to a post.'
	 *
	 * Above, the first default value is for non-hierarchical post types (like posts)
	 * and the second one is for hierarchical post types (like pages).
	 *
	 * Note: To set labels used in post type admin notices, see the {@see 'post_updated_messages'} filter.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array All post labels.
	 */
	public function get_labels() {
		// return $this->labels;

		$properties = array(
			'name',                 // General name for the post type, usually plural. The same and overridden by $this->label.
			'singular_name', // Name for one object of this post type.
			'add_new', // Label for adding a new item.
			'add_new_item', // Label for adding a new singular item.
			'edit_item', // Label for editing a singular item.
			'new_item', // Label for the new item page title.
			'view_item', // Label for viewing a singular item.
			'view_items', // Label for viewing post type archives.
			'search_items', // Label for searching plural items.
			'not_found', // Label used when no items are found.
			'not_found_in_trash', // Label used when no items are in the Trash.
			'parent_item_colon', // Label used to prefix parents of hierarchical items. Not used on non-hierarchical post types.
			'all_items', // Label to signify all items in a submenu link.
			'archives', // Label for archives in nav menus.
			'attributes', // Label for the attributes meta box.
			'insert_into_item', // Label for the media frame button.
			'uploaded_to_this_item', // Label for the media frame filter.
			'featured_image', // Label for the featured image meta box title.
			'set_featured_image', // Label for setting the featured image.
			'remove_featured_image', // Label for removing the featured image.
			'use_featured_image', // Label in the media frame for using a featured image.
			'menu_name', // Label for the menu name.
			'filter_items_list', // Label for the table views hidden heading.
			'filter_by_date', // Label for the date filter in list tables.
			'items_list_navigation', // Label for the table pagination hidden heading.
			'items_list', // Label for the table hidden heading.
			'item_published', // Label used when an item is published.
			'item_published_privately', // Label used when an item is published with private visibility.
			'item_reverted_to_draft', // Label used when an item is switched to a draft.
			'item_trashed', // Label used when an item is moved to Trash.
			'item_scheduled', // Label used when an item is scheduled for publishing.
			'item_updated', // Label used when an item is updated.
			'item_link', // Title for a navigation link block variation.
			'item_link_description', // Description for a navigation link block variation.
		);

		$labels     = $this->labels;
		$properties = array_merge( $properties, array_keys( $labels ) );

		foreach ( $properties as $property ) {
			$method_name = "get_label_{$property}";
			if ( key_exists( $property, $labels ) && $this->{$method_name}() ) {
				$labels[ $property ] = $this->{$method_name}();
			}
		}

		return $labels;
	}

	/**
	 * Get label name
	 *
	 * @since 1.0.0
	 *
	 * @return PostType The name.
	 */
	public function get_label_name() {
		if ( isset( $this->labels['name'] ) ) {
			return $this->labels['name'];
		}
		return '';
	}

	/**
	 * Get singular_name label
	 *
	 * @since 1.0.0
	 *
	 * @return string The singular_name.
	 */
	public function get_label_singular_name() {
		if ( isset( $this->labels['singular_name'] ) ) {
			return $this->labels['singular_name'];
		}
		return '';
	}

	/**
	 * Get add_new label
	 *
	 * @since 1.0.0
	 *
	 * @return string The add_new.
	 */
	public function get_label_add_new() {
		if ( isset( $this->labels['add_new'] ) ) {
			return $this->labels['add_new'];
		}
		return '';
	}

	/**
	 * Get add_new_item label
	 *
	 * @since 1.0.0
	 *
	 * @return string The add_new_item.
	 */
	public function get_label_add_new_item() {
		if ( isset( $this->labels['add_new_item'] ) ) {
			return $this->labels['add_new_item'];
		}
		return '';
	}

	/**
	 * Get edit_item label
	 *
	 * @since 1.0.0
	 *
	 * @return string The edit_item.
	 */
	public function get_label_edit_item() {
		if ( isset( $this->labels['edit_item'] ) ) {
			return $this->labels['edit_item'];
		}
		return '';
	}

	/**
	 * Get new_item label
	 *
	 * @since 1.0.0
	 *
	 * @return string The new_item.
	 */
	public function get_label_new_item() {
		if ( isset( $this->labels['new_item'] ) ) {
			return $this->labels['new_item'];
		}
		return '';
	}

	/**
	 * Get view_item label
	 *
	 * @since 1.0.0
	 *
	 * @return string The view_item.
	 */
	public function get_label_view_item() {
		if ( isset( $this->labels['view_item'] ) ) {
			return $this->labels['view_item'];
		}
		return '';
	}

	/**
	 * Get view_items label
	 *
	 * @since 1.0.0
	 *
	 * @return string The view_items.
	 */
	public function get_label_view_items() {
		if ( isset( $this->labels['view_items'] ) ) {
			return $this->labels['view_items'];
		}
		return '';
	}

	/**
	 * Get search_items label
	 *
	 * @since 1.0.0
	 *
	 * @return string The search_items.
	 */
	public function get_label_search_items() {
		if ( isset( $this->labels['search_items'] ) ) {
			return $this->labels['search_items'];
		}
		return '';
	}

	/**
	 * Get not_found label
	 *
	 * @since 1.0.0
	 *
	 * @return string The not_found.
	 */
	public function get_label_not_found() {
		if ( isset( $this->labels['not_found'] ) ) {
			return $this->labels['not_found'];
		}
		return '';
	}

	/**
	 * Get not_found_in_trash label
	 *
	 * @since 1.0.0
	 *
	 * @return string The not_found_in_trash.
	 */
	public function get_label_not_found_in_trash() {
		if ( isset( $this->labels['not_found_in_trash'] ) ) {
			return $this->labels['not_found_in_trash'];
		}
		return '';
	}

	/**
	 * Get parent_item_colon label
	 *
	 * @since 1.0.0
	 *
	 * @return string The parent_item_colon.
	 */
	public function get_label_parent_item_colon() {
		if ( isset( $this->labels['parent_item_colon'] ) ) {
			return $this->labels['parent_item_colon'];
		}
		return '';
	}

	/**
	 * Get all_items label
	 *
	 * @since 1.0.0
	 *
	 * @return string The all_items.
	 */
	public function get_label_all_items() {
		if ( isset( $this->labels['all_items'] ) ) {
			return $this->labels['all_items'];
		}
		return '';
	}

	/**
	 * Get archives label
	 *
	 * @since 1.0.0
	 *
	 * @return string The archives.
	 */
	public function get_label_archives() {
		if ( isset( $this->labels['archives'] ) ) {
			return $this->labels['archives'];
		}
		return '';
	}

	/**
	 * Get attributes
	 *
	 * @since 1.0.0
	 *
	 * @return string The attributes.
	 */
	public function get_label_attributes() {
		if ( isset( $this->labels['attributes'] ) ) {
			return $this->labels['attributes'];
		}
		return '';
	}

	/**
	 * Get insert_into_item
	 *
	 * @since 1.0.0
	 *
	 * @return string The insert_into_item.
	 */
	public function get_label_insert_into_item() {
		if ( isset( $this->labels['insert_into_item'] ) ) {
			return $this->labels['insert_into_item'];
		}
		return '';
	}

	/**
	 * Get uploaded_to_this_item label
	 *
	 * @since 1.0.0
	 *
	 * @return string The uploaded_to_this_item.
	 */
	public function get_label_uploaded_to_this_item() {
		if ( isset( $this->labels['uploaded_to_this_item'] ) ) {
			return $this->labels['uploaded_to_this_item'];
		}
		return '';
	}

	/**
	 * Get featured_image label
	 *
	 * @since 1.0.0
	 *
	 * @return string The featured_image.
	 */
	public function get_label_featured_image() {
		if ( isset( $this->labels['featured_image'] ) ) {
			return $this->labels['featured_image'];
		}
		return '';
	}

	/**
	 * Get get_featured_image label
	 *
	 * @since 1.0.0
	 *
	 * @return string The get_featured_image.
	 */
	public function get_label_get_featured_image() {
		if ( isset( $this->labels['get_featured_image'] ) ) {
			return $this->labels['get_featured_image'];
		}
		return '';
	}

	/**
	 * Get remove_featured_image
	 *
	 * @since 1.0.0
	 *
	 * @return string The remove_featured_image.
	 */
	public function get_label_remove_featured_image() {
		if ( isset( $this->labels['remove_featured_image'] ) ) {
			return $this->labels['remove_featured_image'];
		}
		return '';
	}

	/**
	 * Get use_featured_image label
	 *
	 * @since 1.0.0
	 *
	 * @return string The use_featured_image.
	 */
	public function get_label_use_featured_image() {
		if ( isset( $this->labels['use_featured_image'] ) ) {
			return $this->labels['use_featured_image'];
		}
		return '';
	}

	/**
	 * Get menu_name label.
	 *
	 * @since 1.0.0
	 *
	 * @return string The menu_name.
	 */
	public function get_label_menu_name() {
		if ( isset( $this->labels['menu_name'] ) ) {
			return $this->labels['menu_name'];
		}
		return '';
	}

	/**
	 * Get filter_items_list label
	 *
	 * @since 1.0.0
	 *
	 * @return string The filter_items_list.
	 */
	public function get_label_filter_items_list() {
		if ( isset( $this->labels['filter_items_list'] ) ) {
			return $this->labels['filter_items_list'];
		}
		return '';
	}

	/**
	 * Set label for the date filter in list tables.
	 *
	 * @since 1.0.0
	 *
	 * @return string The filter_by_date.
	 */
	public function get_label_filter_by_date() {
		if ( isset( $this->labels['filter_by_date'] ) ) {
			return $this->labels['filter_by_date'];
		}
		return '';
	}

	/**
	 * Get items_list_navigation label
	 *
	 * @since 1.0.0
	 *
	 * @return string The items_list_navigation.
	 */
	public function get_label_items_list_navigation() {
		if ( isset( $this->labels['items_list_navigation'] ) ) {
			return $this->labels['items_list_navigation'];
		}
		return '';
	}

	/**
	 * Get items_list label
	 *
	 * @since 1.0.0
	 *
	 * @return string The items_list.
	 */
	public function get_label_items_list() {
		if ( isset( $this->labels['items_list'] ) ) {
			return $this->labels['items_list'];
		}
		return '';
	}

	/**
	 * Get item_published label
	 *
	 * @since 1.0.0
	 *
	 * @return string The item_published.
	 */
	public function get_label_item_published() {
		if ( isset( $this->labels['item_published'] ) ) {
			return $this->labels['item_published'];
		}
		return '';
	}

	/**
	 * Set label used when an item is published with private visibility.
	 *
	 * @since 1.0.0
	 *
	 * @return string The item_published_privately.
	 */
	public function get_label_item_published_privately() {
		if ( isset( $this->labels['item_published_privately'] ) ) {
			return $this->labels['item_published_privately'];
		}
		return '';
	}

	/**
	 * Set label used when an item is switched to a draft.
	 *
	 * @since 1.0.0
	 *
	 * @return string The item_reverted_to_draft.
	 */
	public function get_label_item_reverted_to_draft() {
		if ( isset( $this->labels['item_reverted_to_draft'] ) ) {
			return $this->labels['item_reverted_to_draft'];
		}
		return '';
	}

	/**
	 * Set label used when an item is moved to Trash.
	 *
	 * @since 1.0.0
	 *
	 * @return string The item_trashed.
	 */
	public function get_label_item_trashed() {
		if ( isset( $this->labels['item_trashed'] ) ) {
			return $this->labels['item_trashed'];
		}
		return '';
	}

	/**
	 * Set label used when an item is scheduled for publishing.
	 *
	 * @since 1.0.0
	 *
	 * @return string The item_scheduled.
	 */
	public function get_label_item_scheduled() {
		if ( isset( $this->labels['item_scheduled'] ) ) {
			return $this->labels['item_scheduled'];
		}
		return '';
	}

	/**
	 * Set label used when an item is updated.
	 *
	 * @since 1.0.0
	 *
	 * @return string The item_updated.
	 */
	public function get_label_item_updated() {
		if ( isset( $this->labels['item_updated'] ) ) {
			return $this->labels['item_updated'];
		}
		return '';
	}

	/**
	 * Set Title for a navigation link block variation.
	 *
	 * @since 1.0.0
	 *
	 * @return string The item link.
	 */
	public function get_label_item_link() {
		if ( isset( $this->labels['item_link'] ) ) {
			return $this->labels['item_link'];
		}
		return '';
	}

	/**
	 * Set Description for a navigation link block variation.
	 *
	 * @since 1.0.0
	 *
	 * @return string The item link description.
	 */
	public function get_label_item_link_description() {
		if ( isset( $this->labels['item_link_description'] ) ) {
			return $this->labels['item_link_description'];
		}
		return '';
	}

	/**
	 * Set Default levels.
	 *
	 * @since 1.0.0
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_default_labels() {
		$name = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html_x( '%s', 'Post Type General Name', 'codexshaper-framework' ),
			$this->plural_title
		);
		$singular_name = sprintf(
			/* translators: %s: Singular name of the post type. */
			esc_html_x( '%s', 'Post Type Singular Name', 'codexshaper-framework' ),
			$this->plural_title
		);
		$add_new = sprintf(
			/* translators: %s: Label of the add new. */
			esc_html__( 'Add New %s', 'codexshaper-framework' ),
			$this->post_title
		);
		$add_new_item = sprintf(
			/* translators: %s: Label for adding a new singular item. */
			esc_html__( 'Add New %s', 'codexshaper-framework' ),
			$this->post_title
		);

		$edit_item = sprintf(
			/* translators: %s: Label for editing a singular item. */
			esc_html__( 'Edit %s', 'codexshaper-framework' ),
			$this->post_title
		);
		$new_item = sprintf(
			/* translators: %s: Label for the new item page title. */
			esc_html__( 'New %s', 'codexshaper-framework' ),
			$this->post_title
		);
		$view_item = sprintf(
			/* translators: %s: Label for viewing a singular item. */
			esc_html__( 'View %s', 'codexshaper-framework' ),
			$this->post_title
		);
		$view_items = sprintf(
			/* translators: %s: Label for viewing post type archives. */
			esc_html__( 'View %s', 'codexshaper-framework' ),
			$this->plural_title
		);
		$search_items = sprintf(
			/* translators: %s: Label for searching plural items. */
			esc_html__( 'Search %s', 'codexshaper-framework' ),
			$this->plural_title
		);
		$not_found = sprintf(
			/* translators: %s: Label used when no items are found. */
			esc_html__( 'No %s found', 'codexshaper-framework' ),
			$this->plural_title
		);
		$not_found_in_trash = sprintf(
			/* translators: %s: Label used when no items are in the Trash. */
			esc_html__( 'No %s found in Trash', 'codexshaper-framework' ),
			$this->plural_title
		);
		$all_items = sprintf(
			/* translators: %s: Label to signify all items in a submenu link. */
			esc_html__( 'All %s', 'codexshaper-framework' ),
			$this->plural_title
		);
		$archives = sprintf(
			/* translators: %s: Label for archives in nav menus. */
			esc_html__( '%s Archives', 'codexshaper-framework' ),
			$this->post_title
		);
		$attributes = sprintf(
			/* translators: %s: Label for the attributes meta box. */
			esc_html__( '%s Attributes', 'codexshaper-framework' ),
			$this->post_title
		);
		$insert_into_item = sprintf(
			/* translators: %s: Label for the media frame button. */
			esc_html__( 'Insert into %s', 'codexshaper-framework' ),
			$this->post_title
		);
		$uploaded_to_this_item = sprintf(
			/* translators: %s: Label for the media frame filter. */
			esc_html__( 'Uploaded to this %s', 'codexshaper-framework' ),
			$this->post_title
		);
		$menu_name = sprintf(
			/* translators: %s: Label for the menu name. */
			esc_html__( '%s', 'codexshaper-framework' ),
			$this->plural_title
		);
		$filter_items_list = sprintf(
			/* translators: %s: Label for the table views hidden heading. */
			esc_html__( 'Filter %s list', 'codexshaper-framework' ),
			$this->plural_title
		);
		$items_list_navigation = sprintf(
			/* translators: %s: Label for the table pagination hidden heading. */
			esc_html__( '%s list navigation', 'codexshaper-framework' ),
			$this->plural_title
		);
		$items_list = sprintf(
			/* translators: %s: Label for the table hidden heading. */
			esc_html__( '%s list', 'codexshaper-framework' ),
			$this->plural_title
		);
		$item_published = sprintf(
			/* translators: %s: Label used when an item is published. */
			esc_html__( '%s published', 'codexshaper-framework' ),
			$this->post_title
		);
		$item_published_privately = sprintf(
			/* translators: %s: Label used when an item is published with private visibility. */
			esc_html__( '%s published privately.', 'codexshaper-framework' ),
			$this->post_title
		);
		$item_reverted_to_draft = sprintf(
			/* translators: %s: Label used when an item is switched to a draft. */
			esc_html__( '%s reverted to draft.', 'codexshaper-framework' ),
			$this->post_title
		);
		$item_trashed = sprintf(
			/* translators: %s: Label used when an item is moved to Trash. */
			esc_html__( '%s trashed', 'codexshaper-framework' ),
			$this->post_title
		);
		$item_scheduled = sprintf(
			/* translators: %s: Label used when an item is scheduled for publishing. */
			esc_html__( '%s scheduled', 'codexshaper-framework' ),
			$this->post_title
		);
		$item_updated = sprintf(
			/* translators: %s: Label used when an item is updated. */
			esc_html__( '%s updated', 'codexshaper-framework' ),
			$this->post_title
		);
		$item_link = sprintf(
			/* translators: %s: Title for a navigation link block variation. */
			esc_html__( '%s Link', 'codexshaper-framework' ),
			$this->post_title
		);
		$item_link_description = sprintf(
			/* translators: %s: Description for a navigation link block variation. */
			esc_html__( 'A link to a %s', 'codexshaper-framework' ),
			$this->post_title
		);

		$this->labels = array(
			'name'                     => $name, // General name for the post type, usually plural. The same and overridden by $this->label.
			'singular_name'            => $singular_name, // Name for one object of this post type.
			'add_new'                  => $add_new, // Label for adding a new item.
			'add_new_item'             => $add_new_item, // Label for adding a new singular item.
			'edit_item'                => $edit_item, // Label for editing a singular item.
			'new_item'                 => $new_item, // Label for the new item page title.
			'view_item'                => $view_item, // Label for viewing a singular item.
			'view_items'               => $view_items, // Label for viewing post type archives.
			'search_items'             => $search_items, // Label for searching plural items.
			'not_found'                => $not_found, // Label used when no items are found.
			'not_found_in_trash'       => $not_found_in_trash, // Label used when no items are in the Trash.
			'parent_item_colon'        => esc_html__( 'Parent Page:', 'codexshaper-framework' ), // Label used to prefix parents of hierarchical items. Not used on non-hierarchical post types.
			'all_items'                => $all_items, // Label to signify all items in a submenu link.
			'archives'                 => $archives, // Label for archives in nav menus.
			'attributes'               => $attributes, // Label for the attributes meta box.
			'insert_into_item'         => $insert_into_item, // Label for the media frame button.
			'uploaded_to_this_item'    => $uploaded_to_this_item, // Label for the media frame filter.
			'featured_image'           => esc_html__( 'Featured image', 'codexshaper-framework' ), // Label for the featured image meta box title.
			'set_featured_image'       => esc_html__( 'Set featured image', 'codexshaper-framework' ), // Label for setting the featured image.
			'remove_featured_image'    => esc_html__( 'Remove featured image', 'codexshaper-framework' ), // Label for removing the featured image.
			'use_featured_image'       => esc_html__( 'Use as featured image', 'codexshaper-framework' ), // Label in the media frame for using a featured image.
			'menu_name'                => $menu_name, // Label for the menu name.
			'filter_items_list'        => $filter_items_list, // Label for the table views hidden heading.
			'filter_by_date'           => esc_html__( 'Filter by date', 'codexshaper-framework' ), // Label for the date filter in list tables.
			'items_list_navigation'    => $items_list_navigation, // Label for the table pagination hidden heading.
			'items_list'               => $items_list, // Label for the table hidden heading.
			'item_published'           => $item_published, // Label used when an item is published.
			'item_published_privately' => $item_published_privately, // Label used when an item is published with private visibility.
			'item_reverted_to_draft'   => $item_reverted_to_draft, // Label used when an item is switched to a draft.
			'item_trashed'             => $item_trashed, // Label used when an item is moved to Trash.
			'item_scheduled'           => $item_scheduled, // Label used when an item is scheduled for publishing.
			'item_updated'             => $item_updated, // Label used when an item is updated.
			'item_link'                => $item_link, // Title for a navigation link block variation.
			'item_link_description'    => $item_link_description, // Description for a navigation link block variation.
		);

		return $this;
	}

	/**
	 * General name for the post type, usually plural. The same and overridden by $this->label.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name post type label name.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_name( $name ) {
		if ( $name ) {
			$this->labels['name'] = $name;
		}

		return $this;
	}

	/**
	 * Set name for one object of this post type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $singular_name PostType label singular name.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_singular_name( $singular_name ) {
		if ( $singular_name ) {
			$this->labels['singular_name'] = $singular_name;
		}

		return $this;
	}

	/**
	 * Set label for adding a new item.
	 *
	 * @since 1.0.0
	 *
	 * @param string $add_new PostType label add new.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_add_new( $add_new ) {
		if ( $add_new ) {
			$this->labels['add_new'] = $add_new;
		}

		return $this;
	}

	/**
	 * Set label for adding a new singular item.
	 *
	 * @since 1.0.0
	 *
	 * @param string $add_new_item PostType label add new item.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_add_new_item( $add_new_item ) {
		if ( $add_new_item ) {
			$this->labels['add_new_item'] = $add_new_item;
		}

		return $this;
	}

	/**
	 * Set label for editing a singular item.
	 *
	 * @since 1.0.0
	 *
	 * @param string $edit_item PostType label edit item.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_edit_item( $edit_item ) {
		if ( $edit_item ) {
			$this->labels['edit_item'] = $edit_item;
		}

		return $this;
	}

	/**
	 * Set label for the new item page title.
	 *
	 * @since 1.0.0
	 *
	 * @param string $new_item PostType label new item.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_new_item( $new_item ) {
		if ( $new_item ) {
			$this->labels['new_item'] = $new_item;
		}

		return $this;
	}

	/**
	 * Set label for viewing a singular item.
	 *
	 * @since 1.0.0
	 *
	 * @param string $view_item PostType label view item.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_view_item( $view_item ) {
		if ( $view_item ) {
			$this->labels['view_item'] = $view_item;
		}

		return $this;
	}

	/**
	 * Set label for searching plural items.
	 *
	 * @since 1.0.0
	 *
	 * @param string $search_items PostType label search items.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_search_items( $search_items ) {
		if ( $search_items ) {
			$this->labels['search_items'] = $search_items;
		}

		return $this;
	}

	/**
	 * Set label used when no items are found.
	 *
	 * @since 1.0.0
	 *
	 * @param string $not_found PostType label not found.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_not_found( $not_found ) {
		if ( $not_found ) {
			$this->labels['not_found'] = $not_found;
		}

		return $this;
	}

	/**
	 * Set label used when no items are in the Trash.
	 *
	 * @since 1.0.0
	 *
	 * @param string $not_found_in_trash PostType label not found in trash.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_not_found_in_trash( $not_found_in_trash ) {
		if ( $not_found_in_trash ) {
			$this->labels['not_found_in_trash'] = $not_found_in_trash;
		}

		return $this;
	}

	/**
	 * Set label used to prefix parents of hierarchical items. Not used on non-hierarchical post types.
	 *
	 * @since 1.0.0
	 *
	 * @param string $parent_item_colon PostType label parent item colon.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_parent_item_colon( $parent_item_colon ) {
		if ( $parent_item_colon ) {
			$this->labels['parent_item_colon'] = $parent_item_colon;
		}

		return $this;
	}

	/**
	 * Set label to signify all items in a submenu link.
	 *
	 * @since 1.0.0
	 *
	 * @param string $all_items PostType label all items.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_all_items( $all_items ) {
		if ( $all_items ) {
			$this->labels['all_items'] = $all_items;
		}

		return $this;
	}

	/**
	 * Set label for archives in nav menus.
	 *
	 * @since 1.0.0
	 *
	 * @param string $archives PostType label archives.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_archives( $archives ) {
		if ( $archives ) {
			$this->labels['archives'] = $archives;
		}

		return $this;
	}

	/**
	 * Set label for the attributes meta box.
	 *
	 * @since 1.0.0
	 *
	 * @param string $attributes PostType label attributes.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_attributes( $attributes ) {
		if ( $attributes ) {
			$this->labels['attributes'] = $attributes;
		}

		return $this;
	}

	/**
	 * Set label for the media frame button.
	 *
	 * @since 1.0.0
	 *
	 * @param string $insert_into_item PostType label insert into item.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_insert_into_item( $insert_into_item ) {
		if ( $insert_into_item ) {
			$this->labels['insert_into_item'] = $insert_into_item;
		}

		return $this;
	}

	/**
	 * Set label for the media frame filter.
	 *
	 * @since 1.0.0
	 *
	 * @param string $uploaded_to_this_item PostType label uploaded to this item.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_uploaded_to_this_item( $uploaded_to_this_item ) {
		if ( $uploaded_to_this_item ) {
			$this->labels['uploaded_to_this_item'] = $uploaded_to_this_item;
		}

		return $this;
	}

	/**
	 * Set label for the featured image meta box title.
	 *
	 * @since 1.0.0
	 *
	 * @param string $featured_image PostType label featured image.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_featured_image( $featured_image ) {
		if ( $featured_image ) {
			$this->labels['featured_image'] = $featured_image;
		}

		return $this;
	}

	/**
	 * Set label for setting the featured image.
	 *
	 * @since 1.0.0
	 *
	 * @param string $set_featured_image PostType label set featured image.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_set_featured_image( $set_featured_image ) {
		if ( $set_featured_image ) {
			$this->labels['set_featured_image'] = $set_featured_image;
		}

		return $this;
	}

	/**
	 * Set label for removing the featured image.
	 *
	 * @since 1.0.0
	 *
	 * @param string $remove_featured_image PostType label remove featured image.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_remove_featured_image( $remove_featured_image ) {
		if ( $remove_featured_image ) {
			$this->labels['remove_featured_image'] = $remove_featured_image;
		}

		return $this;
	}

	/**
	 * Set label in the media frame for using a featured image.
	 *
	 * @since 1.0.0
	 *
	 * @param string $use_featured_image PostType label use_featured_image.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_use_featured_image( $use_featured_image ) {
		if ( $use_featured_image ) {
			$this->labels['use_featured_image'] = $use_featured_image;
		}

		return $this;
	}

	/**
	 * Set label for the menu name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $menu_name PostType label menu_name.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_menu_name( $menu_name ) {
		if ( $menu_name ) {
			$this->labels['menu_name'] = $menu_name;
		}

		return $this;
	}

	/**
	 * Set label for the table views hidden heading.
	 *
	 * @since 1.0.0
	 *
	 * @param string $filter_items_list PostType label filter_items_list.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_filter_items_list( $filter_items_list ) {
		if ( $filter_items_list ) {
			$this->labels['filter_items_list'] = $filter_items_list;
		}

		return $this;
	}

	/**
	 * Set label for the date filter in list tables.
	 *
	 * @since 1.0.0
	 *
	 * @param string $filter_by_date PostType label filter_by_date.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_filter_by_date( $filter_by_date ) {
		if ( $filter_by_date ) {
			$this->labels['filter_by_date'] = $filter_by_date;
		}

		return $this;
	}

	/**
	 * Set label for the table pagination hidden heading.
	 *
	 * @since 1.0.0
	 *
	 * @param string $items_list_navigation PostType label items_list_navigation.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_items_list_navigation( $items_list_navigation ) {
		if ( $items_list_navigation ) {
			$this->labels['items_list_navigation'] = $items_list_navigation;
		}

		return $this;
	}

	/**
	 * Set label for the table hidden heading.
	 *
	 * @since 1.0.0
	 *
	 * @param string $items_list PostType label items_list.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_items_list( $items_list ) {
		if ( $items_list ) {
			$this->labels['items_list'] = $items_list;
		}

		return $this;
	}

	/**
	 * Set label used when an item is published.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_published PostType label item_published.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_item_published( $item_published ) {
		if ( $item_published ) {
			$this->labels['item_published'] = $item_published;
		}
		return $this;
	}

	/**
	 * Set label used when an item is published with private visibility.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_published_privately PostType label item_published_privately.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_item_published_privately( $item_published_privately ) {
		if ( $item_published_privately ) {
			$this->labels['item_published_privately'] = $item_published_privately;
		}
		return $this;
	}

	/**
	 * Set label used when an item is switched to a draft.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_reverted_to_draft PostType label item_reverted_to_draft.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_item_reverted_to_draft( $item_reverted_to_draft ) {
		if ( $item_reverted_to_draft ) {
			$this->labels['item_reverted_to_draft'] = $item_reverted_to_draft;
		}
		return $this;
	}

	/**
	 * Set label used when an item is moved to Trash.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_trashed PostType label item_trashed.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_item_trashed( $item_trashed ) {
		if ( $item_trashed ) {
			$this->labels['item_trashed'] = $item_trashed;
		}
		return $this;
	}

	/**
	 * Set label used when an item is scheduled for publishing.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_scheduled PostType label item_scheduled.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_item_scheduled( $item_scheduled ) {
		if ( $item_scheduled ) {
			$this->labels['item_scheduled'] = $item_scheduled;
		}
		return $this;
	}

	/**
	 * Set label used when an item is updated.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_updated PostType label item_updated.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_item_updated( $item_updated ) {
		if ( $item_updated ) {
			$this->labels['item_updated'] = $item_updated;
		}
		return $this;
	}

	/**
	 * Set Title for a navigation link block variation.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_link PostType label item_link.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_item_link( $item_link ) {
		if ( $item_link ) {
			$this->labels['item_link'] = $item_link;
		}

		return $this;
	}

	/**
	 * Set Description for a navigation link block variation.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_link_description The label item_link_description.
	 *
	 * @return PostType The instance of the current object.
	 */
	public function set_label_item_link_description( $item_link_description ) {
		if ( $item_link_description ) {
			$this->labels['item_link_description'] = $item_link_description;
		}

		return $this;
	}
}
