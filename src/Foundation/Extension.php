<?php

/**
 * Extension Base file
 *
 * @category   Extension
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/csmf
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation;

use CodexShaper\Framework\Contracts\ExtensionContract;
use CodexShaper\Framework\Foundation\Traits\Hook;
use CodexShaper\Framework\Foundation\Traits\Singleton;

/**
 * Extension Base Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/csmf
 * @since      1.0.0
 */
abstract class Extension implements ExtensionContract {

	use Singleton;
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
