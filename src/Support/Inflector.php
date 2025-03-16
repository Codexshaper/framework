<?php
/**
 * Inflector file
 *
 * @category   Support
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Support;

use Exception;
use CodexShaper\Framework\Foundation\Traits\Singleton;
use Doctrine\Inflector\InflectorFactory;

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Inflector class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Inflector {

	use Singleton;

	/**
	 * Plugin version
	 *
	 * @since 1.0.0
	 * @var \Doctrine\Inflector\Inflector  Inflector manager.
	 */
	protected $inflector;

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
	public function __construct() {
		// Do your settings here
		if ( ! class_exists( '\Doctrine\Inflector\InflectorFactory' ) ) {
			throw new Exception( 'Install Doctrine Inflector by running composer require doctrine/inflector' );
		}

		$this->inflector = InflectorFactory::create()->build();
	}

	/**
	 * Get tableize name from given string name.
	 * E.g: ModelName converts to model_name
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The tableized name.
	 */
	public function tableize( $word ) {
		return $this->inflector->tableize( $word );
	}

	/**
	 * Get classify name from given string name.
	 * E.g. model_name converts to ModelName
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The classified name.
	 */
	public function classify( $word ) {
		return $this->inflector->classify( $word );
	}

	/**
	 * Get camelize name from given string name.
	 * First converts to classiname e.g. model_name to ModelName
	 * Later convert first latter to small letter E.g: ModelName to modelName
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The camelized name.
	 */
	public function camelize( $word ) {
		return $this->inflector->camelize( $word );
	}

	/**
	 * Get capitalize name from given string name.
	 * E.g. top-o-the-morning to all_of_you! converts to Top-O-The-Morning To All_of_you!
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The capitalized name.
	 */
	public function capitalize( $word ) {
		return $this->inflector->capitalize( $word );
	}

	/**
	 * Get pluralize name from given string name.
	 * E.g: category converts to categories
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The pluralized name.
	 */
	public function pluralize( $word ) {
		return $this->inflector->pluralize( $word );
	}

	/**
	 * Get singularize name from given string name.
	 * E.g. categories converts to category
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string Singularized name.
	 */
	public function singularize( $word ) {
		return $this->inflector->singularize( $word );
	}

	/**
	 * Get slug name from given string name.
	 * E.g: 'My first blog post' converts to 'my-first-blog-post'
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The slug.
	 */
	public function slug( $word ) {
		return $this->inflector->urlize( $word );
	}
}
