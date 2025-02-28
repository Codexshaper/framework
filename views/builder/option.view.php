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

<div class="cmf cmf--options-wrapper <?php echo esc_attr( $wrapper_class );?>">
    <div class="cmf--container">
        <form 
            method="post" 
            action="<?php echo esc_attr( $form_action );?>" 
            enctype="multipart/form-data" 
            id="cmf--form" 
            autocomplete="off" 
            novalidate="novalidate"
        >
            <input type="hidden" class="cmf--section-id" name="cmf_option[section]" value="1">
            <?php wp_nonce_field( 'cmf_options_nonce', "cmf_options_nonce_{$identifier}" ); ?>

            <div class="cmf--wrapper">
                <!-- Options Header -->
                <?php cmf_view('builder.option.header', compact('args')); ?>
                <!-- Options tab -->
                <?php if($show_tab) : ?>
                <div class="cmf--tabs" data-cmf-tabs>
                <?php endif; ?>
                    <?php if($show_tab) : ?>
                    <!-- Tab Navigation -->
                    <div class="cmf--tabs-nav" role="tablist">
                        <?php cmf_view('builder.option.tabs', compact('args', 'tabs'))?>
                    </div>
                    <?php endif; ?>
                    <?php if($show_tab) : ?>
                    <!-- Tab Panels -->
                    <div class="cmf--tabs-content">
                    <?php endif; ?>
                        <!-- Option Content -->
                        <?php cmf_view('builder.option.content', compact('sections', 'identifier', 'options')); ?>
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