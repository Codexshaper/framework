<?php
/**
 * Custom Metabox file
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
 * Custom  metabox class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class DynamicMetabox extends MetaBox {

	/**
	 * Get meta box id.
	 *
	 * @return string MetaBox id.
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get meta box title.
	 *
	 * @return string MetaBox title.
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * Get meta box screens.
	 *
	 * @return array MetaBox screens.
	 */
	public function get_screen() {
		return $this->screen;
	}
}
