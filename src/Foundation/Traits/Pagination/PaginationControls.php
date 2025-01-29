<?php
/**
 * Pagination Controls Trait file
 *
 * @category   Pagination
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Traits\Pagination;

use CodexShaper\Framework\Foundation\Traits\Button\ButtonControls;
use Elementor\Controls_Manager;

/**
 *  Pagination Controls trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait PaginationControls {

	use ButtonControls;

	/**
	 * Register Pagination Section Controls
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_pagination_section_controls() {
		$paginationTypes = array(
			''                          => esc_html__( 'None', 'codexshaper-framework' ),
			'numbers'                   => esc_html__( 'Numbers', 'codexshaper-framework' ),
			'prev_next'                 => esc_html__( 'Previous/Next', 'codexshaper-framework' ),
			'numbers_and_prev_next'     => esc_html__( 'Numbers', 'codexshaper-framework' ) . ' + ' . esc_html__( 'Previous/Next', 'codexshaper-framework' ),
			'load_more_on_click'        => esc_html__( 'Load on Click', 'codexshaper-framework' ),
			'load_more_infinite_scroll' => esc_html__( 'Infinite Scroll', 'codexshaper-framework' ),
		);

		$this->start_controls_section(
			'section_pagination',
			array(
				'label' => esc_html__( 'Pagination', 'codexshaper-framework' ),
			)
		);

		$this->add_control(
			'pagination_type',
			array(
				'label'              => esc_html__( 'Pagination', 'codexshaper-framework' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => '',
				'options'            => $paginationTypes,
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'pagination_page_limit',
			array(
				'label'     => esc_html__( 'Page Limit', 'codexshaper-framework' ),
				'default'   => '5',
				'condition' => array(
					'pagination_type!' => array(
						'load_more_on_click',
						'load_more_infinite_scroll',
						'',
					),
				),
			)
		);

		$this->add_control(
			'pagination_numbers_shorten',
			array(
				'label'     => esc_html__( 'Shorten', 'codexshaper-framework' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'pagination_type' => array(
						'numbers',
						'numbers_and_prev_next',
					),
				),
			)
		);

		$this->add_control(
			'pagination_prev_label',
			array(
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
			)
		);

		$this->add_control(
			'pagination_next_label',
			array(
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
			)
		);

		$this->add_control(
			'pagination_align',
			array(
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
			)
		);

		$this->add_control(
			'pagination_individual_divider',
			array(
				'type'      => Controls_Manager::DIVIDER,
				'condition' => array(
					'pagination_type' => array(
						'numbers',
						'numbers_and_prev_next',
						'prev_next',
					),
				),
			)
		);

		$this->add_control(
			'pagination_individual_handle',
			array(
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
			)
		);

		$this->add_control(
			'pagination_individual_handle_message',
			array(
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
			)
		);

		$this->add_control(
			'load_more_spinner',
			array(
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
			)
		);

		$this->register_button_content_controls();

		$this->add_control(
			'heading_load_more_no_posts_message',
			array(
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
			)
		);

		$this->add_responsive_control(
			'load_more_no_posts_message_align',
			array(
				'label'     => esc_html__( 'Alignment', 'codexshaper-framework' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
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
				'selectors' => array(
					'{{WRAPPER}}' => '--load-more-message-alignment: {{VALUE}};',
				),
				'condition' => array(
					'pagination_type' => array(
						'load_more_on_click',
						'load_more_infinite_scroll',
					),
				),
			)
		);

		$this->add_control(
			'load_more_no_posts_message_switcher',
			array(
				'label'     => esc_html__( 'Custom Messages', 'codexshaper-framework' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'pagination_type' => array(
						'load_more_on_click',
						'load_more_infinite_scroll',
					),
				),
			)
		);

		$this->add_control(
			'load_more_no_posts_custom_message',
			array(
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
			)
		);

		$this->end_controls_section();
	}
}
