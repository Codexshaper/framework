<?php
/**
 * Base Field file
 *
 * @category   Base
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Builder;

use CodexShaper\Framework\Foundation\Traits\Builder\Field as FieldTrait;
use CodexShaper\Framework\Foundation\Traits\Hook;

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Base Field class for element bucket
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
abstract class Field {

	use Hook;
	use FieldTrait;

	/**
	 * Field
	 *
	 * @var array
	 */
	protected $field;

	/**
	 * Value
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * ID
	 *
	 * @var string
	 */
	protected $identifier;

	/**
	 * Where
	 *
	 * @var string
	 */
	protected $where;

	/**
	 * Parent
	 *
	 * @var string
	 */
	protected $parent;

	/**
	 * Constructor
	 *
	 * @param array  $field Field.
	 * @param string $value Option value.
	 * @param string $identifier Option identifier.
	 * @param string $where Where the field is.
	 * @param string $parent Parent field.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct( $field = array(), $value = '', $identifier = '', $where = '', $parent = '' ) {
		$this->field  		= $field;
		$this->value  		= $value;
		$this->identifier   = $identifier;
		$this->where  		= $where;
		$this->parent 		= $parent;

		if ( method_exists( $this, 'enqueue_scripts' ) ) {
			$this->add_action( 'admin_enqueue_scripts', 'enqueue_scripts' );
		}

		if ( method_exists( $this, 'enqueue_styles' ) ) {
			$this->add_action( 'admin_enqueue_scripts', 'enqueue_styles' );
		}
	}
}
