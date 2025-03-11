<?php
/**
 * Base Widget file
 *
 * @category   Base
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Elementor;

use CodexShaper\Framework\Foundation\Traits\Control\Fields as ControlFields;
use CodexShaper\Framework\Foundation\Traits\Image\Helper as ImageHelper;
use CodexShaper\Framework\Foundation\Traits\Pagination\Pagination;
use Elementor\Plugin;
use Elementor\Widget_Base;

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Base widget class for element bucket
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
abstract class Widget extends Widget_Base {

	use ImageHelper;
	use ControlFields;
	use Pagination;

	/**
	 * Get categories
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function get_categories() {
		return array( 'codexshaper-framework' );
	}

	/**
	 * Widget activation
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return bool
	 */
	public function is_active() {
		return true;
	}

	/**
	 * Switch template post
	 *
	 * @since 3.8.0
	 * @access public
	 *
	 * @param string $post_type Post type.
	 * @param array  $args      Arguments.
	 *
	 * @return void
	 */
	protected function switch_template_post( $post_type = 'cxf-theme-builder', $args = array() ) {
		if ( $post_type === get_post_type() ) {

			$defaults = array(
				'numberposts'      => 1,
				'offset'           => 0,
				'category'         => 0,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'include'          => '',
				'exclude'          => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'post_type'        => $post_type,
				'post_status'      => 'publish',
				'suppress_filters' => true,
			);

			$parsed_args = wp_parse_args( $args, $defaults );
			$posts       = get_posts( $parsed_args );

			// Set template post_id if exists otherwise current post id.
			$post    = $posts[0] ?? null;
			$post_id = $post->ID ?? get_the_id();

			Plugin::instance()->db->switch_to_post( $post_id );
		}
	}

	/**
	 * Restore current post
	 *
	 * @since 3.8.0
	 * @access public
	 *
	 * @return void
	 */
	protected function restore_current_post() {
		Plugin::instance()->db->restore_current_post();
	}
}
