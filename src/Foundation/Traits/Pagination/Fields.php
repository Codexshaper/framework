<?php
/**
 * Pagination Fields Trait file
 *
 * @category   Pagination
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
namespace CodexShaper\Framework\Foundation\Traits\Pagination;

use Elementor\Controls_Manager;

/**
 *  Pagination trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Fields {

	/**
	 * Fields
	 *
	 * @var array $fields.
	 */
	protected static $fields;

	/**
	 * Get fields
	 *
	 * @since 1.0.0
	 *
	 * @return array Fields.
	 */
	protected function init_fields() {
		$args = $this->get_args();
		return $this->init_fields_by_name( $args['name'] );
	}

	/**
	 * Initialize fields by name
	 *
	 * @since 1.0.0
	 *
	 * @return array Fields.
	 */
	protected function init_fields_by_name( $name ) {
		$fields          = array();
		$name           .= '_';
		$paginationTypes = array(
			''                          => esc_html__( 'None', 'codexshaper-framework' ),
			'numbers'                   => esc_html__( 'Numbers', 'codexshaper-framework' ),
			'prev_next'                 => esc_html__( 'Previous/Next', 'codexshaper-framework' ),
			'numbers_and_prev_next'     => esc_html__( 'Numbers', 'codexshaper-framework' ) . ' + ' . esc_html__( 'Previous/Next', 'codexshaper-framework' ),
			'load_more_on_click'        => esc_html__( 'Load on Click', 'codexshaper-framework' ),
			'load_more_infinite_scroll' => esc_html__( 'Infinite Scroll', 'codexshaper-framework' ),
		);

		$fields['pagination_type'] = array(
			'label'              => esc_html__( 'Pagination', 'codexshaper-framework' ),
			'type'               => Controls_Manager::SELECT,
			'default'            => '',
			'options'            => $paginationTypes,
			'frontend_available' => true,
		);

		$fields['pagination_page_limit'] = array(
			'label'     => esc_html__( 'Page Limit', 'codexshaper-framework' ),
			'default'   => '5',
			'condition' => array(
				'pagination_type!' => array(
					'load_more_on_click',
					'load_more_infinite_scroll',
					'',
				),
			),
		);

		$fields['pagination_numbers_shorten'] = array(
			'label'     => esc_html__( 'Shorten', 'codexshaper-framework' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => '',
			'condition' => array(
				'pagination_type' => array(
					'numbers',
					'numbers_and_prev_next',
				),
			),
		);

		$fields['pagination_prev_label'] = array(
			'label'     => esc_html__( 'Previous Label', 'codexshaper-framework' ),
			'dynamic'   => array(
				'active' => true,
			),
			'default'   => esc_html__( '&laquo; Previous', 'codexshaper-framework' ),
			'condition' => array(
				'pagination_type' => array(
					'prev_next',
					'numbers_and_prev_next',
				),
			),
		);

		$fields['pagination_next_label'] = array(
			'label'     => esc_html__( 'Next Label', 'codexshaper-framework' ),
			'default'   => esc_html__( 'Next &raquo;', 'codexshaper-framework' ),
			'condition' => array(
				'pagination_type' => array(
					'prev_next',
					'numbers_and_prev_next',
				),
			),
			'dynamic'   => array(
				'active' => true,
			),
		);

		$fields['pagination_align'] = array(
			'label'     => esc_html__( 'Alignment', 'codexshaper-framework' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'codexshaper-framework' ),
					'icon'  => 'eicon-text-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'codexshaper-framework' ),
					'icon'  => 'eicon-text-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'codexshaper-framework' ),
					'icon'  => 'eicon-text-align-right',
				),
			),
			'default'   => 'center',
			'selectors' => array(
				'{{WRAPPER}} .elementor-pagination' => 'text-align: {{VALUE}};',
			),
			'condition' => array(
				'pagination_type!' => array(
					'load_more_on_click',
					'load_more_infinite_scroll',
					'',
				),
			),
		);

		$fields['pagination_individual_divider'] = array(
			'type'      => Controls_Manager::DIVIDER,
			'condition' => array(
				'pagination_type' => array(
					'numbers',
					'numbers_and_prev_next',
					'prev_next',
				),
			),
		);

		$fields['pagination_individual_handle'] = array(
			'label'     => esc_html__( 'Individual Pagination', 'codexshaper-framework' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'On', 'codexshaper-framework' ),
			'label_off' => esc_html__( 'Off', 'codexshaper-framework' ),
			'default'   => '',
			'condition' => array(
				'pagination_type' => array(
					'numbers',
					'numbers_and_prev_next',
					'prev_next',
				),
			),
		);

		$fields['pagination_individual_handle_message'] = array(
			'type'            => Controls_Manager::RAW_HTML,
			'raw'             => esc_html__( 'For multiple Posts Widgets on the same page, toggle this on to control the pagination for each individually. Note: It affects the page\'s URL structure.', 'codexshaper-framework' ),
			'content_classes' => 'elementor-control-field-description',
			'condition'       => array(
				'pagination_type' => array(
					'numbers',
					'numbers_and_prev_next',
					'prev_next',
				),
			),
		);

		$fields['load_more_spinner'] = array(
			'label'                  => esc_html__( 'Spinner', 'codexshaper-framework' ),
			'type'                   => Controls_Manager::ICONS,
			'fa4compatibility'       => 'icon',
			'default'                => array(
				'value'   => 'fas fa-spinner',
				'library' => 'fa-solid',
			),
			'exclude_inline_options' => array( 'svg' ),
			'recommended'            => array(
				'fa-solid' => array(
					'spinner',
					'cog',
					'sync',
					'sync-alt',
					'asterisk',
					'circle-notch',
				),
			),
			'skin'                   => 'inline',
			'label_block'            => false,
			'condition'              => array(
				'pagination_type' => array(
					'load_more_on_click',
					'load_more_infinite_scroll',
				),
			),
			'frontend_available'     => true,
		);

		$fields = $this->get_button_fields( $fields );

		$fields['heading_load_more_no_posts_message'] = array(
			'label'     => esc_html__( 'No More Posts Message', 'codexshaper-framework' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => array(
				'pagination_type' => array(
					'load_more_on_click',
					'load_more_infinite_scroll',
				),
			),
			'dynamic'   => array(
				'active' => true,
			),
		);

		$fields['load_more_no_posts_message_align'] = array(
			'label'      => esc_html__( 'Alignment', 'codexshaper-framework' ),
			'type'       => Controls_Manager::CHOOSE,
			'options'    => array(
				'left'    => array(
					'title' => esc_html__( 'Left', 'codexshaper-framework' ),
					'icon'  => 'eicon-text-align-left',
				),
				'center'  => array(
					'title' => esc_html__( 'Center', 'codexshaper-framework' ),
					'icon'  => 'eicon-text-align-center',
				),
				'right'   => array(
					'title' => esc_html__( 'Right', 'codexshaper-framework' ),
					'icon'  => 'eicon-text-align-right',
				),
				'justify' => array(
					'title' => esc_html__( 'Justified', 'codexshaper-framework' ),
					'icon'  => 'eicon-text-align-justify',
				),
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}' => '--load-more-message-alignment: {{VALUE}};',
			),
			'condition'  => array(
				'pagination_type' => array(
					'load_more_on_click',
					'load_more_infinite_scroll',
				),
			),
		);

		$fields['load_more_no_posts_message_switcher'] = array(
			'label'     => esc_html__( 'Custom Messages', 'codexshaper-framework' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => '',
			'condition' => array(
				'pagination_type' => array(
					'load_more_on_click',
					'load_more_infinite_scroll',
				),
			),
		);

		$fields['load_more_no_posts_custom_message'] = array(
			'label'       => esc_html__( 'No more posts message', 'codexshaper-framework' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__( 'No more posts to show', 'codexshaper-framework' ),
			'condition'   => array(
				'pagination_type'                     => array(
					'load_more_on_click',
					'load_more_infinite_scroll',
				),
				'load_more_no_posts_message_switcher' => 'yes',
			),
			'label_block' => true,
			'dynamic'     => array(
				'active' => true,
			),
		);

		return $fields;
	}

	/**
	 * Get button fields
	 *
	 * @since 1.0.0
	 *
	 * @param array $fields Fields.
	 *
	 * @return array Fields.
	 */
	protected function get_button_fields( $fields = array() ) {

		$fields['heading_load_more_button'] = array(
			'label'     => esc_html__( 'Button', 'codexshaper-framework' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => array(
				'pagination_type' => 'load_more_on_click',
			),
		);

		$options = array(
			'button_text'            => esc_html__( 'Load More', 'codexshaper-framework' ),
			'control_label_name'     => esc_html__( 'Button Text', 'codexshaper-framework' ),
			'section_condition'      => array(
				'pagination_type' => 'load_more_on_click',
			),
			'exclude_inline_options' => array( 'svg' ),
		);

		$fields['heading_load_more_button'] = array(
			'label'     => esc_html__( 'Button', 'codexshaper-framework' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => array(
				'pagination_type' => 'load_more_on_click',
			),
		);

		$fields['text'] = array(
			'label'       => $options['control_label_name'],
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => array(
				'active' => true,
			),
			'default'     => $options['button_text'],
			'placeholder' => $options['button_text'],
			'condition'   => $options['section_condition'],
		);

		$fields['selected_icon'] = array(
			'label'                  => esc_html__( 'Icon', 'codexshaper-framework' ),
			'type'                   => Controls_Manager::ICONS,
			'fa4compatibility'       => 'icon',
			'skin'                   => 'inline',
			'label_block'            => false,
			'condition'              => $options['section_condition'],
			'exclude_inline_options' => $options['exclude_inline_options'],
		);

		$start = is_rtl() ? 'right' : 'left';
		$end   = is_rtl() ? 'left' : 'right';

		$fields['icon_align'] = array(
			'label'                => esc_html__( 'Icon Position', 'codexshaper-framework' ),
			'type'                 => Controls_Manager::CHOOSE,
			'default'              => is_rtl() ? 'row-reverse' : 'row',
			'options'              => array(
				'row'         => array(
					'title' => esc_html__( 'Start', 'codexshaper-framework' ),
					'icon'  => "eicon-h-align-{$start}",
				),
				'row-reverse' => array(
					'title' => esc_html__( 'End', 'codexshaper-framework' ),
					'icon'  => "eicon-h-align-{$end}",
				),
			),
			'selectors_dictionary' => array(
				'left'  => is_rtl() ? 'row-reverse' : 'row',
				'right' => is_rtl() ? 'row' : 'row-reverse',
			),
			'selectors'            => array(
				'{{WRAPPER}} .elementor-button-content-wrapper' => 'flex-direction: {{VALUE}};',
			),
			'condition'            => array_merge(
				$options['section_condition'],
				array(
					'text!'                 => '',
					'selected_icon[value]!' => '',
				)
			),
		);

		$fields['icon_indent'] = array(
			'label'      => esc_html__( 'Icon Spacing', 'codexshaper-framework' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array( 'px', 'em', 'rem', 'custom' ),
			'range'      => array(
				'px'  => array(
					'max' => 50,
				),
				'em'  => array(
					'max' => 5,
				),
				'rem' => array(
					'max' => 5,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .elementor-button .elementor-button-content-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array_merge(
				$options['section_condition'],
				array(
					'text!'                 => '',
					'selected_icon[value]!' => '',
				)
			),
		);

		$fields['button_css_id'] = array(
			'label'       => esc_html__( 'Button ID', 'codexshaper-framework' ),
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => array(
				'active' => true,
			),
			'ai'          => array(
				'active' => false,
			),
			'default'     => '',
			'title'       => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'codexshaper-framework' ),
			'description' => sprintf(
				esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page.', 'codexshaper-framework' ),
				'<code>',
				'</code>'
			),
			'separator'   => 'before',
			'condition'   => $options['section_condition'],
		);

		return $fields;
	}
}
