<?php
/**
 * Custom Post PostType file
 *
 * @category   PostType
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation;

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Custom Post post_type class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class DynamicTaxonomy extends Taxonomy {

	/**
	 * Get post type name.
	 *
	 * @return string Custom Posts name.
	 */
	public function get_name() {
		return $this->taxonomy;
	}

	/**
	 * Get object type.
	 *
	 * @return array|string Object type or array of object types with which the taxonomy should be associated..
	 */
	public function get_object_type() {
		return $this->object_type;
	}

	/**
	 * Get taxonomy activation status.
	 *
	 * @return bool  is activate?
	 */
	public static function is_active() {
		return true;
	}

	/**
	 * Get taxonomy title.
	 *
	 * @return string The taxonomy title.
	 */
	public function get_title() {
		return $this->taxonomy_title;
	}

	/**
	 * Get taxonomy title.
	 *
	 * @return string The taxonomy title.
	 */
	public function get_screen() {
		return $this->screen;
	}

	/**
	 * Get taxonomy public status.
	 *
	 * @return bool Is public?
	 */
	public function is_public() {
		return $this->public ?? true;
	}

	/**
	 * Get taxonomy publicly queryable status.
	 *
	 * @return bool Is publickly queryable?
	 */
	public function is_publicly_queryable() {
		return $this->publicly_queryable ?? true;
	}

	/**
	 * Get hierarchical.
	 *
	 * @return bool Is hierarchical?
	 */
	public function is_hierarchical() {
		return $this->hierarchical ?? true;
	}

	/**
	 * Get taxonomy show url status.
	 *
	 * @return bool Is show url?
	 */
	public function is_show_ui() {
		return $this->show_ui ?? true;
	}

	/**
	 * Get taxonomy show in rest status.
	 *
	 * @return bool Is show in rest?
	 */
	public function is_show_in_rest() {
		return $this->show_in_rest ?? true;
	}

	/**
	 * Get taxonomy query var status.
	 *
	 * @return bool Is query var?
	 */
	public function is_query_var() {
		return $this->query_var ?? true;
	}

	/**
	 * Get taxonomy show in rest status.
	 *
	 * @return bool Is show in menu?
	 */
	public function is_show_in_menu() {
		return $this->show_in_menu ?? true;
	}

	/**
	 * Get taxonomy query var status.
	 *
	 * @return bool Is query show in menus?
	 */
	public function is_show_in_nav_menus() {
		return $this->show_in_nav_menus ?? true;
	}
}
