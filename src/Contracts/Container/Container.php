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

namespace CodexShaper\Framework\Contracts\Container;

use ArrayAccess;
use Closure;
use Psr\Container\ContainerInterface;

/**
 * Container contract
 *
 * @category   Interface
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
interface Container extends ArrayAccess, ContainerInterface {

	/**
	 * Bind a service to the container.
	 *
	 * @param string               $abstract
	 * @param callable|string|null $concrete
	 * @param bool                 $singleton
	 */
	public function bind( string $abstract, $concrete = null, bool $singleton = false );

	/**
	 * Binding if hasn't register yet into service to the container.
	 *
	 * @param string               $abstract
	 * @param callable|string|null $concrete
	 * @param bool                 $singleton
	 */
	public function bindIf( string $abstract, $concrete = null, bool $singleton = false );

	/**
	 * Bind a singleton service to the container.
	 *
	 * @param string               $abstract
	 * @param callable|string|null $concrete
	 */
	public function singleton( string $abstract, $concrete = null );

	/**
	 * Bind if hasn't regester yet inside the singleton service to the container.
	 *
	 * @param string               $abstract
	 * @param callable|string|null $concrete
	 */
	public function singletonIf( string $abstract, $concrete = null );

	/**
	 * Bind an instance directly to the container.
	 *
	 * @param string $abstract
	 * @param mixed  $instance
	 */
	public function instance( string $abstract, $instance );

	/**
	 * Define an alias for an existing binding.
	 *
	 * @param string $abstract
	 * @param string $alias
	 */
	public function alias( string $abstract, string $alias );

	/**
	 * Define a scoped service within a specific context.
	 *
	 * @param string   $scope
	 * @param callable $callback
	 */
	public function scope( string $scope, callable $callback );

	/**
	 * Define if hasn't defined yet inside the scoped service within a specific context.
	 *
	 * @param string   $scope
	 * @param callable $callback
	 */
	public function scopeIf( string $scope, callable $callback );

	/**
	 * Get a closure to resolve the given type from the container.
	 *
	 * @param  string $abstract
	 * @return \Closure
	 */
	public function factory( $abstract );

	/**
	 * Resolve the given type from the container.
	 *
	 * @param  string $abstract
	 * @param  array  $parameters
	 * @return mixed
	 *
	 * @throws \CodexShaper\Framework\Contracts\Container\BindingResolutionException
	 */
	public function make( $abstract );

	/**
	 * Call a function or method with resolved dependencies.
	 *
	 * @param callable $callable
	 * @return mixed
	 */
	public function call( callable $callable );

	/**
	 * Reset the container of all bindings and resolved instances.
	 *
	 * @return void
	 */
	public function flush();
}
