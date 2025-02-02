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

namespace CodexShaper\Framework\Foundation\Builder;

use CodexShaper\Framework\Foundation\Traits\Hook;

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

	use Hook;
    
    /**
     * Bootstrapped array
     *
     * @param array $sections Array of sections.
     * 
     * @return array $result Array of sections.
     */
    public function get_tabs( $sections ) {

        $count   = 10;
        $result  = array();
        $parents = array();

        foreach ( $sections as $key => $section ) {
            $parent_section = $section['parent'] ?? '';
            if ($parent_section ) {
                $section['priority'] = $section['priority'] ?? $count;
                $parents[$parent_section][] = $section;
                unset( $sections[$key] );
            }

            $count++;
        }

        foreach ( $sections as $key => $section ) {
            $section['priority'] = $section['priority'] ?? ++$count;
            $section_id = $section['id'] ?? '';

            if ( $section_id && isset($parents[$section_id]) && $parents[$section_id] ) {
                $section['children'] = wp_list_sort( 
                    $parents[$section_id], 
                    array( 'priority' => 'ASC' ), 
                    'ASC',
                     true 
                );
            }

            $result[] = $section;
        }

        return wp_list_sort( $result, array( 'priority' => 'ASC' ), 'ASC', true );

    }

    /**
     * Get sections
     *
     * @param array $sections Array of sections.
     * 
     * @return array $result Array of sections.
     */
    public function get_sections( $sections ) {

        $result = array();
        $tab_sections = $this->get_tabs( $sections );

        foreach ( $tab_sections as $tab_section ) {
            if ( ! empty( $tab_section['children'] ) ) {
                foreach ( $tab_section['children'] as $sub ) {
                    $sub['parent_title'] = ( ! empty( $tab_section['title'] ) ) ? $tab_section['title'] : '';
                    $result[] = $sub;
                }
            }
            if ( empty( $tab_section['children'] ) ) {
                $result[] = $tab_section;
            }
        }

        return $result;
    }

    /**
     * Get fields
     *
     * @param array $sections Array of sections.
     * 
     * @return array $result Array of fields.
     */
    public function get_fields( $sections ) {

        $result = array();

        foreach ( $sections as $key => $section ) {
            if ( ! empty( $section['fields'] ) ) {
                foreach ( $section['fields'] as $field ) {
                    $result[] = $field;
                }
            }
        }

        return $result;
    }
}
