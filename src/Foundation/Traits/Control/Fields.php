<?php
/**
 * Control Field Trait file
 *
 * @category   Control
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Traits\Control;

use CodexShaper\Framework\Models\Post\Post;
use CodexShaper\Framework\Models\Taxonomies\Taxonomy;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;

/**
 *  Control Field trait
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
	 */
	protected $fields = array();

	/**
	 * Get fields
	 *
	 * @param string $name
	 *
	 * @since 1.0.0
	 * @return array
	 */
	protected function get_taxonomy_fields( $name = '' ) {
		$post_type_args     = array();
		$default_post_types = array();
		$post_types         = Post::get_public_types( $post_type_args, $default_post_types );
		$taxonomies         = Taxonomy::get_supported_taxonomies( $post_types );

		$name = $name ? "{$name}_" : '';

		$post_types = array_merge(
			array( 'all' => 'All' ),
			$post_types,
		);

		$this->add_control(
			"{$name}query_type",
			array(
				'label'   => esc_html__( 'Query Type', 'codexshaper-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => array(
					'custom'        => esc_html__( 'Custom', 'codexshaper-framework' ),
					'current_query' => esc_html__( 'Current Query', 'codexshaper-framework' ),
				),
			)
		);

		$this->add_control(
			"{$name}post_type",
			array(
				'label'     => esc_html__( 'Post Type', 'codexshaper-framework' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $post_types,
				'default'   => 'post',
				'condition' => array(
					'query_type!' => 'current_query',
				),
			)
		);

		$this->add_control(
			"{$name}taxonomies",
			array(
				'label'       => esc_html__( 'Taxonomy', 'codexshaper-framework' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $taxonomies,
				'default'     => 'category',
				'label_block' => true,
				'multiple'    => true,
			)
		);
	}

	/**
	 * Get Text Controls
	 *
	 * @param string $prefix Controls prefix.
	 * @param object $element Elementor object.
	 * @param array  $controls Controls array.
	 * @param array  $options Options array.
	 *
	 * @since 1.0.0
	 * @return array $controls Text controls.
	 */
	public function common_text_controls( $prefix, $element = null, $controls = array(), $options = array(), ) {

		if ( ! $element ) {
			$element = $this;
		}

		$title      = ucwords( $prefix );
		$selector   = $options['selector'] ?? '';
		$selectors  = $options['selectors'] ?? array();
		$condition = $options['condition'] ?? array();
		$conditions = $options['conditions'] ?? array();
		$excludes    = $options['excludes'] ?? array();

		$fields = array(
			Group_Control_Typography::get_type()  => array(
				'is_group' => true,
				'args'     => array(
					'name'      => $prefix,
					'label'     => __( 'Typography', 'codexshaper-framework' ),
					'selector'  => "{$selector}",
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),
			"{$prefix}_text_color"                => array(
				'is_group'      => false,
				'is_responsive' => false,
				'args'          => array(
					'label'     => esc_html__( 'Color', 'codexshaper-framework' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						"{$selector}" => 'color: {{VALUE}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),
			Group_Control_Text_Stroke::get_type() => array(
				'is_group' => true,
				'args'     => array(
					'name'      => "{$prefix}_text_stroke",
					'selector'  => "{$selector}",
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),
			Group_Control_Text_Shadow::get_type() => array(
				'is_group' => true,
				'args'     => array(
					'name'      => "{$prefix}_text_shadow",
					'selector'  => "{$selector}",
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),
		);

		$fields = array_replace_recursive( $fields, $controls );

		foreach ( $fields as $name => $field ) {
			if ( in_array( $name, $excludes ) ) {
				continue;
			}

			$isGroup      = $field['is_group'] ?? false;
			$isResponsive = $field['is_responsive'] ?? false;
			$args         = $field['args'] ?? array();

			if ( $isGroup ) {
				$element->add_group_control( $name, $args );
				continue;
			}

			if ( $isResponsive ) {
				$element->add_responsive_control( $name, $args );
				continue;
			}

			$element->add_control( $name, $args );
		}
	}

	/**
	 * Get Space Controls
	 *
	 * @param string $prefix Controls prefix.
	 * @param object $element Elementor object.
	 * @param array  $controls Controls array.
	 * @param array  $options Options array.
	 *
	 * @since 1.0.0
	 * @return array $controls Space controls.
	 */
	public function common_space_controls( $prefix, $element = null, $controls = array(), $options = array() ) {

		if ( ! $element ) {
			$element = $this;
		}

		$title      = ucwords( $prefix );
		$selector   = $options['selector'] ?? '';
		$selectors  = $options['selectors'] ?? array();
		$condition = $options['condition'] ?? array();
		$conditions = $options['conditions'] ?? array();
		$excludes    = $options['excludes'] ?? array();

		$fields = array(

			"{$prefix}_padding" => array(
				'is_group'      => false,
				'is_responsive' => false,
				'args'          => array(
					'label'      => esc_html__( 'Padding', 'codexshaper-framework' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'selectors'  => array(
						"{$selector}" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

			"{$prefix}_margin"  => array(
				'is_group'      => false,
				'is_responsive' => false,
				'args'          => array(
					'label'      => esc_html__( 'Margin', 'codexshaper-framework' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'selectors'  => array(
						"{$selector}" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),
		);

		$fields = array_replace_recursive( $fields, $controls );

		foreach ( $fields as $name => $field ) {
			if ( in_array( $name, $excludes ) ) {
				continue;
			}

			$isGroup      = $field['is_group'] ?? false;
			$isResponsive = $field['is_responsive'] ?? false;
			$args         = $field['args'] ?? array();

			if ( $isGroup ) {
				$element->add_group_control( $name, $args );
				continue;
			}

			if ( $isResponsive ) {
				$element->add_responsive_control( $name, $args );
				continue;
			}

			$element->add_control( $name, $args );
		}
	}

	/**
	 * Get Image Controls
	 *
	 * @param string $prefix Controls prefix.
	 * @param object $element Elementor object.
	 * @param array  $controls Controls array.
	 * @param array  $options Options array.
	 *
	 * @since 1.0.0
	 * @return array $controls Image controls.
	 */
	public function common_image_controls( $prefix, $element = null, $controls = array(), $options = array() ) {

		if ( ! $element ) {
			$element = $this;
		}

		$title          = ucwords( $prefix );
		$selector       = $options['selector'] ?? '';
		$selector_hover = $options['selector_hover'] ?? '';
		$selectors      = $options['selectors'] ?? array();
		$condition = $options['condition'] ?? array();
		$conditions = $options['conditions'] ?? array();
		$excludes        = $options['excludes'] ?? array();

		$fields = array(
			"{$prefix}_width"                    => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__( 'Width', 'codexshaper-framework' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%', 'em', 'rem', 'vh', 'custom' ),
					'selectors'  => array(
						"{$selector}" => 'width: {{SIZE}}{{UNIT}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

			"{$prefix}_max_width"                => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__( 'Max Width', 'codexshaper-framework' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%', 'em', 'rem', 'vh', 'custom' ),
					'selectors'  => array(
						"{$selector}" => 'max-width: {{SIZE}}{{UNIT}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

			"{$prefix}_height"                   => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__( 'Height', 'codexshaper-framework' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%', 'em', 'rem', 'vh', 'custom' ),
					'selectors'  => array(
						"{$selector}" => 'height: {{SIZE}}{{UNIT}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

			"{$prefix}_object_fit"               => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'     => esc_html__( 'Object-Fit', 'codexshaper-framework' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'fill'       => esc_html__( 'Fill ', 'codexshaper-framework' ),
						'contain'    => esc_html__( 'Contain', 'codexshaper-framework' ),
						'cover'      => esc_html__( 'Cover', 'codexshaper-framework' ),
						'none'       => esc_html__( 'None', 'codexshaper-framework' ),
						'scale-down' => esc_html__( 'Scale-down', 'codexshaper-framework' ),
					),
					'selectors' => array(
						"{$selector}" => 'object-fit: {{VALUE}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

			Group_Control_Css_Filter::get_type() => array(
				'is_group'      => true,
				'is_responsive' => false,
				'args'          => array(
					'name'      => "{$prefix}_css_filters",
					'selector'  => "{$selector}",
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

			"{$prefix}_opacity"                  => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'     => esc_html__( 'Opacity', 'codexshaper-framework' ),
					'type'      => Controls_Manager::NUMBER,
					'selectors' => array(
						"{$selector}" => 'opacity: {{SIZE}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

			"{$prefix}_transition"               => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'     => esc_html__( 'Transition(s)', 'codexshaper-framework' ),
					'type'      => Controls_Manager::NUMBER,
					'selectors' => array(
						"{$selector}" => 'transition: {{SIZE}}s;',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),
			Group_Control_Border::get_type()     => array(
				'is_group'      => true,
				'is_responsive' => false,
				'args'          => array(
					'name'     => "{$prefix}_image_border",
					'selector' => "{$selector}",
				),
			),

			"{$prefix}_image_border_radius"      => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__( 'Radius', 'codexshaper-framework' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'separator'  => 'before',
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'selectors'  => array(
						"{$selector}" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

		);

		$fields = array_replace_recursive( $fields, $controls );

		foreach ( $fields as $name => $field ) {
			if ( in_array( $name, $excludes ) ) {
				continue;
			}

			$isGroup      = $field['is_group'] ?? false;
			$isResponsive = $field['is_responsive'] ?? false;
			$args         = $field['args'] ?? array();

			if ( $isGroup ) {
				$element->add_group_control( $name, $args );
				continue;
			}

			if ( $isResponsive ) {
				$element->add_responsive_control( $name, $args );
				continue;
			}

			$element->add_control( $name, $args );
		}
	}

	/**
	 * Get Icon Controls
	 *
	 * @param string $prefix Controls prefix.
	 * @param object $element Elementor object.
	 * @param array  $controls Controls array.
	 * @param array  $options Options array.
	 *
	 * @since 1.0.0
	 * @return array $controls Icon controls.
	 */
	public function common_icon_controls( $prefix, $element = null, $controls = array(), $options = array() ) {

		if ( ! $element ) {
			$element = $this;
		}

		$title      = ucwords( $prefix );
		$selector   = $options['selector'] ?? '';
		$selectors  = $options['selectors'] ?? array();
		$condition = $options['condition'] ?? array();
		$conditions = $options['conditions'] ?? array();
		$excludes    = $options['excludes'] ?? array();

		$fields = array(
			"{$prefix}_icon_size"  => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__( 'Size', 'codexshaper-framework' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%', 'custom' ),
					'selectors'  => array(
						"{$selector} i"   => 'font-size: {{SIZE}}{{UNIT}};',
						"{$selector} svg" => 'width: {{SIZE}}{{UNIT}};',
					),
					'condition'  => $condition,
					'conditions'  => $conditions,
				),
			),

			"{$prefix}_icon_color" => array(
				'is_group' => false,
				'args'     => array(
					'label'     => esc_html__( 'Color', 'codexshaper-framework' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						"{$selector} svg" => 'fill: {{VALUE}};',
						"{$selector} i"   => 'color: {{VALUE}};',
					),
					'condition' => $condition,
					'conditions'  => $conditions,
				),
			),
		);

		$fields = array_replace_recursive( $fields, $controls );

		foreach ( $fields as $name => $field ) {
			if ( in_array( $name, $excludes ) ) {
				continue;
			}

			$isGroup      = $field['is_group'] ?? false;
			$isResponsive = $field['is_responsive'] ?? false;
			$args         = $field['args'] ?? array();

			if ( $isGroup ) {
				$element->add_group_control( $name, $args );
				continue;
			}

			if ( $isResponsive ) {
				$element->add_responsive_control( $name, $args );
				continue;
			}

			$element->add_control( $name, $args );
		}
	}

	/**
	 * Get Layout Controls
	 *
	 * @param string $prefix Controls prefix.
	 * @param object $element Elementor object.
	 * @param array  $controls Controls array.
	 * @param array  $options Options array.
	 *
	 * @since 1.0.0
	 * @return array $controls Layout controls.
	 */
	public function common_layout_controls( $prefix, $element = null, $controls = array(), $options = array() ) {

		if ( ! $element ) {
			$element = $this;
		}

		$title      = ucwords( $prefix );
		$selector   = $options['selector'] ?? '';
		$selectors  = $options['selectors'] ?? array();
		$condition = $options['condition'] ?? array();
		$conditions = $options['conditions'] ?? array();
		$excludes    = $options['excludes'] ?? array();

		$fields = array(

			"{$prefix}_padding"                  => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__( 'Padding', 'codexshaper-framework' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'separator'  => 'before',
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'selectors'  => array(
						"{$selector}" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition'  => $condition,
					'conditions'  => $conditions,
				),
			),

			"{$prefix}_margin"                   => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__( 'Margin', 'codexshaper-framework' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'separator'  => 'before',
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'selectors'  => array(
						"{$selector}" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

			Group_Control_Background::get_type() => array(
				'is_group' => true,
				'args'     => array(
					'name'       => "{$prefix}_background",
					'types'      => array( 'classic', 'gradient' ),
					'separator'  => 'after',
					'selector'   => "{$selector}",
					'responsive' => true,
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

			Group_Control_Border::get_type()     => array(
				'is_group' => true,
				'args'     => array(
					'name'       => "{$prefix}_border",
					'selector'   => "{$selector}",
					'responsive' => true,
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

			"{$prefix}_border_radius"            => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__( 'Border Radius', 'codexshaper-framework' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'separator'  => 'before',
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'selectors'  => array(
						"{$selector}" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => $condition,
					'conditions' => $conditions,
				),
			),

		);

		$fields = array_replace_recursive( $fields, $controls );

		foreach ( $fields as $name => $field ) {
			if ( in_array( $name, $excludes ) ) {
				continue;
			}

			$isGroup      = $field['is_group'] ?? false;
			$isResponsive = $field['is_responsive'] ?? false;
			$args         = $field['args'] ?? array();

			if ( $isGroup ) {
				$element->add_group_control( $name, $args );
				continue;
			}

			if ( $isResponsive ) {
				$element->add_responsive_control( $name, $args );
				continue;
			}

			$element->add_control( $name, $args );
		}
	}

	/**
	 * Get Position Controls
	 *
	 * @param string $prefix Controls prefix.
	 * @param object $element Elementor object.
	 * @param array  $controls Controls array.
	 * @param array  $options Options array.
	 *
	 * @since 1.0.0
	 * @return array $controls Position controls.
	 */
	public function common_position_controls($prefix, $element = null, $controls = array(), $options = array())
	{

		if (! $element) {
			$element = $this;
		}

		$selector   = $options['selector'] ?? '';
		$conditions = $options['conditions'] ?? array();
		$condition = $options['condition'] ?? array();
		$excludes    = $options['excludes'] ?? array();


		$fields = array(

			// Position Control.
			"{$prefix}_position_type"            => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'   => esc_html__('Position Type', 'codexshaper-framework'),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'static'   => esc_html__('Static', 'codexshaper-framework'),
						'relative' => esc_html__('Relative', 'codexshaper-framework'),
						'absolute' => esc_html__('Absolute', 'codexshaper-framework'),
						'fixed'    => esc_html__('Fixed', 'codexshaper-framework'),
					),
					'selectors'  => array(
						"{$selector}" => 'position: {{VALUE}};',
					),
					'condition'  => $condition,
					'conditions'  => $conditions,
				)
			),

			// Vertical Position Control.
			"{$prefix}_vertical_position"            => array(
				'is_group'      => false,
				'is_responsive' => false,
				'args'          => array(
					'label'   => esc_html__('Vertical Alignment', 'codexshaper-framework'),
					'type'    => Controls_Manager::CHOOSE,
					'options' => array(
						'top'    => array(
							'title' => esc_html__('Top', 'codexshaper-framework'),
							'icon'  => 'eicon-v-align-top',
						),
						'bottom' => array(
							'title' => esc_html__('Bottom', 'codexshaper-framework'),
							'icon'  => 'eicon-v-align-bottom',
						),
					),
					'default'    => 'top',
					'toggle'     => false,
					'resposive'  => false,
					'condition'  => $condition,
					'conditions'  => $conditions,

				)
			),

			// Vertical Offset Control
			"{$prefix}_vertical_offset"            => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Vertical Offset', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => ['px', '%', 'em', 'rem', 'custom'],
					'range'      => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => -100,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
					],
					'selectors'  => [
						"{$selector}" => "{{{$prefix}_vertical_position.VALUE}} : {{SIZE}}{{UNIT}};",
					],
					'condition'  => $condition,
					'conditions'  => $conditions,
				)
			),

			// Horizontal Position Control.
			"{$prefix}_horizontal_position"            => array(
				'is_group'      => false,
				'is_responsive' => false,
				'args'          => array(
					'label'   => esc_html__('Horizontal Alignment', 'codexshaper-framework'),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'left'  => [
							'title' => esc_html__('Left', 'codexshaper-framework'),
							'icon'  => 'eicon-h-align-left',
						],
						'right' => [
							'title' => esc_html__('Right', 'codexshaper-framework'),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'default'    => 'left',
					'toggle'     => false,
					'resposive'  => false,
					'condition'  => $condition,
					'conditions'  => $conditions,
				)
			),

			// Horizontal Offset Control.
			"{$prefix}_horizontal_offset"            => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Horizontal Offset', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => ['px', '%', 'em'],
					'range'      => [
						'px' => [
							'min' => -500,
							'max' => 500,
						],
						'%'  => [
							'min' => -100,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
					],
					'selectors'  => [
						"{$selector}" => "{{{$prefix}_horizontal_position.VALUE}} : {{SIZE}}{{UNIT}};",
					],
					'condition'  => $condition,
					'conditions'  => $conditions,

				)

			),
		);


		$fields = array_replace_recursive($fields, $controls);

		foreach ($fields as $name => $field) {
			if (in_array($name, $excludes)) {
				continue;
			}

			$isGroup      = $field['is_group'] ?? false;
			$isResponsive = $field['is_responsive'] ?? false;
			$args         = $field['args'] ?? array();

			if ($isGroup) {
				$element->add_group_control($name, $args);
				continue;
			}

			if ($isResponsive) {
				$element->add_responsive_control($name, $args);
				continue;
			}

			$element->add_control($name, $args);
		}
	}

	/**
	 * Get Size Controls
	 *
	 * @param string $prefix Controls prefix.
	 * @param object $element Elementor object.
	 * @param array  $controls Controls array.
	 * @param array  $options Options array.
	 *
	 * @since 1.0.0
	 * @return array $controls Position controls.
	 */
	public function common_size_controls($prefix, $element = null, $controls = array(), $options = array())
	{

		if (! $element) {
			$element = $this;
		}

		$selector   = $options['selector'] ?? '';
		$conditions = $options['conditions'] ?? array();
		$condition = $options['condition'] ?? array();
		$excludes    = $options['excludes'] ?? array();


		$fields = array(

			"{$prefix}_width"            => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Width', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => ['px', '%', 'em', 'rem', 'custom'],
					'default'    => [
						'unit' => 'px',
					],
					'selectors'  => [
						"{$selector}" => "width : {{SIZE}}{{UNIT}};",
					],
					'condition'  => $condition,
					'conditions'  => $conditions,
				)
			),

			"{$prefix}_height"            => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Height', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => ['px', '%', 'em', 'rem', 'custom'],
					'default'    => [
						'unit' => 'px',
					],
					'selectors'  => [
						"{$selector}" => "height : {{SIZE}}{{UNIT}};",
					],
					'condition'  => $condition,
					'conditions'  => $conditions,
				)
			),

		);


		$fields = array_replace_recursive($fields, $controls);

		foreach ($fields as $name => $field) {
			if (in_array($name, $excludes)) {
				continue;
			}

			$isGroup      = $field['is_group'] ?? false;
			$isResponsive = $field['is_responsive'] ?? false;
			$args         = $field['args'] ?? array();

			if ($isGroup) {
				$element->add_group_control($name, $args);
				continue;
			}

			if ($isResponsive) {
				$element->add_responsive_control($name, $args);
				continue;
			}

			$element->add_control($name, $args);
		}
	}

	
	/**
	 * Get Transform Controls
	 *
	 * @param string $prefix Controls prefix.
	 * @param object $element Elementor object.
	 * @param array  $controls Controls array.
	 * @param array  $options Options array.
	 *
	 * @since 1.0.0
	 * @return array $controls Position controls.
	 */
	public function common_transform_controls($prefix, $element = null, $controls = array(), $options = array())
	{

		if (! $element) {
			$element = $this;
		}

		$selector   = $options['selector'] ?? '';
		$conditions = $options['conditions'] ?? array();
		$condition = $options['condition'] ?? array();
		$excludes    = $options['excludes'] ?? array();


		$fields = array(

			"{$prefix}_trnsform" => array(
				'is_group'      => false,
				'is_responsive' => false,
				'args'          => array(
					'label' => esc_html__( 'Enable Transform', 'codexshaper-framework' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'codexshaper-framework' ),
					'label_off' => esc_html__( 'No', 'codexshaper-framework' ),
					'return_value' => 'yes',
					'default' => 'no',
					'selectors'  => array(
						"{$selector}" => " transform: perspective(var(--emf-transform-perspective, 0)) rotateZ(var(--emf-transform-rotateZ, 0)) rotateX(var(--emf-transform-rotateX, 0)) rotateY(var(--emf-transform-rotateY, 0)) translate(var(--emf-transform-translate, 0)) translateX(var(--emf-transform-translateX, 0)) translateY(var(--emf-transform-translateY, 0)) scaleX(calc(var(--emf-transform-flipX, 1) * var(--emf-transform-scaleX, var(--emf-transform-scale, 1)))) scaleY(calc(var(--emf-transform-flipY, 1) * var(--emf-transform-scaleY, var(--emf-transform-scale, 1)))) skewX(var(--emf-transform-skewX, 0)) skewY(var(--emf-transform-skewY, 0));",
					),
					'condition'  => $condition,
					'conditions' => $conditions,
				)
			),

			"{$prefix}_translate" => array(
					'is_group'      => false,
					'is_responsive' => false,
					'args'          => array(
					'type' => Controls_Manager::POPOVER_TOGGLE,
					'label' => esc_html__( 'Translate', 'codexshaper-framework' ),
					'label_off' => esc_html__( 'Default', 'codexshaper-framework' ),
					'label_on' => esc_html__( 'Custom', 'codexshaper-framework' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition'  => array_merge(array("{$prefix}_trnsform"=>'yes',),$condition),
					'conditions' => $conditions,
				),
			),
			
			'start_popover_one' => array(
					'popover' => 'start'
			),

			// Transform: Translate.
			"{$prefix}_translate_x" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Translate X', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('px', '%', 'em', 'rem', 'vh', 'vw', 'deg'),
					'selectors'  => array(
						"{$selector}" => '--emf-transform-translateX: {{SIZE}}{{UNIT}};',
					),
					'condition'  => array_merge(array( "{$prefix}_trnsform"=>'yes', "{$prefix}_translate" => 'yes' ),$condition),
					'conditions' => $conditions,
				),
			),

			"{$prefix}_translate_y" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Translate Y', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('px', '%', 'em', 'rem', 'vh', 'vw', 'deg'),
					'selectors'  => array(
					"{$selector}" => '--emf-transform-translateY: {{SIZE}}{{UNIT}};',
					),
					'condition'  => array_merge(array( "{$prefix}_trnsform"=>'yes', "{$prefix}_translate" => 'yes' ),$condition),
					'conditions' => $conditions,
				),
			),
			
			"{$prefix}_translate_z" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Translate Z', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('px', '%', 'em', 'rem', 'vh', 'vw', 'deg'),
					'selectors'  => array(
						"{$selector}" => '--emf-transform-translateZ: {{SIZE}}{{UNIT}};',
					),
					'condition'  => array("{$prefix}_trnsform" => 'yes', "{$prefix}_translate" => 'yes'),
					'conditions' => $conditions,
				),
			),

			'end_popover_one' => array(
					'popover' => 'end'
			),

			"{$prefix}_scale" => array(
					'is_group'      => false,
					'is_responsive' => false,
					'args'          => array(
					'type' => Controls_Manager::POPOVER_TOGGLE,
					'label' => esc_html__( 'Scale', 'codexshaper-framework' ),
					'label_off' => esc_html__( 'Default', 'codexshaper-framework' ),
					'label_on' => esc_html__( 'Custom', 'codexshaper-framework' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition'  => array_merge( array( "{$prefix}_trnsform"=>'yes' ),$condition),
					'conditions' => $conditions,
				),
			),
			
			'start_popover_two' => array(
				'popover' => 'start'
			),

			"{$prefix}_scale_x" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Scale X', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array('px' => array('min' => 0,'step' => 0.1)),
					'selectors'  => array(
						"{$selector}" => '--emf-transform-scaleX: {{SIZE}};',
					),
					'condition'  => array_merge( array( "{$prefix}_trnsform" => 'yes', "{$prefix}_scale" => 'yes' ),$condition ),
					'conditions' => $conditions,
				),
			),
			"{$prefix}_scale_y" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Scale Y', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array('px' => array('min' => 0,'step' => 0.1)),
					'selectors'  => array(
						"{$selector}" => '--emf-transform-scaleY: {{SIZE}};',
					),
					'condition'  => array_merge( array( "{$prefix}_trnsform" => 'yes', "{$prefix}_scale" => 'yes' ),$condition ),
					'conditions' => $conditions,
				),
			),
			"{$prefix}_scale_z" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Scale Z', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array('px' => array('min' => 0,'step' => 0.1)),
					'selectors'  => array(
					"{$selector}" => '--emf-transform-scaleZ: {{SIZE}};',
					),
					'condition'  => array_merge( array( "{$prefix}_trnsform" => 'yes', "{$prefix}_scale" => 'yes ' ) ,$condition ),
					'conditions' => $conditions,
				),
			),

			'end_popover_two' => array(
					'popover' => 'end'
			),

			"{$prefix}_rotate" => array(
					'is_group'      => false,
					'is_responsive' => false,
					'args'          => array(
					'type' => Controls_Manager::POPOVER_TOGGLE,
					'label' => esc_html__( 'Rotate', 'codexshaper-framework' ),
					'label_off' => esc_html__( 'Default', 'codexshaper-framework' ),
					'label_on' => esc_html__( 'Custom', 'codexshaper-framework' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition'  => array_merge(array("{$prefix}_trnsform"=>'yes',),$condition),
					'conditions' => $conditions,
				),
			),

			'start_popover_three' => array(
				'popover' => 'start'
			),

			"{$prefix}_rotate_x" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Rotate X', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('deg','custom'),
					'default'    => [
						'unit' => 'deg',
					],
					'range'      => array('deg' => array('min' => -360, 'max' => 360)),
					'selectors'  => array(
						"{$selector}" => '--emf-transform-rotateX: {{SIZE}}deg;',
					),
					'condition'  => array_merge(array("{$prefix}_trnsform"=>'yes', "{$prefix}_rotate" => 'yes'),$condition),
					'conditions' => $conditions,
				),
			),
			"{$prefix}_rotate_y" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Rotate Y', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('deg','custom'),
					'default'    => [
						'unit' => 'deg',
					],
					'range'      => array('deg' => array('min' => -360, 'max' => 360)),
					'selectors'  => array(
						"{$selector}" => '--emf-transform-rotateY: {{SIZE}}deg;',
					),
					'condition'  => array_merge(array("{$prefix}_trnsform"=>'yes', "{$prefix}_rotate" => 'yes'),$condition),
					'conditions' => $conditions,
				),
			),
			"{$prefix}_rotate_z" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Rotate Z', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('deg','custom'),
					'default'    => [
						'unit' => 'deg',
					],
					'range'      => array('deg' => array('min' => -360, 'max' => 360)),
					'selectors'  => array(
						"{$selector}" => '--emf-transform-rotateZ: {{SIZE}}deg;',
					),
					'condition'  => array_merge(array("{$prefix}_trnsform"=>'yes', "{$prefix}_rotate" => 'yes'),$condition),
					'conditions' => $conditions,
				),
			),

			'end_popover_three' => array(
				'popover' => 'end'
			),

			"{$prefix}_skew" => array(
					'is_group'      => false,
					'is_responsive' => false,
					'args'          => array(
					'type' => Controls_Manager::POPOVER_TOGGLE,
					'label' => esc_html__( 'skew', 'codexshaper-framework' ),
					'label_off' => esc_html__( 'Default', 'codexshaper-framework' ),
					'label_on' => esc_html__( 'Custom', 'codexshaper-framework' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition'  => array_merge(array("{$prefix}_trnsform"=>'yes',),$condition),
					'conditions' => $conditions,
				),
			),

			'start_popover_four' => array(
				'popover' => 'start'
			),

			"{$prefix}_skew_x" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Skew X', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('deg','custom'),
					'default'    => [
						'unit' => 'deg',
					],
					'range'      => array('deg' => array('min' => -90, 'max' => 90)),
					'selectors'  => array(
						"{$selector}" => '--emf-transform-skewX: {{SIZE}}deg;',
					),
					'condition'  => array_merge(array("{$prefix}_trnsform"=>'yes',"{$prefix}_skew" =>'yes'),$condition),
					'conditions' => $conditions,
				),
			),

			"{$prefix}_skew_y" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Skew Y', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('deg','custom'),
					'default'    => [
						'unit' => 'deg',
					],
					'range'      => array('deg' => array('min' => -90, 'max' => 90)),
					'selectors'  => array(
						"{$selector}" => '--emf-transform-skewY: {{SIZE}}deg;',
					),
					'condition'  => array_merge(array("{$prefix}_trnsform"=>'yes',"{$prefix}_skew" =>'yes'),$condition),
					'conditions' => $conditions,
				),
			),

			'end_popover_four' => array(
				'popover' => 'end'
			),
			
			"{$prefix}_perspective" => array(
				'is_group'      => false,
				'is_responsive' => true,
				'args'          => array(
					'label'      => esc_html__('Perspective', 'codexshaper-framework'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('px','custom'),
					'default'    => [
						'unit' => 'px',
					],
					'range'      => array('px' => array('min' => 0, 'max' => 2000, 'step' => 10)),
					'selectors'  => array(
						"{$selector}" => " --emf-transform-perspective: {{SIZE}}{{UNIT}}",
					),
					'condition'  => array_merge(array("{$prefix}_trnsform"=>'yes'),$condition),
					'conditions' => $conditions,
				),
			),
			
		);
		

		$fields = array_replace_recursive($fields, $controls);

		foreach ($fields as $name => $field) {
			if (in_array($name, $excludes)) {
				continue;
			}

			$isGroup      = $field['is_group'] ?? false;
			$isResponsive = $field['is_responsive'] ?? false;
			$args         = $field['args'] ?? array();
			$popover      = $field['popover'] ?? '';

			if ('start' === $popover) {
				$element->start_popover();
				continue;
			}

			if ('end' === $popover) {
				$element->end_popover();
				continue;
			}
		

			if ($isGroup) {
				$element->add_group_control($name, $args);
				continue;
			}

			if ($isResponsive) {
				$element->add_responsive_control($name, $args);
				continue;
			}

			$element->add_control($name, $args);
		}
	}
}
