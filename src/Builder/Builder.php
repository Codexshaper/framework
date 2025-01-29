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

    public static function build() {
        static::buildOptions();
        static::buildCustomizeOptions();
        static::buildMenuOptions();
        static::buildPostType();
        static::buildTaxonomies();
        static::buildTaxonomyOptions();
        static::buildMetabox();
        static::buildWidget();
        static::buildProfileOptions();
        static::buildCommentMetabox();
        static::buildShortcodeOptions();
    }

    // Create options
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

    // Build customize options (Pro)
    public static function buildCustomizeOptions() {}

    // Build menu options (Pro)
    public static function buildMenuOptions() {}

    public static function buildPostType() {}

    // Build taxonomies (Pro)
    public static function buildTaxonomies() {}

    // Build taxonomy options (Pro)
    public static function buildTaxonomyOptions() {}
 
    // Build metabox options (Pro)
    public static function buildMetabox() {}

    // Build comment metabox (Pro)
    public static function buildCommentMetabox() {}
    // Build shortcoder options (Pro)

    public static function buildShortcodeOptions() {}

    // Build profile options (Pro)
    public static function buildProfileOptions() {}

    // Build widget (Pro)
    public static function buildWidget() {}

    // Build section (Pro)
    public static function buildSection() {}

    // Create options (Pro)
    public static function createOptions( $identifier, $args = array() ) {
        static::$types['options'][$identifier] = $args;
    }

    // Create customize options (Pro)
    public static function createCustomizeOptions( $identifier, $args = array() ) {
        static::$types['customize_options'][$identifier] = $args;
    }

    // Create menu options (Pro)
    public static function createMenuOptions( $identifier, $args = array() ) {
        static::$types['menu_options'][$identifier] = $args;
    }

    public static function createPostType( $identifier, $args = array() ) {
        static::$types['post_types'][$identifier] = $args;
    }

    // Create taxonomy (Pro)
    public static function createTaxonomy( $identifier, $args = array() ) {
        static::$types['taxonomies'][$identifier] = $args;
    }

    // Create taxonomy options (Pro)
    public static function createTaxonomyOptions( $identifier, $args = array() ) {
        static::$types['taxonomy_options'][$identifier] = $args;
    }

    // Create metabox options (Pro)
    public static function createMetabox( $identifier, $args = array() ) {
        static::$types['metaboxes'][$identifier] = $args;
    }

    // Create comment metabox (Pro)
    public static function createCommentMetabox( $identifier, $args = array() ) {
        static::$types['comment_metaboxes'][$identifier] = $args;
    }

    // Create shortcoder options (Pro)
    public static function createShortcoder( $identifier, $args = array() ) {
        static::$types['shortcode_options'][$identifier] = $args;
    }

    // Create profile options (Pro)
    public static function createProfileOptions( $identifier, $args = array() ) {
        static::$types['profiles'][$identifier] = $args;
    }

    // Create widget (Pro)
    public static function createWidget( $identifier, $args = array() ) {
        static::$types['widgets'][$identifier] = $args;
        static::set_used_fields( $args );
    }


    // Create section (Pro)
    public static function createSection( $identifier, $sections ) {
        static::$types['sections'][$identifier][] = $sections;
        static::set_used_fields( $sections );
    }

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