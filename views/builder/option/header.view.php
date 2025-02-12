<?php
/**
 * Options Header View
 *
 * @category   View
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 * @version    1.0.0
 */
?>
<div class="cxf--option-header cxf--sticky-option-header">
    <div class="cxf--option-header-left">
        <h1><?php esc_html($args['title'] ?? ''); ?></h1>
    </div>

    <div class="cxf--option-header-right">
        <input 
            type="submit" 
            class="button cxf--a-btn cxf--a-btn-primary cxf--option-save" 
            name="cxf_option[save]"
            value="<?php echo esc_html__( 'Save', 'codexshaper-framework' ); ?>"
        >

        <?php if(isset($args['show_reset_section']) && $args['show_reset_section']): ?>
            <input 
                type="submit" 
                class="button cxf--a-btn cxf--a-btn-danger cxf--section-reset" 
                name="cxf_option[reset_section]" 
                value="<?php echo esc_html__( 'Reset Section', 'codexshaper-framework' ); ?>"
            >
        <?php endif; ?>

        <?php if(isset($args['show_reset_all']) && $args['show_reset_all']): ?>
            <input 
                type="submit" 
                class="button cxf--a-btn cxf--a-btn-danger csf-reset" 
                name="cxf_option[reset]" 
                value="<?php echo esc_html__( 'Reset All', 'codexshaper-framework' ); ?>"
            >
        <?php endif; ?>
    </div>
</div>