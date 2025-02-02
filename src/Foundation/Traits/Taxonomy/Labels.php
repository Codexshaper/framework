<?php
/**
 * Taxonomy Labels Trait file
 *
 * @category   Taxonomy
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Traits\Taxonomy;

/**
 * Taxonomy Labels trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Labels {


	/**
	 * An array of labels for this taxonomy. By default, Tag labels are used for non-hierarchical taxonomies,
	 * and Category labels are used for hierarchical taxonomies. See accepted values in get_taxonomy_labels() .
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @see get_taxonomy_labels() https://developer.wordpress.org/reference/functions/get_taxonomy_labels/ for a full list of supported labels.
	 *
	 * @var string[]  The taxonomoy labels.
	 */
	protected $labels;

	/**
	 * Builds an object with all taxonomy labels out of a taxonomy object.
	 *
	 * @since 3.0.0
	 * @since 4.3.0 Added the `no_terms` label.
	 * @since 4.4.0 Added the `items_list_navigation` and `items_list` labels.
	 * @since 4.9.0 Added the `most_used` and `back_to_items` labels.
	 * @since 5.7.0 Added the `filter_by_item` label.
	 * @since 5.8.0 Added the `item_link` and `item_link_description` labels.
	 * @since 5.9.0 Added the `name_field_description`, `slug_field_description`,
	 *              `parent_field_description`, and `desc_field_description` labels.
	 * @since 6.6.0 Added the `template_name` label.
	 *
	 * @return object {
	 *     Taxonomy labels object. The first default value is for non-hierarchical taxonomies
	 *     (like tags) and the second one is for hierarchical taxonomies (like categories).
	 *
	 *     @type string $name                       General name for the taxonomy, usually plural. The same
	 *                                              as and overridden by `$tax->label`. Default 'Tags'/'Categories'.
	 *     @type string $singular_name              Name for one object of this taxonomy. Default 'Tag'/'Category'.
	 *     @type string $search_items               Default 'Search Tags'/'Search Categories'.
	 *     @type string $popular_items              This label is only used for non-hierarchical taxonomies.
	 *                                              Default 'Popular Tags'.
	 *     @type string $all_items                  Default 'All Tags'/'All Categories'.
	 *     @type string $parent_item                This label is only used for hierarchical taxonomies. Default
	 *                                              'Parent Category'.
	 *     @type string $parent_item_colon          The same as `parent_item`, but with colon `:` in the end.
	 *     @type string $name_field_description     Description for the Name field on Edit Tags screen.
	 *                                              Default 'The name is how it appears on your site'.
	 *     @type string $slug_field_description     Description for the Slug field on Edit Tags screen.
	 *                                              Default 'The &#8220;slug&#8221; is the URL-friendly version
	 *                                              of the name. It is usually all lowercase and contains
	 *                                              only letters, numbers, and hyphens'.
	 *     @type string $parent_field_description   Description for the Parent field on Edit Tags screen.
	 *                                              Default 'Assign a parent term to create a hierarchy.
	 *                                              The term Jazz, for example, would be the parent
	 *                                              of Bebop and Big Band'.
	 *     @type string $desc_field_description     Description for the Description field on Edit Tags screen.
	 *                                              Default 'The description is not prominent by default;
	 *                                              however, some themes may show it'.
	 *     @type string $edit_item                  Default 'Edit Tag'/'Edit Category'.
	 *     @type string $view_item                  Default 'View Tag'/'View Category'.
	 *     @type string $update_item                Default 'Update Tag'/'Update Category'.
	 *     @type string $add_new_item               Default 'Add New Tag'/'Add New Category'.
	 *     @type string $new_item_name              Default 'New Tag Name'/'New Category Name'.
	 *     @type string $template_name              Default 'Tag Archives'/'Category Archives'.
	 *     @type string $separate_items_with_commas This label is only used for non-hierarchical taxonomies. Default
	 *                                              'Separate tags with commas', used in the meta box.
	 *     @type string $add_or_remove_items        This label is only used for non-hierarchical taxonomies. Default
	 *                                              'Add or remove tags', used in the meta box when JavaScript
	 *                                              is disabled.
	 *     @type string $choose_from_most_used      This label is only used on non-hierarchical taxonomies. Default
	 *                                              'Choose from the most used tags', used in the meta box.
	 *     @type string $not_found                  Default 'No tags found'/'No categories found', used in
	 *                                              the meta box and taxonomy list table.
	 *     @type string $no_terms                   Default 'No tags'/'No categories', used in the posts and media
	 *                                              list tables.
	 *     @type string $filter_by_item             This label is only used for hierarchical taxonomies. Default
	 *                                              'Filter by category', used in the posts list table.
	 *     @type string $items_list_navigation      Label for the table pagination hidden heading.
	 *     @type string $items_list                 Label for the table hidden heading.
	 *     @type string $most_used                  Title for the Most Used tab. Default 'Most Used'.
	 *     @type string $back_to_items              Label displayed after a term has been updated.
	 *     @type string $item_link                  Used in the block editor. Title for a navigation link block variation.
	 *                                              Default 'Tag Link'/'Category Link'.
	 *     @type string $item_link_description      Used in the block editor. Description for a navigation link block
	 *                                              variation. Default 'A link to a tag'/'A link to a category'.
	 * }
	 */
	function get_labels() {
			return $this->labels;
	}

	/**
	 * Get label name
	 *
	 * @since 1.0.0
	 *
	 * @return Taxonomy The name.
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
	 * Get popular_items label
	 *
	 * @since 1.0.0
	 *
	 * @return string The popular_items.
	 */
	public function get_label_popular_items() {
		if ( isset( $this->labels['popular_items'] ) ) {
			return $this->labels['popular_items'];
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
	 * Get parent_item label
	 *
	 * @since 1.0.0
	 *
	 * @return string The parent_item.
	 */
	public function get_label_parent_item() {
		if ( isset( $this->labels['parent_item'] ) ) {
			return $this->labels['parent_item'];
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
	 * Get name_field_description label
	 *
	 * @since 1.0.0
	 *
	 * @return string The name_field_description.
	 */
	public function get_label_name_field_description() {
		if ( isset( $this->labels['name_field_description'] ) ) {
			return $this->labels['name_field_description'];
		}
		return '';
	}

	/**
	 * Get label slug_field_description
	 *
	 * @since 1.0.0
	 *
	 * @return Taxonomy The slug_field_description.
	 */
	public function get_label_slug_field_description() {
		if ( isset( $this->labels['slug_field_description'] ) ) {
			return $this->labels['slug_field_description'];
		}
		return '';
	}

	/**
	 * Get parent_field_description label
	 *
	 * @since 1.0.0
	 *
	 * @return string The parent_field_description.
	 */
	public function get_label_parent_field_description() {
		if ( isset( $this->labels['parent_field_description'] ) ) {
			return $this->labels['parent_field_description'];
		}
		return '';
	}

	/**
	 * Get desc_field_description label
	 *
	 * @since 1.0.0
	 *
	 * @return string The desc_field_description.
	 */
	public function get_label_desc_field_description() {
		if ( isset( $this->labels['desc_field_description'] ) ) {
			return $this->labels['desc_field_description'];
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
	 * Get update_item label
	 *
	 * @since 1.0.0
	 *
	 * @return string The update_item.
	 */
	public function get_label_update_item() {
		if ( isset( $this->labels['update_item'] ) ) {
			return $this->labels['update_item'];
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
	 * Get new_item_name label
	 *
	 * @since 1.0.0
	 *
	 * @return string The new_item_name.
	 */
	public function get_label_new_item_name() {
		if ( isset( $this->labels['new_item_name'] ) ) {
			return $this->labels['new_item_name'];
		}
		return '';
	}

	/**
	 * Get label template_name
	 *
	 * @since 1.0.0
	 *
	 * @return Taxonomy The template_name.
	 */
	public function get_label_template_name() {
		if ( isset( $this->labels['template_name'] ) ) {
			return $this->labels['template_name'];
		}
		return '';
	}

	/**
	 * Get separate_items_with_commas label
	 *
	 * @since 1.0.0
	 *
	 * @return string The separate_items_with_commas.
	 */
	public function get_label_separate_items_with_commas() {
		if ( isset( $this->labels['separate_items_with_commas'] ) ) {
			return $this->labels['separate_items_with_commas'];
		}
		return '';
	}

	/**
	 * Get add_or_remove_items label
	 *
	 * @since 1.0.0
	 *
	 * @return string The add_or_remove_items.
	 */
	public function get_label_add_or_remove_items() {
		if ( isset( $this->labels['add_or_remove_items'] ) ) {
			return $this->labels['add_or_remove_items'];
		}
		return '';
	}

	/**
	 * Get choose_from_most_used label
	 *
	 * @since 1.0.0
	 *
	 * @return string The choose_from_most_used.
	 */
	public function get_label_choose_from_most_used() {
		if ( isset( $this->labels['choose_from_most_used'] ) ) {
			return $this->labels['choose_from_most_used'];
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
	 * Get no_terms label
	 *
	 * @since 1.0.0
	 *
	 * @return string The no_terms.
	 */
	public function get_label_no_terms() {
		if ( isset( $this->labels['no_terms'] ) ) {
			return $this->labels['no_terms'];
		}
		return '';
	}

	/**
	 * Get filter_by_item label
	 *
	 * @since 1.0.0
	 *
	 * @return string The filter_by_item.
	 */
	public function get_label_filter_by_item() {
		if ( isset( $this->labels['filter_by_item'] ) ) {
			return $this->labels['filter_by_item'];
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
	 * Get label items_list
	 *
	 * @since 1.0.0
	 *
	 * @return Taxonomy The items_list.
	 */
	public function get_label_items_list() {
		if ( isset( $this->labels['items_list'] ) ) {
			return $this->labels['items_list'];
		}
		return '';
	}

	/**
	 * Get most_used label
	 *
	 * @since 1.0.0
	 *
	 * @return string The most_used.
	 */
	public function get_label_most_used() {
		if ( isset( $this->labels['most_used'] ) ) {
			return $this->labels['most_used'];
		}
		return '';
	}

	/**
	 * Get back_to_items label
	 *
	 * @since 1.0.0
	 *
	 * @return string The back_to_items.
	 */
	public function get_label_back_to_items() {
		if ( isset( $this->labels['back_to_items'] ) ) {
			return $this->labels['back_to_items'];
		}
		return '';
	}

	/**
	 * Get item_link label
	 *
	 * @since 1.0.0
	 *
	 * @return string The item_link.
	 */
	public function get_label_item_link() {
		if ( isset( $this->labels['item_link'] ) ) {
			return $this->labels['item_link'];
		}
		return '';
	}

	/**
	 * Get item_link_description label
	 *
	 * @since 1.0.0
	 *
	 * @return string The item_link_description.
	 */
	public function get_label_item_link_description() {
		if ( isset( $this->labels['item_link_description'] ) ) {
			return $this->labels['item_link_description'];
		}
		return '';
	}

	public function set_default_labels() {

		$name = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html_x( '%s', 'taxonomy general name', 'codexshaper-framework' ),
			$this->plural_title
		);

		$singular_name = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html_x( '%s', 'taxonomy singular name', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$search_items = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Search %s', 'codexshaper-framework' ),
			$this->plural_title
		);

		$popular_items = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Popular %s', 'codexshaper-framework' ),
			$this->plural_title
		);

		$all_items = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'All %s', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$parent_item = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Parent %s', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$parent_item_colon = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Parent %s:', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$edit_item = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Edit %s', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$view_item = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'View %s', 'codexshaper-framework' ),
			$this->plural_title
		);

		$update_item = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Update %s', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$add_new_item = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Add New %s', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$new_item_name = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'New %s Name', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$template_name = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( '%s Archives', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$separate_items_with_commas = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Separate %s with commas', 'codexshaper-framework' ),
			$this->plural_title
		);

		$add_or_remove_items = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Add or remove %s', 'codexshaper-framework' ),
			$this->plural_title
		);

		$choose_from_most_used = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Choose from the most used %s', 'codexshaper-framework' ),
			$this->plural_title
		);

		$not_found = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'No %s found', 'codexshaper-framework' ),
			$this->plural_title
		);

		$no_terms = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'No %s', 'codexshaper-framework' ),
			$this->plural_title
		);

		$filter_by_item = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'Filter by %s', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$items_list_navigation = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( '%s list navigation', 'codexshaper-framework' ),
			$this->plural_title
		);

		$items_list = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( '%s list', 'codexshaper-framework' ),
			$this->plural_title
		);

		$back_to_items = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( '%s term has been updated.', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$item_link = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( '%s Link', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$item_link_description = sprintf(
			/* translators: %s: Name of the post type. */
			esc_html__( 'A link to a single %s.', 'codexshaper-framework' ),
			$this->taxonomy_title
		);

		$this->labels = array(
			'name'                       => $name, // General name for the taxonomy, usually plural. The same as and overridden by $tax->label. Default 'Tags'/'Categories'.
			'singular_name'              => $singular_name, // Name for one object of this taxonomy. Default 'Tag'/'Category'.
			'search_items'               => $search_items, // Default ‘Search Tags'/'Search Categories’.
			'popular_items'              => $popular_items, // This label is only used for non-hierarchical taxonomies.
			'all_items'                  => $all_items, // Default ‘All Tags'/'All Categories’.
			'parent_item'                => $parent_item, // This label is only used for hierarchical taxonomies.
			'parent_item_colon'          => $parent_item_colon, // The same as parent_item, but with colon : in the end.
			'name_field_description'     => esc_html__( 'The name is how it appears on your site', 'codexshaper-framework' ), // Description for the Name field on Edit Tags screen.
			'slug_field_description'     => esc_html( 'The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens' ), // Description for the Slug field on Edit Tags screen.
			'parent_field_description'   => esc_html__( 'Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band', 'codexshaper-framework' ), // Description for the Parent field on Edit Tags screen.
			'desc_field_description'     => esc_html__( 'The description is not prominent by default; however, some themes may show it', 'codexshaper-framework' ), // Description for the Description field on Edit Tags screen.
			'edit_item'                  => $edit_item, // Default 'Edit Tag'/'Edit Category'.
			'view_item'                  => $view_item, // Default 'View Tag'/'View Category'.
			'update_item'                => $update_item, // Default 'Update Tag'/'Update Category'.
			'add_new_item'               => $add_new_item, // Default 'Add New Tag'/'Add New Category'.
			'new_item_name'              => $new_item_name, // Default 'New Tag Name'/'New Category Name'.
			'template_name'              => $template_name, // Default 'Tag Archives'/'Category Archives'.
			'separate_items_with_commas' => $separate_items_with_commas, // This label is only used for non-hierarchical taxonomies.
			'add_or_remove_items'        => $add_or_remove_items, // This label is only used for non-hierarchical taxonomies.
			'choose_from_most_used'      => $choose_from_most_used, // This label is only used on non-hierarchical taxonomies.
			'not_found'                  => $not_found, // Default 'No tags found'/'No categories found', used in the meta box and taxonomy list table.
			'no_terms'                   => $no_terms, // Default 'No tags'/'No categories', used in the posts and media list tables.
			'filter_by_item'             => $filter_by_item, // This label is only used for hierarchical taxonomies. Default 'Filter by category', used in the posts list table.
			'items_list_navigation'      => $items_list_navigation, // Label for the table pagination hidden heading.
			'items_list'                 => $items_list, // Label for the table hidden heading.
			'most_used'                  => esc_html__( 'Most Used', 'codexshaper-framework' ), // Title for the Most Used tab. Default 'Most Used'.
			'back_to_items'              => $back_to_items, // Label displayed after a term has been updated.
			'item_link'                  => $item_link, // Used in the block editor. Title for a navigation link block variation.
			'item_link_description'      => $item_link_description, // Used in the block editor. Description for a navigation link block
		);

		return $this;
	}

	/**
	 * Set General name for the taxonomy, usually plural. The same
	 * as and overridden by `$tax->label`. Default 'Tags'/'Categories'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name taxonomoy label name.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_name( $name ) {
		if ( $name ) {
			$this->labels['name'] = $name;
		}
		return $this;
	}

	/**
	 * Set singular_name label. Name for one object of this taxonomy. Default 'Tag'/'Category'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $singular_name Taxonomy label singular name.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_singular_name( $singular_name ) {
		if ( $singular_name ) {
			$this->labels['singular_name'] = $singular_name;
		}
		return $this;
	}

	/**
	 * Set search_items label. Default 'Search Tags'/'Search Categories'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $search_items Taxonomy label search items.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_search_items( $search_items ) {
		if ( $search_items ) {
			$this->labels['search_items'] = $search_items;
		}
		return $this;
	}

	/**
	 * Set popular_items label. This label is only used for non-hierarchical taxonomies.
	 * Default 'Popular Tags'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $popular_items Taxonomy label popular items.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_popular_items( $popular_items ) {
		if ( $popular_items ) {
			$this->labels['popular_items'] = $popular_items;
		}
		return $this;
	}

	/**
	 * Set all_items label Default 'All Tags'/'All Categories'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $all_items Taxonomy label all items.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_all_items( $all_items ) {
		if ( $all_items ) {
			$this->labels['all_items'] = $all_items;
		}
		return $this;
	}

	/**
	 * Set parent_item label. This label is only used for hierarchical taxonomies. Default
	 * 'Parent Category'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $parent_item Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_parent_item( $parent_item ) {
		if ( $parent_item ) {
			$this->labels['parent_item'] = $parent_item;
		}
		return $this;
	}

	/**
	 * Set parent_item_colon label. The same as `parent_item`, but with colon `:` in the end.
	 *
	 * @since 1.0.0
	 *
	 * @param string $parent_item_colon Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_parent_item_colon( $parent_item_colon ) {
		if ( $parent_item_colon ) {
			$this->labels['parent_item_colon'] = $parent_item_colon;
		}
		return $this;
	}

	/**
	 * Set name_field_description label. Description for the Name field on Edit Tags screen.
	 * Default 'The name is how it appears on your site'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name_field_description Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_name_field_description( $name_field_description ) {
		if ( $name_field_description ) {
			$this->labels['name_field_description'] = $name_field_description;
		}
		return $this;
	}

	/**
	 * Set slug_field_description label.
	 *
	 * Description for the Slug field on Edit Tags screen.
	 * Default 'The &#8220;slug&#8221; is the URL-friendly version
	 * of the name. It is usually all lowercase and contains
	 * only letters, numbers, and hyphens'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug_field_description Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_slug_field_description( $slug_field_description ) {
		if ( $slug_field_description ) {
			$this->labels['slug_field_description'] = $slug_field_description;
		}
		return $this;
	}

	/**
	 * Set parent_field_description label.
	 *
	 * Description for the Parent field on Edit Tags screen.
	 * Default 'Assign a parent term to create a hierarchy.
	 * The term Jazz, for example, would be the parent
	 * of Bebop and Big Band'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $parent_field_description taxonomoy label parent_field_description.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_parent_field_description( $parent_field_description ) {
		if ( $parent_field_description ) {
			$this->labels['parent_field_description'] = $parent_field_description;
		}

		return $this;
	}

	/**
	 * Set desc_field_description label.
	 *
	 * Description for the Description field on Edit Tags screen.
	 * Default 'The description is not prominent by default;
	 * however, some themes may show it'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $desc_field_description Taxonomy label singular name.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_desc_field_description( $desc_field_description ) {
		if ( $desc_field_description ) {
			$this->labels['desc_field_description'] = $desc_field_description;
		}
		return $this;
	}

	/**
	 * Set edit_item label.
	 *
	 * Default 'Edit Tag'/'Edit Category'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $edit_item Taxonomy label search items.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_edit_item( $edit_item ) {
		if ( $edit_item ) {
			$this->labels['edit_item'] = $edit_item;
		}
		return $this;
	}

	/**
	 * Set view_item label.
	 *
	 *  Default 'View Tag'/'View Category'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $view_item Taxonomy label popular items.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_view_item( $view_item ) {
		if ( $view_item ) {
			$this->labels['view_item'] = $view_item;
		}
		return $this;
	}

	/**
	 * Set update_item label.
	 *
	 * Default 'Update Tag'/'Update Category'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $update_item Taxonomy label all items.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_update_item( $update_item ) {
		if ( $update_item ) {
			$this->labels['update_item'] = $update_item;
		}
		return $this;
	}

	/**
	 * Set add_new_item label.
	 *
	 *  Default 'Add New Tag'/'Add New Category'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $add_new_item Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_add_new_item( $add_new_item ) {
		if ( $add_new_item ) {
			$this->labels['add_new_item'] = $add_new_item;
		}
		return $this;
	}

	/**
	 * Set new_item_name label.
	 *
	 * Default 'New Tag Name'/'New Category Name'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $new_item_name Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_new_item_name( $new_item_name ) {
		if ( $new_item_name ) {
			$this->labels['new_item_name'] = $new_item_name;
		}
		return $this;
	}

	/**
	 * Set template_name label.
	 *
	 *  Default 'Tag Archives'/'Category Archives'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $template_name Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_template_name( $template_name ) {
		if ( $template_name ) {
			$this->labels['template_name'] = $template_name;
		}
		return $this;
	}

	/**
	 * Set separate_items_with_commas label.
	 *
	 * This label is only used for non-hierarchical taxonomies. Default
	 * 'Separate tags with commas', used in the meta box.
	 *
	 * @since 1.0.0
	 *
	 * @param string $separate_items_with_commas Taxonomy label search items.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_separate_items_with_commas( $separate_items_with_commas ) {
		if ( $separate_items_with_commas ) {
			$this->labels['separate_items_with_commas'] = $separate_items_with_commas;
		}
		return $this;
	}

	/**
	 * Set add_or_remove_items label.
	 *
	 * This label is only used for non-hierarchical taxonomies. Default
	 * 'Add or remove tags', used in the meta box when JavaScript
	 * is disabled.
	 *
	 * @since 1.0.0
	 *
	 * @param string $add_or_remove_items Taxonomy label popular items.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_add_or_remove_items( $add_or_remove_items ) {
		if ( $add_or_remove_items ) {
			$this->labels['add_or_remove_items'] = $add_or_remove_items;
		}
		return $this;
	}

	/**
	 * Set choose_from_most_used label.
	 *
	 * This label is only used on non-hierarchical taxonomies. Default
	 * 'Choose from the most used tags', used in the meta box.
	 *
	 * @since 1.0.0
	 *
	 * @param string $choose_from_most_used Taxonomy label all items.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_choose_from_most_used( $choose_from_most_used ) {
		if ( $choose_from_most_used ) {
			$this->labels['choose_from_most_used'] = $choose_from_most_used;
		}
		return $this;
	}

	/**
	 * Set not_found label.
	 *
	 * Default 'No tags found'/'No categories found', used in
	 * the meta box and taxonomy list table.
	 *
	 * @since 1.0.0
	 *
	 * @param string $not_found Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_not_found( $not_found ) {
		if ( $not_found ) {
			$this->labels['not_found'] = $not_found;
		}
		return $this;
	}

	/**
	 * Set no_terms label.
	 *
	 * Default 'No tags'/'No categories', used in the posts and media list tables.
	 *
	 * @since 1.0.0
	 *
	 * @param string $no_terms Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_no_terms( $no_terms ) {
		if ( $no_terms ) {
			$this->labels['no_terms'] = $no_terms;
		}
		return $this;
	}

	/**
	 * Set filter_by_item label.
	 *
	 * This label is only used for hierarchical taxonomies.
	 *
	 * @since 1.0.0
	 *
	 * @param string $filter_by_item Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_filter_by_item( $filter_by_item ) {
		if ( $filter_by_item ) {
			$this->labels['filter_by_item'] = $filter_by_item;
		}
		return $this;
	}

	/**
	 * Set items_list_navigation label.
	 *
	 * Label for the table pagination hidden heading.
	 *
	 * @since 1.0.0
	 *
	 * @param string $items_list_navigation Taxonomy label all items.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_items_list_navigation( $items_list_navigation ) {
		if ( $items_list_navigation ) {
			$this->labels['items_list_navigation'] = $items_list_navigation;
		}
		return $this;
	}

	/**
	 * Set items_list label.
	 *
	 * Label for the table hidden heading.
	 *
	 * @since 1.0.0
	 *
	 * @param string $items_list Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_items_list( $items_list ) {
		if ( $items_list ) {
			$this->labels['items_list'] = $items_list;
		}
		return $this;
	}

	/**
	 * Set most_used label.
	 *
	 * Title for the Most Used tab. Default 'Most Used'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $most_used Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_most_used( $most_used ) {
		if ( $most_used ) {
			$this->labels['most_used'] = $most_used;
		}
		return $this;
	}

	/**
	 * Set back_to_items label.
	 *
	 * Label displayed after a term has been updated.
	 *
	 * @since 1.0.0
	 *
	 * @param string $back_to_items Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_back_to_items( $back_to_items ) {
		if ( $back_to_items ) {
			$this->labels['back_to_items'] = $back_to_items;
		}
		return $this;
	}

	/**
	 * Set item_link label.
	 *
	 * Used in the block editor. Title for a navigation link block variation.
	 * Default 'Tag Link'/'Category Link'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_link Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_item_link( $item_link ) {
		if ( $item_link ) {
			$this->labels['item_link'] = $item_link;
		}

		return $this;
	}

	/**
	 * Set item_link_description label.
	 *
	 * Used in the block editor. Description for a navigation link block
	 * variation. Default 'A link to a tag'/'A link to a category'.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item_link_description Taxonomy label parent item colon.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	public function set_label_item_link_description( $item_link_description ) {
		if ( $item_link_description ) {
			$this->labels['item_link_description'] = $item_link_description;
		}

		return $this;
	}
}
