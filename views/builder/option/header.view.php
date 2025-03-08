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
<div class="csmf--option-header csmf--sticky-option-header">
    <div class="csmf--option-header-left">
        <h1><?php esc_html($args['title'] ?? ''); ?></h1>
    </div>

    <div class="csmf--option-header-right">
        <input 
            type="submit" 
            class="button csmf--a-btn csmf--a-btn-primary csmf--option-save" 
            name="csmf_option[save]"
            value="<?php echo esc_html__( 'Save', 'codexshaper-framework' ); ?>"
        >

        <?php if(isset($args['show_reset_section']) && $args['show_reset_section']): ?>
            <input 
                type="submit" 
                class="button csmf--a-btn csmf--a-btn-danger csmf--section-reset" 
                name="csmf_option[reset_section]" 
                value="<?php echo esc_html__( 'Reset Section', 'codexshaper-framework' ); ?>"
            >
        <?php endif; ?>

        <?php if(isset($args['show_reset_all']) && $args['show_reset_all']): ?>
            <input 
                type="submit" 
                class="button csmf--a-btn csmf--a-btn-danger csmf-reset" 
                name="csmf_option[reset]" 
                value="<?php echo esc_html__( 'Reset All', 'codexshaper-framework' ); ?>"
            >
        <?php endif; ?>
    </div>
</div>