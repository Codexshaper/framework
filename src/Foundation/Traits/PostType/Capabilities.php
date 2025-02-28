<?php
/**
 * PostType Capabilities Trait file
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
 *  PostType Capabilities trait
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
	 * to construct the capabilities, e.g.array('story', 'stories').
	 * Default 'post'.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string|array  The post type capability_type.
	 */
	protected $capability_type = 'post';

	/**
	 * Array of capabilities for this post type. $capability_type is used as a base to construct capabilities by default.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @see get_post_type_capabilities() https://developer.wordpress.org/reference/functions/get_post_type_capabilities/
	 *
	 * @var string[]  The post type capabilities.
	 */
	protected $capabilities;

	/**
	 * Get all capabilities.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array All post type capabilities.
	 */
	function get_capabilities() {
		return $this->capabilities;
	}

	/**
	 * Set meta capabilities.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @param array $capabilities Default capabilities.
	 *
	 * @return PostType The instance of the current object.
	 */
	function set_meta_capabilities( $capabilities = array() ) {
		$capability_type                   = $this->capability_type ?? 'post';
		$this->capabilities['edit_post']   = "edit_{$capability_type}";
		$this->capabilities['read_post']   = "read_{$capability_type}";
		$this->capabilities['delete_post'] = "delete_{$capability_type}";

		if ( is_array( $capabilities ) && ! empty( $capabilities ) ) {
			foreach ( $capabilities as $type => $capability ) {
				$this->capabilities[ $type ] = $capability;
			}
		}

		return $this;
	}

	/**
	 * Set primitive capabilities outside meta.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @param array $capabilities capabilities.
	 *
	 * @return PostType The instance of the current object.
	 */
	function set_primitive_capabilities_outside_meta( $capabilities = array() ) {
		$capability_type                          = $this->capability_type ?? 'post';
		$this->capabilities['edit_posts']         = "edit_{$capability_type}s";
		$this->capabilities['edit_others_posts']  = "edit_others_{$capability_type}s";
		$this->capabilities['publish_posts']      = "publish_{$capability_type}s";
		$this->capabilities['read_private_posts'] = "read_private_{$capability_type}s";

		if ( is_array( $capabilities ) && ! empty( $capabilities ) ) {
			foreach ( $capabilities as $type => $capability ) {
				$this->capabilities[ $type ] = $capability;
			}
		}

		return $this;
	}

	/**
	 * Set primitive capabilities within meta.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @param array $capabilities capabilities.
	 *
	 * @return PostType The instance of the current object.
	 */
	function set_primitive_capabilities_within_meta( $capabilities = array() ) {
		$capability_type                              = $this->capability_type ?? 'post';
		$this->capabilities['read']                   = 'read';
		$this->capabilities['delete_posts']           = "delete_{$capability_type}s";
		$this->capabilities['delete_private_posts']   = "delete_private_{$capability_type}s";
		$this->capabilities['delete_published_posts'] = "delete_published_{$capability_type}s";
		$this->capabilities['delete_others_posts']    = "delete_others_{$capability_type}s";
		$this->capabilities['edit_private_posts']     = "edit_private_{$capability_type}s";
		$this->capabilities['edit_published_posts']   = "edit_published_{$capability_type}s";
		$this->capabilities['create_posts']           = "create_{$capability_type}s";

		if ( is_array( $capabilities ) && ! empty( $capabilities ) ) {
			foreach ( $capabilities as $type => $capability ) {
				$this->capabilities[ $type ] = $capability;
			}
		}

		return $this;
	}
}
