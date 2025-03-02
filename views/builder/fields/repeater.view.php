<?php
/**
 * Repeater View
 *
 * @category   View
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use CodexShaper\Framework\Builder\OptionBuilder\Field;
?>

<div class="csmf--repeater-item csmf--foldable csmf--repeater-cloneable" data-depend-id="<?php echo esc_attr( $field['id'] ); ?>">
    <div class="csmf--repeater-action-wrapper csmf--repeater-sort">
        <div class="csmf--repeater-action-content">
            <!-- <i class="button csmf--a-btn csmf--a-btn-primary csmf--repeater-sort fas fa-arrows-alt"></i> -->
            <i class="button csmf--a-btn csmf--a-btn-primary csmf--repeater-clone far fa-clone"></i>
            <i class="button csmf--a-btn csmf--a-btn-danger csmf--repeater-remove fas fa-times"></i>
            <button type="button" class="button fold-handler" title="Collapse" aria-expanded="false">
                <i class="fa fold-indicator"></i>
            </button>
        </div>
    </div>
    <div class="csmf--repeater-content inside">
        <?php
        foreach ( $field['fields'] as $new_field ) {
            $new_field_default = $new_field['default'] ?? '';
            $new_field_unique  = $identifier ? "{$identifier}[{$field['id']}][0]" : "{$field['id']}[0]";
            Field::render( $new_field, $new_field_default, '___' . $new_field_unique, 'repeater' );
        }
        ?>
    </div>
</div>
<div class="csmf--repeater-wrapper" data-field-id="[<?php echo esc_attr( $field['id'] ); ?>]" data-max="<?php echo esc_attr( $options['max'] ); ?>" data-min="<?php echo esc_attr( $options['min'] ); ?>">
    <?php
    if ( is_array( $value ) && count( $value ) > 0 ) :
        $num = 0;
        foreach ( $value as $key => $repeater_value ) :
    ?>
    <div class="csmf--repeater-item csmf--foldable">
        <div class="csmf--repeater-action-wrapper csmf--repeater-sort">
            <div class="csmf--repeater-action-content">
                <!-- <i class="button csmf--a-btn csmf--a-btn-primary csmf--repeater-sort fas fa-arrows-alt"></i> -->
                <i class="button csmf--a-btn csmf--a-btn-primary csmf--repeater-clone far fa-clone"></i>
                <i class="button csmf--a-btn csmf--a-btn-danger csmf--repeater-remove fas fa-times"></i>
                <button type="button" class="button fold-handler" title="Collapse" aria-expanded="false">
                <i class="fa fold-indicator"></i>
            </button>
            </div>
        </div>
        <div class="csmf--repeater-content inside">
            <?php
            foreach ( $field['fields'] as $new_field ) {
                $new_field_unique = $identifier ? "{$identifier}[{$field['id']}][{$num}]" : "{$field['id']}[{$num}]";
                $new_field_value  = isset( $new_field['id'] ) && isset( $value[ $key ][ $new_field['id'] ] ) ? $value[ $key ][ $new_field['id'] ] : '[0]';
                Field::render( $new_field, $new_field_value, $new_field_unique, 'repeater' );
            }
            ?>
        </div>
    </div>
    <?php
            ++$num;
        endforeach;
    endif;
    ?>

</div>
<div class="csmf--repeater-footer">
    <button type="button" class="button csmf--a-btn csmf--a-btn-primary csmf--repeater-add">
        <?php echo wp_kses( $options['button_title'], array( 'i' => array( 'class' => array() ) ) ); ?>
    </button>
</div>