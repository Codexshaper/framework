<?php
/**
 * Base Option file
 *
 * @category   Base
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Builder;

use CodexShaper\Framework\Menu\AdminMenu;

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Base Option class for element bucket
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Option extends Builder {

  /**
   * Admin menu instance.
   *
   * @var object
   */
  protected $admin_menu   = null;

  /**
   * Identifier for the option.
   *
   * @var string
   */
  public $identifier      = '';

  /**
   * Title for the option.
   *
   * @var string
   */
  public $title           = 'CodexShaper Framework';

  /**
   * Notice for the option.
   *
   * @var string
   */
  public $notice          = '';

  /**
   * Sections for the option.
   *
   * @var array
   */
  public $sections        = array();

  /**
   * Options for the option.
   *
   * @var array
   */
  public $options         = array();

  /**
   * Errors for the option.
   *
   * @var array
   */
  public $errors          = array();

  /**
   * Tabs for the option.
   *
   * @var array
   */
  public $tabs            = array();

  /**
   * Fields for the option.
   *
   * @var array
   */
  public $fields          = array();

  /**
   * Sorted sections for the option.
   *
   * @var array
   */
  public $sorted_sections = array();

  /**
   * Args for the option.
   *
   * @var array
   */
  public $args            = array();

  /**
   * Defaults for the option.
   *
   * @var array
   */
  public $defaults        = array();

  /**
   * Database for the option.
   *
   * @var string
   */
  public $database        = '';

  /**
   * Show in network for the option.
   *
   * @var boolean
   */
  public $show_in_network = true;

  /**
   * Ajax save for the option.
   *
   * @var boolean
   */
  public $ajax_save       = true;

  /**
   * Form action for the option.
   *
   * @var string
   */
  public $form_action     = '';
  
  /**
   * Construct option class.
   *
   * @since 1.0.0
   * 
   * @return \CodexShaper\Framework\Foundation\Builder\Option instance.
   */
  public static function instance() {
      return new self();
  }

  /**
   * Build option.
   * 
   * @param string $key Option key.
   * @param array $params Option parameters.
   *
   * @since 1.0.0
   *
   * @return void
   */
  public function build($key, $params = array()) {

    // Set admin menu instance.
    $this->admin_menu = AdminMenu::instance();
    // Set option identifier.
    $this->identifier = $key;

    // Set default args and apply filters.
    $this->args = apply_filters(
        "cmf/builder/{$this->identifier}/args",
        $this->set_default_args($params['args'] ?? []),
        $this
    );

    // Set sections and apply filters.
    $this->sections = apply_filters(
        "cmf/builder/{$this->identifier}/sections",
        $params['sections'] ?? [],
        $this
    );

    // Initialize sections.
    $this->initialize_sections($this->sections);

    // Load options and save defaults.
    $this->get_options();
    $this->set_options();
    $this->save_defaults();

    // Add WordPress hooks.
    add_action('admin_menu', array($this, 'add_admin_menu'));
    add_action('admin_bar_menu', array($this, 'add_admin_bar_menu'), $this->args['admin_bar_menu_priority']);

    if ($this->ajax_save) {
        add_action("wp_ajax_cmf_builder_{$this->identifier}_save", array($this, 'set_options'));
    }

    if ($this->database === 'network' && $this->show_in_network) {
        add_action('network_admin_menu', array($this, 'add_admin_menu'));
    }
  }

  /**
   * Sets default arguments.
   * 
   * @param array $args Arguments.
   * 
   * @since 1.0.0
   * 
   * @return array $args Arguments.
   */
  private function set_default_args($args) {
      return wp_parse_args($args, [
          'database'                => '',
          'show_in_network'         => true,
          'ajax_save'               => true,
          'form_action'             => '',
          'admin_bar_menu_priority' => 80,
          'show_section_reset'      => true,
          'show_reset_all'          => true,
          'show_tab'                => true,
          'title'                   => 'CodexShaper Framework',
      ]);
  }

  /**
   * Initializes sections, tabs, and fields.
   * 
   * @param array $sections Array of sections.
   * 
   * @since 1.0.0
   * 
   * @return void
   */
  private function initialize_sections($sections) {
      $this->tabs = $this->get_tabs($sections);
      $this->fields = $this->get_fields($sections);
      $this->sorted_sections = $this->get_sections($sections);
  }


  /**
   * Add admin bar menu.
   * 
   * @param WP_Admin_Bar $wp_admin_bar WP_Admin_Bar instance.
   *
   * @since 1.0.0
   *
   * @return void
   */
  public function add_admin_bar_menu( $wp_admin_bar ) {

    $menu_capability = $this->args['menu_capability'] ?? 'manage_options';

    if ( ! current_user_can( $menu_capability ) ) {
      return;
    }

    if ( is_network_admin() && ( $this->database !== 'network' || $this->show_in_network !== true ) ) {
      return;
    }

    if ( ! empty( $this->args['show_bar_menu'] ) && empty( $this->args['menu_hidden'] ) ) {

      global $submenu;

      $menu_slug = $this->args['menu_slug'];
      $menu_icon = ( ! empty( $this->args['admin_bar_menu_icon'] ) ) ? '<span class="cmf--ab-icon ab-icon '. esc_attr( $this->args['admin_bar_menu_icon'] ) .'"></span>' : '';

      $wp_admin_bar->add_node( array(
        'id'    => $menu_slug,
        'title' => $menu_icon . esc_attr( $this->args['menu_title'] ),
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
   * Add admin menu.
   *
   * @since 1.0.0
   *
   * @return void
   */
  public function add_admin_menu() {

    $menu_type = $this->args['menu_type'] ?? 'menu';
    $parent_slug = $this->args['parent_slug'] ?? '';  
    $menu_title = $this->args['menu_title'] ?? '';
    $menu_capability = $this->args['menu_capability'] ?? 'manage_options';
    $menu_slug = $this->args['menu_slug'] ?? '';
    $menu_icon = $this->args['menu_icon'] ?? '';
    $menu_position = $this->args['menu_position'] ?? null;
    $sub_menu_title = $this->args['sub_menu_title'] ?? '';
    $menu_hidden = $this->args['menu_hidden'] ?? false;
    $show_sub_menu = $this->args['show_sub_menu'] ?? true;

    if ( $menu_type === 'submenu' ) {

      $this->admin_menu->add_menu( array(
        'type' => $menu_type,
        'parent_slug' => $parent_slug,
        'page_title' => $menu_title,
        'menu_title' => $menu_title,
        'capability' => $menu_capability,
        'menu_slug' => $menu_slug,
        'callback' => array( $this, 'render_options' ),
        'icon_url' => '',
        'position' => null,
      ));

    } else {
      
      $this->admin_menu->add_menu( array(
        'type' => $menu_type,
        'page_title' => $menu_title,
        'menu_title' => $menu_title,
        'capability' => $menu_capability,
        'menu_slug' => $menu_slug,
        'callback' => array( $this, 'render_options' ),
        'icon_url' => $menu_icon,
        'position' => $menu_position,
      ));


      if ( $sub_menu_title ) {
        $this->admin_menu->add_menu( array(
          'type' => $menu_type,
          'parent_slug' => $menu_slug,
          'page_title' => $sub_menu_title,
          'menu_title' => $sub_menu_title,
          'capability' => $menu_capability,
          'menu_slug' => $menu_slug,
          'callback' => array( $this, 'render_options' ),
          'icon_url' => '',
          'position' => null,
        ));
      }

      if ( $show_sub_menu && count( $this->tabs ) > 1 ) {

        // Create tab menus.
        foreach ( $this->tabs as $section ) {
          $tab_menu_title = $section['title'];
          $tab_menu_slug = $menu_slug .'#tab='. sanitize_title( $section['title'] );
          $this->admin_menu->add_menu( array(
            'type' => $menu_type,
            'parent_slug' => $parent_slug,
            'page_title' => $tab_menu_title,
            'menu_title' => $tab_menu_title,
            'capability' => $menu_capability,
            'menu_slug' => $tab_menu_slug,
            'callback' => '__return_null',
            'icon_url' => '',
            'position' => null,
          ));
        }

        remove_submenu_page( $menu_slug, $menu_slug );

      }

      if ( $menu_hidden ) {
        remove_menu_page( $menu_slug );
      }

    }
  }

  /**
   * Render options view.
   *
   * @since 1.0.0
   *
   * @return array
   */
  public function render_options() {

      $args           = $this->args;
      $identifier     = $this->identifier;
      $options        = $this->options;
      $tabs           = $this->tabs;
      $sections       = $this->sorted_sections;
      $notice         = $this->notice;
      $show_tab       = $this->args['show_tab'] ?? true;
      $has_nav        = count( $this->tabs ) > 1 ? true : false;
      $wrapper_class  = $this->args['wrapper_class'] ?? '';
      $form_action    = $this->form_action;

      /**
       * Filter section allowed html
       *
       * @since 1.0.0
       *
       * @param array $allowed_html Allowed html.
       */
      $allowed_html = apply_filters(
        'cmf/builder/section/allowed_html', 
        array(
          'p' => array(
            'class' => array()
          ), 
          'a' => array(
            'href' => array(), 
            'target' => array()
          ), 
          'mark' => array()
        )
      );
      
      do_action( 'cmf/builder/options/before' );

      cmf_view(
          'builder.option', 
          compact(
              'identifier',
              'options',
              'args',
              'tabs',
              'sections',
              'wrapper_class',
              'form_action',
              'show_tab',
              'has_nav',
              'notice',
              'allowed_html'
          )
      );

      do_action( 'cmf/builder/options/after' );

  }

  /**
   * Get options.
   *
   * @since 1.0.0
   *
   * @return array $options Options.
   */
  public function get_options() {
    $this->options = get_option( $this->identifier );

    switch($this->database) { 
      case 'transient':
        $this->options = get_transient( $this->identifier );
        break;
      case 'theme_mod':
        $this->options = get_theme_mod( $this->identifier );
        break;
      case 'network':
        $this->options = get_site_option( $this->identifier );
        break;
    }

    if ( ! $this->options || ! is_array( $this->options )) {
        $this->options = (array) $this->options;
    }

    return $this->options;
  }
  
  /**
   * Get defaults.
   *
   * @param array $field Field.
   *
   * @since 1.0.0
   *
   * @return array $default Default.
   */
  public function get_default( $field ) {

    $default = $field['default'] ?? array();
    $field_id = $field['id'] ?? '';
    $defaults = $this->args['defaults'] ?? array();

    return $defaults[$field_id] ?? $default;
  }

  /**
   * Save defaults.
   *
   * @since 1.0.0
   *
   * @return void
   */
  public function save_defaults() {
    $save_defaults = $this->args['save_defaults'] ?? true;
    $options = array();

    foreach ( $this->fields as $field ) {
      $field_id = $field['id'] ?? '';
      if ( $field_id ) {
        $options[$field['id']] =  $this->options[$field_id] ?? $this->get_default( $field );
      }
    }

    if ( $save_defaults && empty( $this->options ) ) {
      $this->save_options( $options );
    }

    $this->options = $options;
  }

  /**
   * Set options.
   *
   * @since 1.0.0
   *
   * @return array $fields Fields.
   */
  public function set_options() {
    // Check if the request is an AJAX request.
    $is_ajax = defined('DOING_AJAX') && DOING_AJAX;

    // Retrieve the nonce key and validate it.
    $nonce_key = "cmf_options_nonce_{$this->identifier}";
    $request = wp_unslash($_POST) ?? array();

    if (!isset($request[$nonce_key]) || !wp_verify_nonce($request[$nonce_key], 'cmf_options_nonce')) {
        return false; // Exit early if nonce verification fails.
    }

    // Retrieve AJAX data if available.
    $ajax_data = isset($request['data']) ? sanitize_text_field(wp_unslash($request['data'])) : '';
    $request = $is_ajax && $ajax_data ? json_decode(trim($ajax_data), true) : $request;

    // Initialize variables.
    $data = array();
    $options = $request[$this->identifier] ?? array();
    $transient = $request['cmf_option'] ?? array();

    // Handle transient states.
    $section_id = $transient['section'] ?? '';
    $import_data = $request['cmf_import_data'] ?? '';
    $save = !empty($transient['save']);
    $reset_all = !empty($transient['reset']);
    $reset_section = !empty($transient['reset_section']) && $section_id;

    // Handle importing options.
    if (!$is_ajax && $import_data) {
        $options = json_decode(wp_unslash(trim($import_data)), true);
        $this->notice = esc_html__('Settings successfully imported.', 'codexshaper-framework');

        if (!is_array($options) || empty($options)) {
            $options = array();
            $this->notice = esc_html__('No valid data, please export the string again.', 'codexshaper-framework');
        }
    }

    // Handle resetting all options.
    if ($reset_all) {
        $data = $this->reset_all_options();
        $this->notice = esc_html__('Default options restored.', 'codexshaper-framework');
    }

    // Handle resetting a specific section.
    if ($reset_section) {
        $data = $this->reset_section_options($section_id);
        $this->notice = esc_html__('Default section options restored.', 'codexshaper-framework');
    }

    // Save new options if not resetting.
    if ($save && !$reset_all && !$reset_section) {
        $data = $this->sanitize_and_validate_fields($options, $is_ajax, !empty($import_data));
    }

    // Apply filters and actions before saving.
    $data = apply_filters("cmf_{$this->identifier}_save", $data, $this);
    do_action("cmf_{$this->identifier}_save_before", $data, $this);

    // Save options and trigger after save actions.
    $this->options = $data;
    $this->save_options($data);
    do_action("cmf_{$this->identifier}_save_after", $data, $this);

    // Set success notice.
    if (! $this->notice) {
        $this->notice = esc_html__('Options saved successfully.', 'codexshaper-framework');
    }

    // Send JSON response for AJAX requests.
    if ($is_ajax) {
        wp_send_json_success(array('notice' => $this->notice, 'errors' => $this->errors));
    }
  }

  /**
   * Reset all options to their default values.
   * 
   * @since 1.0.0
   * 
   * @return array $data Data.
   */
  private function reset_all_options() {
      $data = array();
      foreach ($this->fields as $field) {
          if (!empty($field['id'])) {
              $data[$field['id']] = $this->get_default($field);
          }
      }
      return $data;
  }

  /**
   * Reset section options to their default values.
   * 
   * @param int $section_id Section ID.
   * 
   * @since 1.0.0
   * 
   * @return array $data Data.
   */
  private function reset_section_options($section_id) {
      $data = array();
      if (!empty($this->sorted_sections[$section_id - 1]['fields'])) {
          foreach ($this->sorted_sections[$section_id - 1]['fields'] as $field) {
              if (!empty($field['id'])) {
                  $data[$field['id']] = $this->get_default($field);
              }
          }
      }
      return wp_parse_args($data, $this->options);
  }

  /**
   * Sanitize and validate fields.
   * 
   * @param array $options Options.
   * @param bool $is_ajax Is AJAX request.
   * @param bool $importing Is importing options.
   * 
   * @since 1.0.0
   * 
   * @return array $data Data.
   */
  private function sanitize_and_validate_fields($options, $is_ajax, $importing) {
    $data = array();

    foreach ($this->fields as $field) {
        $field_id = $field['id'] ?? '';
        if ($field_id) {
            $sanitize = $field['sanitize'] ?? false;
            $validate = $field['validate'] ?? false;

            $field_value = $options[$field_id] ?? '';
            if (!$is_ajax && !$importing) {
                $field_value = wp_unslash($field_value);
            }

            // Sanitize textarea fields to trim whitespace.
            if (!empty($field['type']) && $field['type'] === 'textarea') {
                $field_value = trim($field_value);
            }

            // Sanitize field value.
            if ($sanitize && is_callable($sanitize)) {
                $data[$field_id] = call_user_func($sanitize, $field_value);
            } elseif (is_array($field_value)) {
                $data[$field_id] = wp_kses_post_deep($field_value);
            } else {
                $data[$field_id] = wp_kses_post($field_value);
            }

            // Validate field value.
            if ($validate && is_callable($validate)) {
                $has_validated = call_user_func($validate, $field_value);
                if ($has_validated) {
                    $data[$field_id] = $this->options[$field_id] ?? '';
                    $this->errors[$field_id] = $has_validated;
                }
            }
        }
    }

    return $data;
  }

  /**
   * Save options.
   *
   * @param array $data Data.
   *
   * @since 1.0.0
   *
   * @return void
   */
  public function save_options( $data ) {
    $expiration = $this->args['expiration'] ?? 0;

    switch($this->database) {
      case 'transient':
        set_transient( $this->identifier, $data, $expiration);
        break;
      case 'theme_mod':
        set_theme_mod( $this->identifier, $data );
        break;
      case 'network':
        update_site_option( $this->identifier, $data );
        break;
      default:
        update_option( $this->identifier, $data );
        break;
    }

    do_action( "cmf/builder/{$this->identifier}/after_save", $data, $this );

  }
}