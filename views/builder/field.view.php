<div 
    class="<?php echo esc_attr( "cxf--field cxf--field-{$field_type} {$class}" ); ?>" 
    <?php echo $depend_attributes; ?>
>
    <?php if ( $title ) : ?>
        <div class="cxf--field-title">
            <h4><?php echo esc_html( $title, 'codexshaper-framework' ); ?> </h4>
            <?php if ( $subtitle ) : ?>
                <p class="cxf--subtitle-text"><?php echo esc_html( $subtitle, 'codexshaper-framework' ); ?></p>
            <?php endif; ?>
        </div>
        <div class="cxf--fieldset">
            <?php
                $instance = new $field_class( $field, $value, $identifier, $where, $parent );
                $instance->render();
            ?>
        </div>
    <?php endif; ?>
    <?php if ( $error_messsage || ! empty( $error_messsage ) ) : ?>
        <p><?php echo esc_html( $error_messsage, 'codexshaper-framework' ); ?></p>
    <?php endif; ?>
</div>