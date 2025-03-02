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
     * Action
     *
     * @var string
     */
    protected $action = 'csmf_settings_backup_export';

    /**
	 * Constructor
	 *
	 * @param array  $field Field.
	 * @param string $value Option value.
	 * @param string $identifier Option identifier.
	 * @param string $where Where the field is.
	 * @param string $parent Parent field.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct( $field = array(), $value = '', $identifier = '', $where = '', $parent = '' ) {
		parent::__construct($field, $value, $identifier, $where, $parent);

        $this->action = $this->field['action'] ?? $this->action;
	}

	/**
	 * Render the field
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
        $identifier = $this->identifier;
        $nonce  = wp_create_nonce( 'csmf_backup_nonce' );
        $option_name = $this->field['option_name'] ?? $identifier;
        $export_data = wp_json_encode( get_option( $option_name ) );
        
        if (! $export_data || 'false' === $export_data) {
            $export_data = '';
        }

        $args = array( 
            'action' => $this->action, 
            'identifier' =>  $this->identifier,
            'option_name' => $option_name,
            'json_pretty' => $this->field['json_pretty'] ?? false,
            'nonce' => $nonce 
        );

        $export = add_query_arg( 
            $args, 
            admin_url( 'admin-ajax.php' ) 
        );

        $this->before();

        csmf_view( 'builder.fields.backup', compact(
                'identifier',
                'option_name',
                'nonce',
                'export',
                'export_data',
            ) 
        );

        $this->after();
	}
}
