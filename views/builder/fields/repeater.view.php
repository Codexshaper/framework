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

use CodexShaper\Framework\Builder\OptionBuilder\Field;

?>

<div class="cmf--repeater-item cmf--foldable cmf--repeater-cloneable" data-depend-id="<?php echo esc_attr( $field['id'] ); ?>">
    <div class="cmf--repeater-action-wrapper cmf--repeater-sort">
        <div class="cmf--repeater-action-content">
            <!-- <i class="button cmf--a-btn cmf--a-btn-primary cmf--repeater-sort fas fa-arrows-alt"></i> -->
            <i class="button cmf--a-btn cmf--a-btn-primary cmf--repeater-clone far fa-clone"></i>
            <i class="button cmf--a-btn cmf--a-btn-danger cmf--repeater-remove fas fa-times"></i>
            <button type="button" class="button fold-handler" title="Collapse" aria-expanded="false">
                <i class="fa fold-indicator"></i>
            </button>
        </div>
    </div>
    <div class="cmf--repeater-content inside">
        <?php
        foreach ( $field['fields'] as $new_field ) {
            $new_field_default = $new_field['default'] ?? '';
            $new_field_unique  = $identifier ? "{$identifier}[{$field['id']}][0]" : "{$field['id']}[0]";
            Field::render( $new_field, $new_field_default, '___' . $new_field_unique, 'repeater' );
        }
        ?>
    </div>
</div>
<div class="cmf--repeater-wrapper" data-field-id="[<?php echo esc_attr( $field['id'] ); ?>]" data-max="<?php echo esc_attr( $options['max'] ); ?>" data-min="<?php echo esc_attr( $options['min'] ); ?>">
    <?php
    if ( is_array( $value ) && count( $value ) > 0 ) :
        $num = 0;
        foreach ( $value as $key => $repeater_value ) :
    ?>
    <div class="cmf--repeater-item cmf--foldable">
        <div class="cmf--repeater-action-wrapper cmf--repeater-sort">
            <div class="cmf--repeater-action-content">
                <!-- <i class="button cmf--a-btn cmf--a-btn-primary cmf--repeater-sort fas fa-arrows-alt"></i> -->
                <i class="button cmf--a-btn cmf--a-btn-primary cmf--repeater-clone far fa-clone"></i>
                <i class="button cmf--a-btn cmf--a-btn-danger cmf--repeater-remove fas fa-times"></i>
                <button type="button" class="button fold-handler" title="Collapse" aria-expanded="false">
                <i class="fa fold-indicator"></i>
            </button>
            </div>
        </div>
        <div class="cmf--repeater-content inside">
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
<div class="cmf--repeater-footer">
    <button type="button" class="button cmf--a-btn cmf--a-btn-primary cmf--repeater-add">
        <?php echo wp_kses( $options['button_title'], array( 'i' => array( 'class' => array() ) ) ); ?>
    </button>
</div>