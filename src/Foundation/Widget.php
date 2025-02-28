<?php

/**
 * Widget file
 *
 * @category   Classes
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cmf
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation;

use WP_Widget;
use CodexShaper\Framework\Contracts\WidgetContract;
use CodexShaper\Framework\Foundation\Traits\Singleton;

/**
 * Class Widgets
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cmf
 * @since      1.0.0
 */
abstract class Widget extends WP_Widget implements WidgetContract {

	use Singleton;

	/**
	 * Constructs the new widget.
	 *
	 * @see WP_Widget::__construct()
	 */
	public function __construct() {
		// Instantiate the parent object.
		parent::__construct(
			$this->get_name(),
			$this->get_title(),
			array( 'description' => $this->get_description() )
		);
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'CMF Widget Title', 'codexshaper-framework' );
	}

	/**
	 * Get widget description.
	 *
	 * @return string Widget description.
	 */
	public function get_description() {
		return __( 'CMF Widget Description', 'codexshaper-framework' );
	}

	/**
	 * Get widget activation status.
	 *
	 * @return bool Widget is activate.
	 */
	public static function is_active() {
		return true;
	}
}
