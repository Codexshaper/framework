<?php
/**
 * Stub Facade file
 *
 * @category   Facade
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Support\Facades;

use CodexShaper\Framework\Support\Stub as StubRepository;
use CodexShaper\Framework\Foundation\Facade;

// exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Stub Facade class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Stub extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return StubRepository::class;
	}
}
