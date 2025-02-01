<?php
/**
 * Option Tabs View
 *
 * @category   View
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 * @version    1.0.0
 */

 $show_tab = $args['show_tab'] ?? true;

if ( ! $show_tab || count($tabs) < 1 ) {
    return;
}
?>

<ul>
<?php foreach ( $tabs as $tab ):
    $tab_title = $tab['title'] ?? '';
    $tab_id    = sanitize_title( $tab_title );
    $tab_error = '';
    $tab_icon  = $tab['icon'] ?? '';
?>
    <!-- Single tab item. -->
    <?php if ( empty( $tab['children'] ) ): ?>
        <li class="cxf--tab-item">
            <button 
                type="button" 
                class="cxf--tab-btn active" 
                data-cxf-tab="tab_<?php echo esc_attr( $tab_id ); ?>" 
                role="tab" 
                aria-selected="true" 
                aria-controls="panel_<?php echo esc_attr( $tab_id ); ?>"
            >
                <?php if($tab_icon): ?>
                    <i class="cxf--tab-icon <?php echo esc_attr( $tab_icon ); ?>"></i>
                <?php endif; ?>
                <?php if($tab_title): ?>
                    <?php echo esc_html($tab_title); ?>
                <?php endif; ?>
                <?php if($tab_error): ?>
                    <?php echo esc_html($tab_error); ?>
                <?php endif; ?>
            </button>
        </li>
        <?php continue; ?>
    <?php endif; ?>
        <!-- Tab item with children. -->
        <li class="cxf--tab-item cxf--tab-has-children">
            <button 
                type="button" 
                class="cxf--tab-btn active" 
                data-cxf-tab="tab_<?php echo esc_attr( $tab_id ); ?>" 
                role="tab" 
                aria-selected="true" 
                aria-controls="panel_<?php echo esc_attr( $tab_id ); ?>"
            >
                <?php if($tab_icon): ?>
                    <i class="cxf--tab-icon <?php echo esc_attr( $tab_icon ); ?>"></i>
                <?php endif; ?>
                <?php if($tab_title): ?>
                    <?php echo esc_html($tab_title); ?>
                <?php endif; ?>
                <?php if($tab_error): ?>
                    <?php echo esc_html($tab_error); ?>
                <?php endif; ?>
            </button>
            <!-- Tab children. -->
            <ul>
                <?php foreach ( $tab['children'] as $children ):

                    $children_id    = $tab_id .'/'. sanitize_title( $children['title'] );
                    $children_error = '';
                    $children_icon  = $children['icon'] ?? '';
                ?>
                    <li>
                        <button 
                            type="button" 
                            class="cxf--tab-btn active" 
                            data-cxf-tab="tab_<?php echo esc_attr( $children_id ); ?>" 
                            role="tab" 
                            aria-selected="true" 
                            aria-controls="panel_<?php echo esc_attr( $children_id ); ?>"
                        >
                            <?php if($children_icon): ?>
                                <i class="cxf--tab-icon <?php echo esc_attr( $children_icon ); ?>"></i>
                            <?php endif; ?>
                            <?php if($tab_title): ?>
                                <?php echo esc_html($tab_title); ?>
                            <?php endif; ?>
                            <?php if($children_error): ?>
                                <?php echo esc_html($children_error); ?>
                            <?php endif; ?>    
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>