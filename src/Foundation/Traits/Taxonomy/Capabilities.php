<?php
/**
 * Taxonomy Capabilities Trait file
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
 * Taxonomy Capabilities trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Capabilities {

	/**
	 * The string to use to build the read, edit, and delete capabilities.
	 * May be passed as an array to allow for alternative plurals when using this argument as a base
	 * to construct the capabilities.
	 * Default 'categories'.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string|array  The taxonomy capability_type.
	 */
	protected $capability_type = 'categories';

	/**
	 * Array of capabilities for this taxonomy.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string[]  The taxonomy capabilities.
	 */
	protected $capabilities;

	/**
	 * Get all capabilities.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array All taxonomy capabilities.
	 */
	function get_capabilities() {
		return $this->capabilities;
	}

	/**
	 * Set capabilities.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @param array $capabilities Default capabilities.
	 *
	 * @return Taxonomy The instance of the current object.
	 */
	function set_capabilities( $capabilities = array() ) {
		$capability_type                    = $this->capability_type ?? 'categories';
		$this->capabilities['manage_terms'] = "manage_{$capability_type}";
		$this->capabilities['edit_terms']   = "manage_{$capability_type}";
		$this->capabilities['delete_terms'] = "manage_{$capability_type}";
		$this->capabilities['assign_terms'] = 'edit_posts';

		if ( is_array( $capabilities ) && ! empty( $capabilities ) ) {
			foreach ( $capabilities as $type => $capability ) {
				$this->capabilities[ $type ] = $capability;
			}
		}

		return $this;
	}
}
