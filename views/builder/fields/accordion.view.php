<?php
/**
 * Accordion View
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
?>

<div class="cxf--accordion-items" data-depend-id="<?php echo esc_attr( $field['id'] ); ?>">

    <?php foreach ( $field['accordions'] as $key => $accordion ): ?>
        <div class="cxf--accordion-item">
            <!-- Accordion Title -->
            <h4 class="cxf--accordion-title">
                <i class="cxf--icon <?php echo esc_attr( $accordion['icon'] ?? 'fas fa-angle-right' ); ?>"></i>
                <?php echo esc_html( $accordion['title'] ); ?>
            </h4>
            <!-- Accordion Content -->
            <div class="cxf--accordion-content">
                <?php
                    foreach ( $accordion['fields'] as $accordion_field ) {

                        $accordion_field_id      = $accordion_field['id'] ?? '';
                        $accordion_field_default = $accordion_field['default'] ?? '';
                        $accordion_field_value   = $value[$accordion_field_id] ?? $accordion_field_default;
                        $accordion_field_identifier              = $identifier ? "{$identifier}[{$field['id']}]" : $field['id'];
                        $accordion_field['_notice'] = false; 

                        if ( in_array( $accordion_field['type'], $block_fields ) ) { 
                            $accordion_field['_notice'] = true; 
                        }

                        // Render field.
                        Field::render( $accordion_field, $accordion_field_value, $accordion_field_identifier, 'accordion' );

                    }
                ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>