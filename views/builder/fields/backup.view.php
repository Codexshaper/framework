<?php
/**
 * Backup View
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
<div class="cxf--import-wrapper">
    <textarea name="cxf_import_data" class="cxf--import-data"></textarea>
    <button 
        type="submit" 
        class="cxf--import button cxf--a-btn cxf--a-btn-primary" 
        data-identifier="<?php echo esc_attr( $identifier ); ?>" 
        data-nonce="<?php echo esc_attr( $nonce ); ?>"
    >
        <?php echo esc_html__( 'Import', 'codexshaper-framework' );?>
    </button>
</div>

<div class="cxf--export-wrapper">
    <textarea readonly="readonly" class="cxf--option-export"><?php echo esc_html( $export_data ); ?></textarea>
    <a 
        href="<?php echo esc_url( $export ); ?>" 
        class="cxf--export" 
        target="_blank"
    >
        <?php echo esc_html__( 'Export & Download', 'codexshaper-framework' ); ?>
    </a>
    <button 
        type="submit" 
        name="cxf_option[reset]" 
        value="reset" 
        class="cxf--reset button cxf--a-btn cxf--a-btn-primary" 
        data-identifier="<?php echo esc_attr( $identifier ); ?>" 
        data-nonce="<?php echo esc_attr( $nonce ); ?>"
    >
        <?php echo esc_html__( 'Reset', 'codexshaper-framework' ); ?>
    </button>
</div>