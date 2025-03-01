<?php
/**
 * Base Builder file
 *
 * @category   Base
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Builder;

use CodexShaper\Framework\Foundation\Builder\Option;
use CodexShaper\Framework\Foundation\DynamicMetabox;
use CodexShaper\Framework\Foundation\DynamicPostType;
use CodexShaper\Framework\Foundation\DynamicTaxonomy;
use CodexShaper\Framework\Foundation\Traits\Hook;
use CodexShaper\Framework\Foundation\Traits\Singleton;

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Base Builder class for element bucket
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Builder {

	use Hook, Singleton;

    protected static $bootstrapped = array();
    protected static $fields = array();

    protected static $types = array(
        'options' => array(),
        'menu_options' => array(),
        'customize_options' => array(),
        'post_types' => array(),
        'metaboxes' => array(),
        'taxonomies' => array(),
        'taxonomy_options' => array(),
        'widgets' => array(),
        'profiles'  => array(),
        'comment_options' => array(),
        'shortcode_options' => array(),
    );

	/**
	 * Constructor
	 *
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
        add_action( 'init', array(static::class, 'build'));
	    add_action( 'after_setup_theme', array(static::class, 'build') );
        add_action( 'switch_theme', array(static::class, 'build') );
	}

    /**
     * Build all elements
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function build() {
        static::buildOptions();
        static::buildCustomizeOptions();
        static::buildMenuOptions();
        static::buildPostTypes();
        static::buildTaxonomies();
        static::buildTaxonomyOptions();
        static::buildMetabox();
        static::buildWidget();
        static::buildProfileOptions();
        static::buildCommentMetabox();
        static::buildShortcodeOptions();
    }

    /**
     * Build options
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildOptions() {

        foreach ( static::$types['options'] as $key => $value ) {

            $sections = static::$types['sections'] ?? []; 

            // Check if already bootstrapped.
            if ( isset( self::$bootstrapped[$key] ) || empty( $sections[$key] )) {
                continue;
            }

            // Build options.
            Option::instance()->build( $key, array(
                'args'     => $value,
                'sections' => $sections[$key],
            ));

            // Mark as bootstrapped.
            self::$bootstrapped[$key] = true;
        }

    }

    /**
     * Build customize options
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildCustomizeOptions() {}

    /**
     * Build menu options
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildMenuOptions() {}

    /**
     * Build post type
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildPostTypes() {
        foreach ( static::$types['post_types'] as $key => $args ) {
            // Check if already bootstrapped.
            if ( isset( self::$bootstrapped[$key] )) {
                continue;
            }

            if ( ! isset($args['post_type']) ) {
                $args['post_type'] = $key;
            }

            // Create post type.
           new DynamicPostType($args);

            // Mark as bootstrapped.
            self::$bootstrapped[$key] = true;
        }
    }

    /**
     * Build options
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildTaxonomies() {
        foreach ( static::$types['taxonomies'] as $key => $args ) {
            // Check if already bootstrapped.
            if ( isset( self::$bootstrapped[$key] )) {
                continue;
            }

            if ( ! isset($args['taxonomy']) ) {
                $args['taxonomy'] = $key;
            }

            // Create post type.
           new DynamicTaxonomy($args);

            // Mark as bootstrapped.
            self::$bootstrapped[$key] = true;
        }
    }

    /**
     * Build taxonomy options
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildTaxonomyOptions() {}
 
    /**
     * Build metabox
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildMetabox() {
        foreach ( static::$types['metaboxes'] as $key => $options ) {

            $sections = static::$types['sections'] ?? []; 

            // Check if already bootstrapped.
            if ( isset( self::$bootstrapped[$key] ) || empty( $sections[$key] )) {
                continue;
            }

            $sections = $sections[$key] ?? [];

            // Create post type.
           new DynamicMetabox($key, $sections, $options);

            // Mark as bootstrapped.
            self::$bootstrapped[$key] = true;
        }
    }

    /**
     * Build comment metabox
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildCommentMetabox() {}
    
    /**
     * Build shortcoder
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildShortcodeOptions() {}

    /**
     * Build profile options
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildProfileOptions() {}

    /**
     * Build widget
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildWidget() {}

    /**
     * Build sections
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function buildSection() {}

    /**
     * Create options
     * 
     * @param $identifier string Option identifier.
     * @param $args array Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createOptions( $identifier, $args = array() ) {
        static::$types['options'][$identifier] = $args;
    }

    /**
     * Create customize options
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createCustomizeOptions( $identifier, $args = array() ) {
        static::$types['customize_options'][$identifier] = $args;
    }

    /**
     * Create menu options
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createMenuOptions( $identifier, $args = array() ) {
        static::$types['menu_options'][$identifier] = $args;
    }

    /**
     * Create post type
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createPostType( $identifier, $args = array() ) {
        static::$types['post_types'][$identifier] = $args;
    }

    /**
     * Create taxonomy
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createTaxonomy( $identifier, $args = array() ) {
        static::$types['taxonomies'][$identifier] = $args;
    }

    /**
     * Create taxonomy options
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createTaxonomyOptions( $identifier, $args = array() ) {
        static::$types['taxonomy_options'][$identifier] = $args;
    }

    /**
     * Create metabox
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createMetabox( $identifier, $args = array() ) {
        static::$types['metaboxes'][$identifier] = $args;
    }

    /**
     * Create comment box
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createCommentMetabox( $identifier, $args = array() ) {
        static::$types['comment_metaboxes'][$identifier] = $args;
    }

    /**
     * Create shortcoder
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createShortcoder( $identifier, $args = array() ) {
        static::$types['shortcode_options'][$identifier] = $args;
    }

   /**
     * Create create profile options
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createProfileOptions( $identifier, $args = array() ) {
        static::$types['profiles'][$identifier] = $args;
    }

   /**
     * Create Widget
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createWidget( $identifier, $args = array() ) {
        static::$types['widgets'][$identifier] = $args;
        static::set_used_fields( $args );
    }


    /**
     * Create Section
     * 
     * @param $identifier string Option identifier.
     * @param $args array  Option arguments.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function createSection( $identifier, $sections ) {
        static::$types['sections'][$identifier][] = $sections;
        static::set_used_fields( $sections );
    }

    /**
     * Set used fields
     *
     * @param array $sections Sections.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function set_used_fields( $sections ) {

        if ( ! empty( $sections['fields'] ) ) {

            foreach ( $sections['fields'] as $field ) {

                if ( ! empty( $field['fields'] ) ) {
                    self::set_used_fields( $field );
                }

                if ( ! empty( $field['tabs'] ) ) {
                    self::set_used_fields( array( 'fields' => $field['tabs'] ) );
                }

                if ( ! empty( $field['accordions'] ) ) {
                    self::set_used_fields( array( 'fields' => $field['accordions'] ) );
                }

                if ( ! empty( $field['elements'] ) ) {
                    self::set_used_fields( array( 'fields' => $field['elements'] ) );
                }

                if ( ! empty( $field['type'] ) ) {
                    self::$fields[$field['type']] = $field;
                }
            }
        }
    }
}