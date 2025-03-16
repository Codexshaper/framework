<?php
/**
 * Admin menu
 *
 * @category   Admin
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Menu;

use CodexShaper\Framework\Foundation\Traits\Hook;

if ( ! defined( 'ABSPATH' ) ) {
	exit(); // Exit if access directly.
}

/**
 * Admin menu class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class AdminMenu {
	use Hook;

	/**
	 * Instance
	 *
	 * @var \CodexShaper\Framework\Admin\Menu
	 * @static
	 * @since 1.0.0
	 */
	private static $instance;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return \CodexShaper\Framework\Admin\Menu An instance of the class.
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function add_admin_bar( $wp_admin_bar, $options ) {

        if ( ! current_user_can( $options['menu_capability'] ) ) {
          return;
        }
  
        if ( is_network_admin() && ( $options['database'] !== 'network' || $options['show_in_network'] !== true ) ) {
          return;
        }
  
        if ( ! empty( $options['show_bar_menu'] ) && empty( $options['menu_hidden'] ) ) {
  
          global $submenu;
  
          $menu_slug = $options['menu_slug'];
          $menu_icon = ( ! empty( $options['admin_bar_menu_icon'] ) ) ? '<span class="csmf--ab-icon ab-icon '. esc_attr( $options['admin_bar_menu_icon'] ) .'"></span>' : '';
  
          $wp_admin_bar->add_node( array(
            'id'    => $menu_slug,
            'title' => $menu_icon . esc_attr( $options['menu_title'] ),
            'href'  => esc_url( ( is_network_admin() ) ? network_admin_url( 'admin.php?page='. $menu_slug ) : admin_url( 'admin.php?page='. $menu_slug ) ),
          ) );
  
          if ( ! empty( $submenu[$menu_slug] ) ) {
            foreach ( $submenu[$menu_slug] as $menu_key => $menu_value ) {
              $wp_admin_bar->add_node( array(
                'parent' => $menu_slug,
                'id'     => $menu_slug .'-'. $menu_key,
                'title'  => $menu_value[0],
                'href'   => esc_url( ( is_network_admin() ) ? network_admin_url( 'admin.php?page='. $menu_value[2] ) : admin_url( 'admin.php?page='. $menu_value[2] ) ),
              ) );
            }
          }
  
        }
    }

	/**
	 * Add menu pages.
	 *
	 * @param array $options Menu options.
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
    public function add_menus($options) {

		$root_menu_slug = $options['menu_slug'] ?? '';
		$capability = $options['menu_capability'] ?? 'manage_options';
		$callback = $options['callback'] ?? '';
		$position = $options['position'] ?? null;
		$menus = $options['menus'] ?? [];

		foreach($menus as $menu) {
			$menu_title = $menu['menu_title'];
			$page_title = $menu['page_title'] ?? $menu_title;
			$menu_slug = $menu['slug'] ?? $root_menu_slug;
			$menu_capability = $menu['capability'] ?? $capability;
			$menu_type = $menu['type'] ?? 'menu';
			$menu_callback = $menu['callback'] ?? $callback;
			$menu_position = $menu['position'] ?? $position;
			$parent_slug = $menu['parent_slug'] ?? '';
			$icon_url = $menu['icon_url'] ?? '';

			$this->add_menu(array(
				'type' => $menu_type,
				'parent_slug' => $parent_slug,
				'page_title' => $page_title,
				'menu_title' => $menu_title,
				'capability' => $menu_capability,
				'menu_slug' => $menu_slug,
				'callback' => $menu_callback,
				'icon_url' => $icon_url,
				'position' => $menu_position,
			));
		}
  
    }

	/**
	 * Add menu.
	 *
	 * @param array $menu
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
    public function add_menu($menu) {
		$menu_title = $menu['menu_title'];
		$page_title = $menu['page_title'] ?? $menu_title;
		$menu_slug = $menu['menu_slug'];
		$menu_capability = $menu['capability'] ?? 'manage_options';
		$menu_type = $menu['type'] ?? 'menu';
		$menu_callback = $menu['callback'] ?? '';
		$menu_position = $menu['position'] ?? null;

		if ( 'submenu' === $menu_type ) {
			$parent_slug = $menu['parent_slug'] ?? 'codexshaper-framework';
			call_user_func( 'add_submenu_page',  $parent_slug, $page_title, $menu_title, $menu_capability, $menu_slug, $menu_callback, $menu_position );
			return;
		}

		call_user_func( 'add_menu_page', $page_title, $menu_title, $menu_capability, $menu_slug, $menu_callback, $menu_position );
    }
}
