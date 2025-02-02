<?php
/**
 * Taxonomy Builder
 *
 * @category   Builder
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Builder;

/**
 * Taxonomy option class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class CustomTaxonomy {

	/**
	 * Taxonomy Create
	 *
	 * Create Taxonomy option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Taxonomy identifier.
	 * @param array  $args Taxonomy arguments.
	 *
	 * @return void
	 */
	public static function create( $identifier, $args = array() ) {
		Builder::createTaxonomy( $identifier, $args );
	}
}
