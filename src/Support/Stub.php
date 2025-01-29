<?php
/**
 * Stub support file
 *
 * @category   Support
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Support;

if ( ! defined( 'ABSPATH' ) ) {
	exit(); // exit if access directly.
}

/**
 * Stub Class for handling command template
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Stub {

	/**
	 * The stub path.
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * The base path of stub file.
	 *
	 * @var null|string
	 */
	protected static $basepath = null;

	/**
	 * The replacements array.
	 *
	 * @var array
	 */
	protected $replaces = array();

	/**
	 * Constructor
	 *
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $path the file path.
	 * @param array  $replaces the replaces array.
	 *
	 * @return void
	 */
	public function __construct( $path, array $replaces = array() ) {
		$this->path     = $path;
		$this->replaces = $replaces;
	}

	/**
	 * Create new self instance.
	 *
	 * @param string $path the file path.
	 * @param array  $replaces the replaces array.
	 *
	 * @return self
	 */
	public static function create( $path, array $replaces = array() ) {
		return new static( $path, $replaces );
	}

	/**
	 * Set stub path.
	 *
	 * @param string $path the path.
	 *
	 * @return self
	 */
	public function setPath( $path ) {
		$this->path = $path;

		return $this;
	}

	/**
	 * Get stub path.
	 *
	 * @return string
	 */
	public function getPath() {
		$path = static::getBasePath() . $this->path;

		return file_exists( $path ) ? $path : __DIR__ . '/./stubs/' . ltrim( $this->path, '/' );
	}

	/**
	 * Set base path.
	 *
	 * @param string $path the base path.
	 */
	public static function setBasePath( $path ) {
		static::$basepath = $path;
	}

	/**
	 * Get base path.
	 *
	 * @return string|null
	 */
	public static function getBasePath() {
		return static::$basepath;
	}

	/**
	 * Get stub contents.
	 *
	 * @return mixed|string
	 */
	public function getContents() {
		$contents = file_get_contents( $this->getPath() );

		foreach ( $this->replaces as $search => $replace ) {
			$contents = str_replace( '$' . strtoupper( $search ) . '$', $replace, $contents );
		}

		return $contents;
	}

	/**
	 * Get stub contents.
	 *
	 * @return string
	 */
	public function render() {
		return $this->getContents();
	}

	/**
	 * Save stub to specific path.
	 *
	 * @param string $path the destination path.
	 * @param string $filename the destination filename.
	 *
	 * @return bool
	 */
	public function saveTo( $path, $filename ) {
		return file_put_contents( $path . '/' . $filename, $this->getContents() );
	}

	/**
	 * Set replacements array.
	 *
	 * @param array $replaces the replaces array.
	 *
	 * @return $this
	 */
	public function replace( array $replaces = array() ) {
		$this->replaces = $replaces;

		return $this;
	}

	/**
	 * Get replacements.
	 *
	 * @return array
	 */
	public function getReplaces() {
		return $this->replaces;
	}

	/**
	 * Handle magic method __toString.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->render();
	}
}
