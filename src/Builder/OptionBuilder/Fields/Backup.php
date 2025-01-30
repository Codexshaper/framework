<?php
/**
 * Backup Field Builder
 *
 * @category   Builder
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Builder\OptionBuilder\Fields;

use CodexShaper\Framework\Foundation\Builder\Field;

/**
 * Backup Field class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Backup extends Field {

	/**
	 * Render the field
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
        $identifier = $this->identifier;
        $nonce  = wp_create_nonce( 'cxf_backup_nonce' );
        $export_data = wp_json_encode( get_option( $identifier ) );
        
        if (! $export_data || 'false' === $export_data) {
            $export_data = '';
        }

        $export = add_query_arg( 
            array( 
                'action' => 'cxf_backup_export', 
                'identifier' =>  $this->identifier, 
                'nonce' => $nonce 
            ), 
            admin_url( 'admin-ajax.php' ) 
        );

        $this->before();

        cxf_view( 'builder.fields.backup', compact(
                'identifier',
                'nonce',
                'export',
                'export_data',
            ) 
        );

        $this->after();
	}
}
