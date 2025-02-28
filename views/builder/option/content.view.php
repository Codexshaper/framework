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

use CodexShaper\Framework\Builder\OptionBuilder\Section;

?>

<div class="cmf--options-content">
    <div class="cmf--sections">
        <?php 
            foreach ( $sections as $section ){
                Section::render( $section, $identifier, $options );
            }
        ?>
    </div>
</div>