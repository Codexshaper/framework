<?php
/**
 * Extension Contract file
 *
 * @category   Extension
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Contracts;

/**
 * Extension Contract
 *
 * @category   Interface
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
interface ExtensionContract {

	/**
	 * Get extension name.
	 *
	 * @return string Extension name.
	 */
	public function get_name();
}
