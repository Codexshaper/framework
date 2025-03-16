<?php
/**
 * Field View
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
?>
<div 
    class="<?php echo esc_attr( "csmf--field csmf--field-{$field_type} {$class}" ); ?>" 
    <?php echo $depend_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>
>
    <?php if ( $title ) : ?>
        <div class="csmf--field-title">
            <h4><?php echo esc_html( $title, 'codexshaper-framework' ); ?> </h4>
            <?php if ( $subtitle ) : ?>
                <p class="csmf--subtitle-text"><?php echo esc_html( $subtitle, 'codexshaper-framework' ); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="csmf--fieldset">
        <?php
            $instance = new $field_class( $field, $value, $identifier, $where, $parent );
            $instance->render();
        ?>
    </div>
    <?php if ( $error_messsage || ! empty( $error_messsage ) ) : ?>
        <p><?php echo esc_html( $error_messsage, 'codexshaper-framework' ); ?></p>
    <?php endif; ?>
</div>