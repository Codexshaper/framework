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

namespace CodexShaper\Framework\Builder;

use CodexShaper\Framework\Foundation\PostType;

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
class CustomPost extends PostType {

	/**
	 * Constructor
	 *
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function __construct($options = array()) {

        $post_type = $options['post_type'] ?? '';

        if ( ! $post_type ) {
            return;
        }

        foreach($options as $label => $value) {
            $setter = "set_label_{$label}";

            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
				unset($options[$label]);
            }
        }

		foreach($options as $option => $value) {
            $setter = "set_{$option}";

            if (property_exists($this, $option)) {
                $this->{$option} = $value;
            }
            
        }

        $this->post_type = strtolower( str_replace( array( ' ', '_' ), '-', $post_type ) );

		if ( ! $this->post_title ) {
			$this->post_title = join( ' ', array_map( 'ucfirst', explode( '-', $this->post_type ) ) );
		}

        if ( ! $this->public ) {
			$this->public = true;
		}

		if ( ! $this->publicly_queryable ) {
			$this->publicly_queryable = true;
		}

		if ( ! $this->show_ui ) {
			$this->show_ui = true;
		}

		if ( ! $this->show_in_rest ) {
			$this->show_in_rest = true;
		}

		if ( ! $this->query_var ) {
			$this->query_var = true;
		}

        $this->options = $this->get_options();

        $this->register( $this->post_type, $this->options );
	}

	/**
	 * Get post type name.
	 *
	 * @return string Custom Post name.
	 */
	public function get_name() {
		return '';
	}
}
