<?php
/**
 * Container file
 *
 * @category   Container
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */


namespace CodexShaper\Framework\Container;

use Closure;
use CodexShaper\Framework\Contracts\Container\Container as ContainerContract;
use Exception;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Container class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Container implements ContainerContract {

	/**
	 * The current globally available container (if any).
	 *
	 * @var static
	 */
	protected static $instance = null;

	/**
	 * The registered bindings.
	 *
	 * @var array
	 */
	private array $bindings = array();

	/**
	 * The registered shared instances.
	 *
	 * @var array
	 */

	private array $instances = array();

	/**
	 * The registered aliases.
	 *
	 * @var array
	 */
	private array $aliases = array();

	/**
	 * The registered scopes.
	 *
	 * @var array
	 */
	private array $scopes = array();

	/**
	 * The resolved booleans.
	 *
	 * @var array
	 */
	private array $resolved = array();

	/**
	 * The registered parameters.
	 *
	 * @var array
	 */
	private array $parameters = array();

	/**
     * Get the globally available instance of the container.
     *
     * @return static $instance The globally available instance of the container.
     */
    public static function getInstance(...$args): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new static(...$args);
        }

        return static::$instance;
    }

	/**
	 * Resolve the given type from the container.
	 *
	 * @param  string $abstract
	 * @return mixed
	 *
	 * @throws \CodexShaper\Framework\Contracts\Container\BindingResolutionException
	 */
	public function make( $abstract ) {
		return $this->resolveBinding( $abstract );
	}

	/**
	 * Get a closure to resolve the given type from the container.
	 *
	 * @param  string $abstract
	 * @return \Closure
	 */
	public function factory( $abstract ) {
		return fn () => $this->make( $abstract );
	}

	/**
	 * Bind a service to the container.
	 *
	 * @param string               $abstract
	 * @param callable|string|null $concrete
	 * @param bool                 $singleton
	 */
	public function bind( string $abstract, $concrete = null, bool $singleton = false ) {
		if ( is_null( $concrete ) ) {
			$concrete = $abstract;
		}

		$this->bindings[ $abstract ] = compact( 'concrete', 'singleton' );

		// If already resolved, rebound to update instance
		if ( isset( $this->resolved[ $abstract ] ) ) {
			$this->rebound( $abstract );
		}
	}

	/**
	 * Binding if hasn't register yet into service to the container.
	 *
	 * @param string               $abstract
	 * @param callable|string|null $concrete
	 * @param bool                 $singleton
	 */
	public function bindIf( string $abstract, $concrete = null, bool $singleton = false ) {
		if ( ! $this->has( $abstract ) ) {
			$this->bind( $abstract, $concrete, $singleton );
		}
	}

	/**
	 * Bind a singleton service to the container.
	 *
	 * @param string               $abstract
	 * @param callable|string|null $concrete
	 */
	public function singleton( string $abstract, $concrete = null ) {
		$this->bind( $abstract, $concrete, true );
	}

	/**
	 * Bind if hasn't regester yet inside the singleton service to the container.
	 *
	 * @param string               $abstract
	 * @param callable|string|null $concrete
	 */
	public function singletonIf( string $abstract, $concrete = null ) {
		if ( ! $this->has( $abstract ) ) {
			$this->singleton( $abstract, $concrete );
		}
	}

	/**
	 * Bind an instance directly to the container.
	 *
	 * @param string $abstract
	 * @param mixed  $instance
	 */
	public function instance( string $abstract, $instance ) {
		$this->instances[ $abstract ] = $instance;
		$this->resolved[ $abstract ]  = true;

		// Ensure aliases point to the instance as well
		foreach ( $this->aliases as $alias => $original ) {
			if ( $original === $abstract ) {
				$this->instances[ $alias ] = $instance;
				$this->resolved[ $alias ]  = true;
			}
		}
	}

	/**
	 * Define an alias for an existing binding.
	 *
	 * @param string $abstract
	 * @param string $alias
	 */
	public function alias( string $abstract, string $alias ) {
		if ( ! isset( $this->bindings[ $abstract ] ) && ! class_exists( $abstract ) ) {
			throw new Exception( esc_html(sprintf('Cannot alias non-existent service %s.', $abstract)) );
		}
		$this->aliases[ $alias ] = $abstract;
	}

	/**
	 * Define a scoped service within a specific context.
	 *
	 * @param string   $scope
	 * @param callable $callback
	 */
	public function scope( string $scope, callable $callback ) {
		if ( isset( $this->scopes[ $scope ] ) ) {
			throw new Exception( esc_html( sprintf( 'Scope %s already defined.', $scope ) ) );
		}

		$this->scopes[ $scope ] = $callback;
	}

	/**
	 * Define if hasn't defined yet inside the scoped service within a specific context.
	 *
	 * @param string   $scope
	 * @param callable $callback
	 */
	public function scopeIf( string $scope, callable $callback ) {
		if ( ! isset( $this->scopes[ $scope ] ) ) {
			$this->scope( $scope, $callback );
		}
	}

	/**
	 * Rebind a service after it has been resolved.
	 *
	 * @param string $abstract
	 */
	protected function rebound( string $abstract ) {
		// Clear resolved instance and create new binding
		unset( $this->instances[ $abstract ], $this->resolved[ $abstract ] );

		// Notify aliases of the rebinding
		foreach ( $this->aliases as $alias => $original ) {
			if ( $original === $abstract ) {
				unset( $this->instances[ $alias ], $this->resolved[ $alias ] );
			}
		}
	}

	/**
	 * Set a parameter for injection.
	 *
	 * @param string $name
	 * @param mixed  $value
	 */
	public function setParameter( string $name, $value ) {
		$this->parameters[ $name ] = $value;
	}

	/**
	 * Get a service from the container.
	 *
	 * @param string $abstract
	 * @return mixed
	 * @throws Exception
	 */
	public function get( string $abstract ) {
		$abstract = $this->parameters[ $abstract ] ?? ( $this->aliases[ $abstract ] ?? $abstract );

		if ( isset( $this->instances[ $abstract ] ) ) {
			return $this->instances[ $abstract ];
		}

		if ( isset( $this->bindings[ $abstract ] ) ) {
			return $this->resolveBinding( $abstract );
		}

		if ( class_exists( $abstract ) ) {
			return $this->resolve( $abstract );
		}
	
		throw new Exception( esc_html( sprintf( 'Service %s not found.', $abstract ) ) );
	}

	/**
	 * Check if a service or parameter exists.
	 *
	 * @param string $abstract
	 * @return bool
	 */
	public function has( string $abstract ): bool {
		return isset( $this->instances[ $abstract ] ) || isset( $this->bindings[ $abstract ] ) || isset( $this->aliases[ $abstract ] ) || class_exists( $abstract );
	}

	/**
	 * Resolve a binding from the container.
	 *
	 * @param string $abstract
	 * @return mixed
	 */
	protected function resolveBinding( string $abstract ) {
		$concrete  = $this->bindings[ $abstract ]['concrete'];
		$singleton = $this->bindings[ $abstract ]['singleton'];

		$object = $concrete instanceof Closure ? $concrete( $this ) : $this->resolve( $concrete );

		if ( $singleton ) {
			$this->instances[ $abstract ] = $object;
		}

		$this->resolved[ $abstract ] = true;

		return $object;
	}

	/**
	 * Resolve a class with its dependencies.
	 *
	 * @param string $class
	 * @return mixed
	 * @throws ReflectionException
	 */
	protected function resolve( string $class ) {
		$reflector = new ReflectionClass( $class );

		if ( ! $reflector->isInstantiable() ) {
			throw new Exception( esc_html(sprintf('Class %s cannot be instantiated.', $class)) );
		}

		$constructor = $reflector->getConstructor();

		if ( is_null( $constructor ) ) {
			return new $class();
		}

		$parameters = $constructor->getParameters();

		$dependencies = $this->resolveDependencies( $parameters );

		return $reflector->newInstanceArgs( $dependencies );
	}

	/**
	 * Resolve dependencies for a constructor or method.
	 *
	 * @param array $parameters
	 * @return array
	 * @throws Exception
	 */
	protected function resolveDependencies( array $parameters ): array {
		$dependencies = array();

		foreach ( $parameters as $parameter ) {
			$type = $parameter->getType();
			$name = $parameter->getName();

			if ( $type && ! $type->isBuiltin() ) {
				$dependencies[] = $this->get( $type->getName() );
			} elseif ( isset( $this->parameters[ $name ] ) ) {
				$dependencies[] = $this->parameters[ $name ];
			} elseif ( isset( $this->bindings[ $name ] ) ) {
				$dependencies[] = $this->bindings[ $name ];
			} elseif ( isset( $this->instances[ $name ] ) ) {
				$dependencies[] = $this->instances[ $name ];
			} elseif ( isset( $this->aliases[ $name ] ) ) {
				$dependencies[] = $this->aliases[ $name ];
			} elseif ( $parameter->isDefaultValueAvailable() ) {
				$dependencies[] = $parameter->getDefaultValue();
			} else {
				throw new Exception( esc_html(sprintf( 'Cannot resolve dependency %s.', $name )));
			}
		}

		return $dependencies;
	}

	/**
	 * Call a function or method with resolved dependencies.
	 *
	 * @param callable|array|string $callable
	 * @return mixed
	 */
	public function call( $callable ) {
		$reflector    = new ReflectionFunction( $callable );
		$parameters   = $reflector->getParameters();
		$dependencies = $this->resolveDependencies( $parameters );

		return $callable( ...$dependencies );
	}

	/**
	 * Call a function or method with resolved dependencies.
	 *
	 * @param array $callable
	 * @return mixed
	 */
	public function callMethod( array $callable ) {
		$reflector    = new ReflectionMethod( $callable[0], $callable[1] );
		$parameters   = $reflector->getParameters();
		$dependencies = $this->resolveDependencies( $parameters );

		return call_user_func( $callable, ...$dependencies );
	}

	/**
	 * Retrieve an instance from a defined scope.
	 *
	 * @param string $scope
	 * @return mixed
	 * @throws Exception
	 */
	public function getScope( string $scope ) {
		if ( ! isset( $this->scopes[ $scope ] ) ) {
			throw new Exception( esc_html( sprintf( 'Scope %s not found.', $scope ) ) );
		}

		return ( $this->scopes[ $scope ] )( $this );
	}

	/**
	 * Flush the container of all bindings and resolved instances.
	 *
	 * @return void
	 */
	public function flush() {
		$this->bindings   = array();
		$this->instances  = array();
		$this->aliases    = array();
		$this->scopes     = array();
		$this->resolved   = array();
		$this->parameters = array();
	}

	/**
	 * Determine if a given offset exists.
	 *
	 * @param  string $offset
	 * @return bool
	 */
	public function offsetExists( $offset ): bool {
		return $this->has( $offset );
	}

	/**
	 * Get the value at a given offset.
	 *
	 * @param  string $offset
	 * @return mixed
	 */
	public function offsetGet( $offset ): mixed {
		return $this->get( $offset );
	}

	/**
	 * Set the value at a given offset.
	 *
	 * @param  string $offset
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet( $offset, $value ): void {
		$this->bind( $offset, $value instanceof Closure ? $value : fn () => $value );
	}

	/**
	 * Unset the value at a given offset.
	 *
	 * @param  string $offset
	 * @return void
	 */
	public function offsetUnset( $offset ): void {
		unset( $this->bindings[ $offset ], $this->instances[ $offset ], $this->resolved[ $offset ] );
	}

	/**
	 * Dynamically access container services.
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function __get( $key ) {
		return $this[ $key ];
	}

	/**
	 * Dynamically set container services.
	 *
	 * @param  string $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function __set( $key, $value ) {
		$this[ $key ] = $value;
	}
}
