<?php
/**
 * Service Container Base file
 *
 * @category   Classes
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/csmf
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation;

use CodexShaper\Framework\Foundation\Traits\Hook;
use CodexShaper\Framework\Container\Container;

/**
 * Service Container Base Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/csmf
 * @since      1.0.0
 */
abstract class ServiceContainer extends Container {

	use Hook;

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
	public function __construct() {}

	/**
	 * Get meta box activation status.
	 *
	 * @return bool  is activate?
	 */
	public static function is_active() {
		return true;
	}
}
