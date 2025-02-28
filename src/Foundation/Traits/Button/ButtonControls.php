<?php
/**
 * Button Control Trait file
 *
 * @category   Button
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
namespace CodexShaper\Framework\Foundation\Traits\Button;

use Elementor\Controls_Manager;

/**
 *  Button Controls trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait ButtonControls {

	/**
	 * Register button content controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_button_content_controls() {

		$options = array(
			'button_text'            => esc_html__( 'Load More', 'codexshaper-framework' ),
			'control_label_name'     => esc_html__( 'Button Text', 'codexshaper-framework' ),
			'section_condition'      => array(
				'pagination_type' => 'load_more_on_click',
			),
			'exclude_inline_options' => array( 'svg' ),
		);

		$this->add_control(
			'heading_load_more_button',
			array(
				'label'     => esc_html__( 'Button', 'codexshaper-framework' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'pagination_type' => 'load_more_on_click',
				),
			)
		);

		$this->add_control(
			'text',
			array(
				'label'       => $options['control_label_name'],
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => $options['button_text'],
				'placeholder' => $options['button_text'],
				'condition'   => $options['section_condition'],
			)
		);

		$this->add_control(
			'selected_icon',
			array(
				'label'                  => esc_html__( 'Icon', 'codexshaper-framework' ),
				'type'                   => Controls_Manager::ICONS,
				'fa4compatibility'       => 'icon',
				'skin'                   => 'inline',
				'label_block'            => false,
				'condition'              => $options['section_condition'],
				'exclude_inline_options' => $options['exclude_inline_options'],
			)
		);

		$start = is_rtl() ? 'right' : 'left';
		$end   = is_rtl() ? 'left' : 'right';

		$this->add_control(
			'icon_align',
			array(
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
			)
		);

		$this->add_control(
			'icon_indent',
			array(
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
			)
		);

		$this->add_control(
			'button_css_id',
			array(
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
			)
		);
	}
}
