<?php
/**
 * Config file
 *
 * @category   Support
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Config;

// exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Config class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Config {

	/**
	 * The Configs
	 *
	 * @var array The Configs.
	 */
	protected static $configs = array();

	/**
	 * The App
	 *
	 * @var object The App.
	 */
	protected $app;

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
	public function __construct($app) {
		// Do your settings here
		$this->app = $app;
	}

	/**
	 * Get the Config
	 *
	 * @param string $path The path of the config.
	 * @param mixed $default Default value to return if key not found.
	 * @return mixed The config value or default.
	 */
	public function get($path, $default = null) {
		// Split path into config name and keys
		$path_parts = $this->parsePath($path);
		$config_name = $path_parts['config'];
		$keys = $path_parts['keys'];
		
		// Check if the config is already loaded
		if (!isset(static::$configs[$config_name])) {
			// Try to load from file
			$this->loadConfigFile($config_name);
		}
		
		// If no config was loaded, return default
		if (!isset(static::$configs[$config_name])) {
			return $default;
		}
		
		// If no keys to traverse, return the whole config
		if (empty($keys)) {
			return static::$configs[$config_name];
		}
		
		// Navigate through nested keys
		$value = static::$configs[$config_name];
		foreach ($keys as $key) {
			if (!is_array($value) || !isset($value[$key])) {
				return $default;
			}
			$value = $value[$key];
		}
		
		return $value;
	}

	/**
	 * Set the Config
	 *
	 * @param string $path The path of the config using dot notation.
	 * @param mixed  $value The value of the config.
	 * 
	 * @since 1.0.0
	 * 
	 * @return Configuration The Configuration instance.
	 */
	public function set($path, $value) {
		// Split path into config name and keys
		$path_parts = $this->parsePath($path);
		$config_name = $path_parts['config'];
		$keys = $path_parts['keys'];
		
		// If no config name is provided, return
		if (empty($config_name)) {
			return $this;
		}
		
		// Load existing config if it doesn't exist in memory
		if (!isset(static::$configs[$config_name])) {
			$this->loadConfigFile($config_name);
		}
		
		// If no keys to traverse, set the entire config
		if (empty($keys)) {
			static::$configs[$config_name] = $value;
			return $this;
		}
		
		// Ensure config exists as an array
		if (!isset(static::$configs[$config_name]) || !is_array(static::$configs[$config_name])) {
			static::$configs[$config_name] = array();
		}
		
		// Navigate to the right position and set the value
		$temp = &static::$configs[$config_name];
		
		// Build nested structure
		foreach ($keys as $i => $key) {
			// If it's the last key, set the value
			if ($i === count($keys) - 1) {
				$temp[$key] = $value;
			} else {
				// Create the nested array if it doesn't exist
				if (!isset($temp[$key]) || !is_array($temp[$key])) {
					$temp[$key] = array();
				}
				// Move reference pointer deeper
				$temp = &$temp[$key];
			}
		}

		return $this;
	}
    
	/**
	 * Parse a config path into config name and keys
	 *
	 * @param string $path The path using dot notation
	 * @return array Array with 'config' and 'keys' elements
	 */
	protected function parsePath($path) {
		$path = trim($path);
		// Replace pipe with dot for consistency
		$path = str_replace('|', '.', $path);
		$parts = explode('.', $path);
		
		// First part is the config name
		$config_name = array_shift($parts);
		
		return [
			'config' => $config_name,
			'keys' => $parts
		];
	}
	
	/**
	 * Load a configuration file
	 *
	 * @param string $config_name The name of the configuration
	 * @return bool True if loaded successfully, false otherwise
	 */
	protected function loadConfigFile($config_name) {
		$config_path = CSMF_PLUGIN_CONFIG_PATH . $config_name . '.php';

		/**
		 * Filter the path to save the config to
		 * 
		 * @param string $config_path The path to save the config to.
		 */
		$config_path = apply_filters("csmf_config_path/{$config_name}", $config_path, $config_name);

		if (!file_exists($config_path)) {
			$config_path = trailingslashit(untrailingslashit(dirname(__DIR__))) . '../config/' . $config_name . '.php';
		}

		if (!file_exists($config_path)) {
			return false;
		}

		$config_data = include $config_path;
		if (is_array($config_data)) {
			static::$configs[$config_name] = $config_data;
			return true;
		}
		
		return false;
	}

	/**
	 * Check if a configuration exists
	 * 
	 * @param string $path The path of the config using dot notation.
	 * @return bool True if exists, false otherwise.
	 */
	public function has($path) {
		return $this->get($path, '__not_exists__') !== '__not_exists__';
	}
    
	/**
	 * Remove a configuration
	 * 
	 * @param string $path The path of the config using dot notation.
	 * @return Configuration The Configuration instance.
	 */
	public function remove($path) {
		$path_parts = $this->parsePath($path);
		$config_name = $path_parts['config'];
		$keys = $path_parts['keys'];
		
		// If no config name or config doesn't exist, return
		if (empty($config_name) || !isset(static::$configs[$config_name])) {
			return $this;
		}
		
		// If no keys, remove the entire config
		if (empty($keys)) {
			unset(static::$configs[$config_name]);
			return $this;
		}
		
		// Navigate to the parent of the key to remove
		$temp = &static::$configs[$config_name];
		$last_key = array_pop($keys);
		
		foreach ($keys as $key) {
			if (!isset($temp[$key]) || !is_array($temp[$key])) {
				// Path doesn't exist, nothing to remove
				return $this;
			}
			$temp = &$temp[$key];
		}
		
		// Remove the final key
		if (isset($temp[$last_key])) {
			unset($temp[$last_key]);
		}
		
		return $this;
	}
    
	/**
	 * Save config to file
	 * 
	 * @param string $config_name The name of the config to save.
	 * @return bool True if saved successfully, false otherwise.
	 */
	public function save($config_name) {
		if (!isset(static::$configs[$config_name])) {
			return false;
		}
		
		$config_data = static::$configs[$config_name];
		$config_path = CSMF_PLUGIN_CONFIG_PATH . $config_name . '.php';

		/**
		 * Filter the path to save the config to
		 * 
		 * @param string $config_path The path to save the config to.
		 */
		$config_path = apply_filters("csmf_config_path/{$config_name}", $config_path, $config_name);
		
		// Ensure directory exists
		$dir = dirname($config_path);
		if (!file_exists($dir)) {
			wp_mkdir_p($dir);
		}
		
		// Create PHP content
		$content = "<?php\n\n// Configuration file for {$config_name}\n// Generated on " . date('Y-m-d H:i:s') . "\n\nreturn " . $this->varExport($config_data, true) . ";\n";
		
		return (bool) file_put_contents($config_path, $content);
	}
    
	/**
	 * Get all loaded configurations
	 * 
	 * @return array Array of all loaded configs.
	 */
	public function all() {
		return static::$configs;
	}
    
	/**
	 * Reset a specific config or all configs
	 * 
	 * @param string|null $config_name The name of config to reset, or null to reset all.
	 * @return Configuration The Configuration instance.
	 */
	public function reset($config_name = null) {
		if ($config_name === null) {
			static::$configs = array();
		} elseif (isset(static::$configs[$config_name])) {
			unset(static::$configs[$config_name]);
		}
		
		return $this;
	}
    
	/**
	 * Exports a variable as a string representation.
	 * Similar to var_export but with better handling for arrays.
	 * 
	 * @param mixed $var The variable to export.
	 * @param bool $return Whether to return the exported value.
	 * @param string $indent The indentation string.
	 * @param string $current_indent Current indentation level.
	 * @return string|void
	 */
	protected function varExport($var, $return = false, $indent = "    ", $current_indent = "") {
		switch (gettype($var)) {
			case 'string':
				return "'" . str_replace("'", "\\'", $var) . "'";
			case 'array':
				$indexed = array_keys($var) === range(0, count($var) - 1);
				$result = [];
				$next_indent = $current_indent . $indent;
				
				foreach ($var as $key => $value) {
					$key_export = $indexed ? "" : $this->varExport($key, true) . " => ";
					$value_export = $this->varExport($value, true, $indent, $next_indent);
					$result[] = "$next_indent$key_export$value_export";
				}
				
				$array_content = empty($result) ? "" : "\n" . implode(",\n", $result) . ",\n$current_indent";
				return "array($array_content)";
			case 'boolean':
				return $var ? 'true' : 'false';
			case 'NULL':
				return 'null';
			case 'integer':
			case 'double':
			default:
				return (string)$var;
		}
	}
}