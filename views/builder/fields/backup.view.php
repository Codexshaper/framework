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
<div class="csmf--import-wrapper">
    <textarea name="csmf_import_data" class="csmf--import-data"></textarea>
    <button 
        type="submit" 
        class="csmf--import button csmf--a-btn csmf--a-btn-primary" 
        data-identifier="<?php echo esc_attr( $identifier ); ?>" 
        data-option-name="<?php echo esc_attr( $option_name ); ?>" 
        data-nonce="<?php echo esc_attr( $nonce ); ?>"
    >
        <?php echo esc_html__( 'Import', 'codexshaper-framework' );?>
    </button>
</div>

<div class="csmf--export-wrapper">
    <textarea readonly="readonly" class="csmf--option-export"><?php echo esc_html( $export_data ); ?></textarea>
    <a 
        href="<?php echo esc_url( $export ); ?>" 
        class="csmf--export" 
        target="_blank"
    >
        <?php echo esc_html__( 'Export & Download', 'codexshaper-framework' ); ?>
    </a>
    <button 
        type="submit" 
        value="reset" 
        class="csmf--reset-option button csmf--a-btn csmf--a-btn-primary" 
        data-identifier="<?php echo esc_attr( $identifier ); ?>"
        data-option-name="<?php echo esc_attr( $option_name ); ?>"
        data-nonce="<?php echo esc_attr( $nonce ); ?>"
    >
        <?php echo esc_html__( 'Reset', 'codexshaper-framework' ); ?>
    </button>

    <button 
        type="submit"  
        value="reset" 
        class="csmf--delete-option button csmf--a-btn csmf--a-btn-primary" 
        data-identifier="<?php echo esc_attr( $identifier ); ?>"
        data-option-name="<?php echo esc_attr( $option_name ); ?>"
        data-nonce="<?php echo esc_attr( $nonce ); ?>"
    >
        <?php echo esc_html__( 'Reset & Delete', 'codexshaper-framework' ); ?>
    </button>
</div>