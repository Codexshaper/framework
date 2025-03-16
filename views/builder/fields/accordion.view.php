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

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<div class="csmf--accordion-items" data-depend-id="<?php echo esc_attr( $field['id'] ); ?>">

    <?php foreach ( $field['accordions'] as $key => $accordion ): ?>
        <div class="csmf--accordion-item csmf--foldable folded">
            <!-- Accordion Title -->
            <h4 class="csmf--accordion-title fold-handler">
                <span class="csmf--accordion-text"><?php echo esc_html( $accordion['title'] ); ?></span>
                <span class="csmf--accordion-icon">
                    <i class="<?php echo esc_attr( $accordion['icon'] ?? 'fas fa-angle-right' ); ?>"></i>
                </span>
            </h4>
            <!-- Accordion Content -->
            <div class="csmf--accordion-content inside">
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