<?php
/**
 * Options View
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

<div class="cxf cxf--options-wrapper <?php echo esc_attr( $wrapper_class );?>">
    <div class="cxf--container">
        <form 
            method="post" 
            action="<?php echo esc_attr( $form_action );?>" 
            enctype="multipart/form-data" 
            id="cxf--form" 
            autocomplete="off" 
            novalidate="novalidate"
        >
            <input type="hidden" class="cxf--section-id" name="cxf_option[section]" value="1">
            <?php wp_nonce_field( 'cxf_options_nonce', "cxf_options_nonce_{$identifier}" ); ?>

            <div class="cxf--wrapper">
                <!-- Options Header -->
                <?php cxf_view('builder.option.header', compact('args')); ?>
                <!-- Options tab -->
                <?php if($show_tab) : ?>
                <div class="cxf--tabs" data-cxf-tabs>
                <?php endif; ?>
                    <?php if($show_tab) : ?>
                    <!-- Tab Navigation -->
                    <div class="cxf--tabs-nav" role="tablist">
                        <?php cxf_view('builder.option.tabs', compact('args', 'tabs'))?>
                    </div>
                    <?php endif; ?>
                    <?php if($show_tab) : ?>
                    <!-- Tab Panels -->
                    <div class="cxf--tabs-content">
                    <?php endif; ?>
                        <!-- Option Content -->
                        <?php cxf_view('builder.option.content', compact('sections', 'identifier', 'options')); ?>
                    <?php if($show_tab) : ?>
                    </div>
                    <?php endif; ?>
                <?php if($show_tab) : ?>
                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>