<?php
/**
 * Meta Box file
 *
 * @category   Meta Box
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Contracts;

/**
 * Meta Box contract
 *
 * @category   Interface
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
interface MetaBoxContract {

	/**
	 * Get meta box id.
	 *
	 * @return string MetaBox id.
	 */
	public function get_id();

	/**
	 * Get meta box title.
	 *
	 * @return string MetaBox title.
	 */
	public function get_title();

	/**
	 * Display the meta box HTML to the user.
	 *
	 * @param WP_Post $post   Post object.
	 */
	public function render( $post );

	/**
	 * Save the meta box selections.
	 *
	 * @param int $post_id  The post ID.
	 */
	public function save( int $post_id );

	/**
	 * Adds a meta box to one or more screens.
	 *
	 * @since 1.0.0
	 */
	public function register();

	/** Removes a meta box from one or more screens.
	 *
	 * @since 1.0.0
	 */
	function unregister();
}
