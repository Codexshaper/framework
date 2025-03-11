<?php
/**
 * Facade Base file
 *
 * @category   Core
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cxf
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation;

use Exception;
use ReflectionClass;

/**
 * Facade Base Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cxf
 * @since      1.0.0
 */
abstract class Facade {

	/**
	 * The application instance.
	 *
	 * @var \CodexShaper\Framework\Foundation\Application
	 */
	protected static $app;

	/**
	 * Instance of the class to be resolved.
	 *
	 * @var array $instances Array to hold instances for facades.
	 */
	protected static array $instances = array();

	/**
	 * Array to hold factories for facades.
	 *
	 * @var array $factories Array to hold factories for facades.
	 */
	protected static array $factories = array();

	/**
	 * Array to hold parameters for facades.
	 *
	 * @var array $parameters Array to hold parameters for facades.
	 */
	protected static array $parameters = array();

	/**
	 * Register a factory or an instance for a facade.
	 *
	 * @param string          $name The name of the facade.
	 * @param callable|object $resolver A factory callable or an instance.
	 */
	public static function registerFactory( string $name, $resolver ) {
		static::$factories[ $name ] = $resolver;
	}

	/**
	 * Get the instance for the facade class.
	 *
	 * @return object The resolved instance.
	 * @throws Exception If the class or its factory is not defined.
	 */
	protected static function getInstance() {

		$name = static::getFacadeAccessor();
		// Check if we have a factory for this facade
		if ( ! isset( static::$factories[ $name ] ) ) {
			// static::$factories[$name] = new static::$app->resolve($name);
			$object = static::resolve( $name );
			static::registerFactory( $name, $object );
		}

		// If singleton instance exists, return it
		if ( isset( static::$instances[ $name ] ) ) {
			return static::$instances[ $name ];
		}

		// Resolve the factory to get an instance
		$factory = static::$factories[ $name ];

		// If the factory is a callable (closure or factory function), call it to get an instance
		$instance = is_callable( $factory ) ? $factory() : $factory;

		// Cache the instance if it's a singleton facade
		if ( static::isSingleton() ) {
			static::$instances[ $name ] = $instance;
		}

		return $instance;
	}

	/**
	 * Resolve a class with its dependencies.
	 *
	 * @param string $class
	 * @return mixed
	 * @throws ReflectionException
	 */
	protected static function resolve( string $class ) {
		$reflector = new ReflectionClass( $class );

		if ( ! $reflector->isInstantiable() ) {
			throw new Exception( esc_html( sprintf( 'Class %s cannot be instantiated.', $class )) );
		}

		$constructor = $reflector->getConstructor();

		if ( is_null( $constructor ) ) {
			return new $class();
		}

		$parameters = $constructor->getParameters();

		$dependencies = static::resolveDependencies( $parameters );

		return $reflector->newInstanceArgs( $dependencies );
	}

	/**
	 * Resolve dependencies for a constructor or method.
	 *
	 * @param array $parameters
	 * @return array
	 * @throws Exception
	 */
	protected static function resolveDependencies( array $parameters ): array {
		$dependencies = array();

		foreach ( $parameters as $parameter ) {
			$type = $parameter->getType();
			$name = $parameter->getName();

			if ( $type && ! $type->isBuiltin() ) {
				$dependencies[] = static::get( $type->getName() );
			} elseif ( isset( static::$parameters[ $name ] ) ) {
				$dependencies[] = static::$parameters[ $name ];
			} elseif ( $parameter->isDefaultValueAvailable() ) {
				$dependencies[] = $parameter->getDefaultValue();
			} else {
				throw new Exception( esc_html(sprintf('Unable to resolve dependency %s.', $name)) );
			}
		}

		return $dependencies;
	}

	/**
	 * Determine if the facade is a singleton.
	 *
	 * @return bool
	 */
	protected static function isSingleton(): bool {
		return true; // Default to singleton; override in subclasses for non-singleton
	}

	/**
	 * Retrieve the facade accessor.
	 *
	 * @return string
	 * @throws Exception If accessor not defined.
	 */
	protected static function getFacadeAccessor() {
		throw new Exception( esc_html('Facade does not implement getFacadeAccessor method.') );
	}

	/**
	 * Handle static method calls by forwarding to the resolved instance.
	 *
	 * @param string $method The method being called.
	 * @param array  $args Arguments for the method.
	 * @return mixed The result of the method call.
	 * @throws Exception If the method does not exist.
	 */
	public static function __callStatic( $method, $args ) {
		$instance = static::getInstance();

		if ( method_exists( $instance, $method ) ) {
			return $instance->$method( ...$args );
		}

		// Check if method is static on the actual instance
		if ( method_exists( get_class( $instance ), $method ) ) {
			return $instance::$method( ...$args );
		}

		throw new Exception( esc_html(sprintf('Method %s does not exist on the facade.', $method)) );
	}
}
