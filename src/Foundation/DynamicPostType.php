<?php
/**
 * Custom Post Type file
 *
 * @category   PostType
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation;

use CodexShaper\Framework\Foundation\PostType;

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Custom post type class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class DynamicPostType extends PostType {

	/**
	 * Get post type name.
	 *
	 * @return string Custom Posts name.
	 */
	public function get_name() {
		return $this->post_type;
	}

	/**
	 * Get post type activation status.
	 *
	 * @return bool  is activate?
	 */
	public static function is_active() {
		return true;
	}

	/**
	 * Get post type unregister status.
	 *
	 * @return bool Do unregister?
	 */
	public function is_unregister() {
		return false;
	}
}
