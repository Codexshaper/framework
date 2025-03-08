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

<div class="csmf csmf--options-wrapper <?php echo esc_attr( $wrapper_class );?>">
    <div class="csmf--container">
        <form 
            method="post" 
            action="<?php echo esc_attr( $form_action );?>" 
            enctype="multipart/form-data" 
            id="csmf--form" 
            autocomplete="off" 
            novalidate="novalidate"
        >
            <input type="hidden" class="csmf--section-id" name="csmf_option[section]" value="1">
            <?php wp_nonce_field( 'csmf_options_nonce', "csmf_options_nonce_{$identifier}" ); ?>

            <div class="csmf--wrapper">
                <!-- Options Header -->
                <?php csmf_view('builder.option.header', compact('args')); ?>
                <!-- Options tab -->
                <?php if($show_tab) : ?>
                <div class="csmf--tabs" data-csmf-tabs>
                <?php endif; ?>
                    <?php if($show_tab) : ?>
                    <!-- Tab Navigation -->
                    <div class="csmf--tabs-nav" role="tablist">
                        <?php csmf_view('builder.option.tabs', compact('args', 'tabs'))?>
                    </div>
                    <?php endif; ?>
                    <?php if($show_tab) : ?>
                    <!-- Tab Panels -->
                    <div class="csmf--tabs-content">
                    <?php endif; ?>
                        <!-- Option Content -->
                        <?php csmf_view('builder.option.content', compact('sections', 'identifier', 'options')); ?>
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