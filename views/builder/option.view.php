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
                <div class="cxf--option-header">
                    <input 
                        type="submit" 
                        class="button cxf--a-btn cxf--a-btn-primary cxf--option-save" 
                        name="cxf_option[save]" 
                        class="submit" 
                        value="<?php echo esc_html__( 'Save', 'codexshaper-framework' ); ?>"
                    >
                </div>
                
                <div class="cxf--options-content">

                    <div class="cxf--sections">

                        <?php foreach ( $sections as $section ):
                            $section_class  = $section['class'] ?? '';   
                            $section_class .= ' cxf--builder-init';
                            $section_icon   = $section['icon'] ?? '';
                            $section_title  = $section['title'] ?? '';
                            $section_parent = isset($section['parent_title']) ? sanitize_title( $section['parent_title'] ) . '/' : '';
                            $section_slug   =  sanitize_title( $section_title );
                            $section_id = "{$section_parent}{$section_slug}";
                            $section_description = $section['description'] ?? '';
                        ?>
                            <div 
                                class="cxf--section <?php echo esc_attr( $section_class );?>" 
                                data-section-id="<?php echo esc_attr( $section_id ); ?>"
                            >
                                <!-- Section Title -->
                                <?php if ( $section_title || $section_icon ) : ?>
                                    <div class="cxf--section-title">
                                        <h3>
                                            <!-- Section Icon -->
                                            <?php if(! empty( $section_icon )): ?>
                                                <i class="cxf--section-icon <?php echo esc_attr( $section['icon'] ); ?>"></i>
                                            <?php endif; ?>
                                            <!-- Section Title -->
                                            <?php echo $section_title; ?>
                                        </h3>
                                    </div>
                                <?php endif; ?>
                                <!-- Section Description -->
                                <?php if ( $section_description ) : ?>
                                    <div class="cxf--field cxf--section-description"><?php echo wp_kses($section_description, $allowed_html); ?></div>
                                <?php endif; ?>
                                <!-- No field found -->
                                <?php if(empty( $section['fields'] )): ?>
                                    <p class="cxf--no-option"><?php echo esc_html__( 'No filed found.', 'codexshaper-framework' ); ?></p>
                                <?php endif; ?>
                                <!-- Option Fields -->
                                <?php
                                    foreach ( $section['fields'] as $field ) {

                                        $parent = 'options';

                                        cxf_view(
                                            'builder.fields.field', 
                                            compact(
                                                'identifier', 
                                                'field', 
                                                'options',
                                                'parent',
                                            )
                                        );
                                    }
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>