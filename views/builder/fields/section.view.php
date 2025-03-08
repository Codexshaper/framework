<?php
/**
 * Section View
 *
 * @category   View
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 * @version    1.0.0
 */

use CodexShaper\Framework\Builder\OptionBuilder\Field;

    $section_class = $section['class'] ?? '';
    $section_class .= ' csmf--builder-init';
    $section_title  = $section['title'] ?? '';
    $section_icon   = $section['icon'] ?? '';
    $section_description = $section['description'] ?? '';
    $section_parent = isset($section['parent_title']) ? sanitize_title( $section['parent_title'] ) . '/' : '';
    $section_slug   =  sanitize_title( $section_title );
    $section_id = "{$section_parent}{$section_slug}";
    $is_error       = false;
?>

<div 
    class="csmf--section tab-panel <?php echo esc_attr( $section_class ); ?>" 
    id="panel_<?php echo esc_attr( $section_id ); ?>" 
    data-csmf-tab="<?php echo esc_attr( $section_id ); ?>" 
    role="tabpanel"
>
    <!-- Title -->
    <?php if ( $section_title || $section_icon ) : ?>
        <div class="csmf--section-title">
            <h3>
                <?php if ( $section_icon ): ?>
                    <i class="csmf--section-icon <?php echo esc_attr( $section_icon ); ?>"></i>
                <?php endif; ?>
                <?php echo wp_kses($section_title, $allowed_html); ?>
            </h3>
        </div>
    <?php endif; ?>
    <!-- Description -->
    <?php if ( $section_description ) : ?>
        <div class="csmf--field csmf--section-description"><?php echo wp_kses($section_description, $allowed_html); ?></div>
    <?php endif; ?>
    <!-- Fields -->
    <?php

        $fields   = $section['fields'] ?? array();
        $is_error = ! is_array( $fields ) || empty( $fields );

        if ( ! $is_error ) {
            foreach ( $fields as $field ) {
                $parent = 'section';
                $options = $options ?? [];
                $post_id = $post_id ?? 0;
                
                Field::build( array(
                    'field' => $field,
                    'identifier' => $identifier,
                    'post_id' => $post_id,
                    'options' => $options,
                    'parent' => $parent,
                    'is_serialize' => $is_serialize,
                ) );
            }
        }
    ?>
    <!-- No option found -->
    <?php if ( $is_error ) : ?>
        <div class="csmf--no-option"><?php esc_html__( 'No section data found.', 'codexshaper-framework' ); ?></div>
    <?php endif; ?>
</div>