<?php
/**
 * Hook Trait file
 *
 * @category   Core
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Traits;

/**
 * Hook trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Hook {

	/**
	 * Add action
	 *
	 * @param string   $hook_name The hook name.
	 * @param callable $callback The callable task.
	 * @param int      $priority The priority of the task. Less priority execute first.
	 * @param int      $accepted_args How many arguments can accept by callable function or method.
	 *
	 * @return void.
	 */
	public function add_action( $hook_name, $callback, $priority = 10, $accepted_args = 1 ) {
		// Check the callback is string. If string then convert to array with current object.
		if ( is_string( $callback ) ) {
			$callback = array( $this, $callback );
		}
		// Register action hook.
		add_action( $hook_name, $callback, $priority, $accepted_args );
	}

	/**
	 * Remove action
	 *
	 * @param string   $hook_name The hook name.
	 * @param callable $callback The callable task.
	 * @param int      $priority The priority of the task. Less priority execute first.
	 *
	 * @return void.
	 */
	public function remove_action( $hook_name, $callback, $priority = 10 ) {
		// Check the callback is string. If string then convert to array with current object.
		if ( is_string( $callback ) ) {
			$callback = array( $this, $callback );
		}
		// Unregister action hook.
		remove_action( $hook_name, $callback, $priority );
	}

	/**
	 * Add filter
	 *
	 * @param string   $hook_name The hook name.
	 * @param callable $callback The callable task.
	 * @param int      $priority The priority of the task. Less priority execute first.
	 * @param int      $accepted_args How many arguments can accept by callable function or method.
	 *
	 * @return void.
	 */
	public function add_filter( $hook_name, $callback, $priority = 10, $accepted_args = 1 ) {
		// Check the callback is string. If string then convert to array with current object.
		if ( is_string( $callback ) ) {
			$callback = array( $this, $callback );
		}
		// Register filter hook.
		add_filter( $hook_name, $callback, $priority, $accepted_args );
	}

	/**
	 * Remove filter
	 *
	 * @param string   $hook_name The hook name.
	 * @param callable $callback The callable task.
	 * @param int      $priority The priority of the task. Less priority execute first.
	 *
	 * @return void.
	 */
	public function remove_filter( $hook_name, $callback, $priority = 10 ) {
		// Check the callback is string. If string then convert to array with current object.
		if ( is_string( $callback ) ) {
			$callback = array( $this, $callback );
		}
		// Unregister filter hook.
		remove_filter( $hook_name, $callback, $priority );
	}

	/**
	 * Execute actions
	 *
	 * @param array $args The action arguments.
	 *
	 * @return void.
	 */
	public function do_action( ...$args ) {
		// Check hook name is passed or not
		if ( ! is_array( $args ) || empty( $args ) || ! isset( $args[0] ) ) {
			return;
		}
		// If passed first argument as an array
		if ( is_array( $args[0] ) ) {
			$args = array( ...$args[0] );
		}

		$hook_name = array_shift( $args );
		$action    = "cmf_{$hook_name}";

		// Execute action hooks.
		do_action( $action, ...$args );
	}

	/**
	 * Execute filters
	 *
	 * @param array $args The action arguments.
	 *
	 * @return mixed The filtered value after all hooked functions are applied to it.
	 */
	public function apply_filters( ...$args ) {
		// Check hook name is passed or not
		if ( ! is_array( $args ) || empty( $args ) || ! isset( $args[0] ) ) {
			return;
		}
		// If passed first argument as an array
		if ( is_array( $args[0] ) ) {
			$args = array( ...$args[0] );
		}

		if ( ! isset( $args[1] ) ) {
			return;
		}

		$hook_name = array_shift( $args );
		$value     = array_shift( $args );
		$filter    = "cmf_{$hook_name}";

		// Execute filter hooks.
		return apply_filters( $filter, $value, ...$args );
	}
}
