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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$show_tab = $args['show_tab'] ?? true;

if ( ! $show_tab || count($tabs) < 1 ) {
    return;
}
?>

<ul>
<?php foreach ( $tabs as $key => $tab ):
    $tab_title = $tab['title'] ?? '';
    $tab_id    = sanitize_title( $tab_title );
    $tab_error = '';
    $tab_icon  = $tab['icon'] ?? '';
?>
    <!-- Single tab item. -->
    <?php if ( empty( $tab['children'] ) ): ?>
        <li class="csmf--tab-item">
            <a 
                href="#<?php echo esc_attr( $tab_id ); ?>" 
                class="csmf--tab-btn" 
                data-csmf-tab="<?php echo esc_attr( $tab_id ); ?>" 
                role="tab" 
                aria-selected="true" 
                aria-controls="panel_<?php echo esc_attr( $tab_id ); ?>"
            >
                <?php if($tab_icon): ?>
                    <i class="csmf--tab-icon <?php echo esc_attr( $tab_icon ); ?>"></i>
                <?php endif; ?>
                <?php if($tab_title): ?>
                    <?php echo esc_html($tab_title); ?>
                <?php endif; ?>
                <?php if($tab_error): ?>
                    <?php echo esc_html($tab_error); ?>
                <?php endif; ?>
            </a>
        </li>
        <?php continue; ?>
    <?php endif; ?>
        <!-- Tab item with children. -->
        <li class="csmf--tab-item csmf--tab-has-children <?php echo $key === 0 ? 'expanded' : ''; ?>">
            <a 
                href="#<?php echo esc_attr( $tab_id . '/' . sanitize_title($tab['children'][0]['title'])); ?>"
                class="csmf--tab-btn" 
                data-csmf-tab="<?php echo esc_attr( $tab_id . '/' . sanitize_title($tab['children'][0]['title'])); ?>" 
                role="tab" 
                aria-selected="true" 
                aria-controls="panel_<?php echo esc_attr( $tab_id . '/' . sanitize_title($tab['children'][0]['title'])); ?>"
            >
                <?php if($tab_icon): ?>
                    <i class="csmf--tab-icon <?php echo esc_attr( $tab_icon ); ?>"></i>
                <?php endif; ?>
                <?php if($tab_title): ?>
                    <?php echo esc_html($tab_title); ?>
                <?php endif; ?>
                <?php if($tab_error): ?>
                    <?php echo esc_html($tab_error); ?>
                <?php endif; ?>
            </a>
            <!-- Tab children. -->
            <ul>
                <?php foreach ( $tab['children'] as $children ):

                    $children_title = $children['title'] ?? '';
                    $children_id    = $tab_id .'/'. sanitize_title( $children_title );
                    $children_error = '';
                    $children_icon  = $children['icon'] ?? '';
                ?>
                    <li class="csmf--tab-item">
                        <a 
                            href="#<?php echo esc_attr( $children_id ); ?>" 
                            class="csmf--tab-btn" 
                            data-csmf-tab="<?php echo esc_attr( $children_id ); ?>" 
                            role="tab" 
                            aria-selected="true" 
                            aria-controls="panel_<?php echo esc_attr( $children_id ); ?>"
                        >
                            <?php if($children_icon): ?>
                                <i class="csmf--tab-icon <?php echo esc_attr( $children_icon ); ?>"></i>
                            <?php endif; ?>
                            <?php if($children_title): ?>
                                <?php echo esc_html($children_title); ?>
                            <?php endif; ?>
                            <?php if($children_error): ?>
                                <?php echo esc_html($children_error); ?>
                            <?php endif; ?>    
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>