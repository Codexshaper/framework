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
		$conditions = $options['conditions'] ?? array();
		$exclude    = $options['exclude'] ?? array();

		$fields = array(
			Group_Control_Typography::get_type()  => array(
				'is_group' => true,
				'args'     => array(
					'name'      => $prefix,
					'label'     => __( 'Typography', 'codexshaper-framework' ),
					'selector'  => "{$selector}",
					'condition' => $conditions,
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
					'condition' => $conditions,
				),
			),
			Group_Control_Text_Stroke::get_type() => array(
				'is_group' => true,
				'args'     => array(
					'name'      => "{$prefix}_text_stroke",
					'selector'  => "{$selector}",
					'condition' => $conditions,
				),
			),
			Group_Control_Text_Shadow::get_type() => array(
				'is_group' => true,
				'args'     => array(
					'name'      => "{$prefix}_text_shadow",
					'selector'  => "{$selector}",
					'condition' => $conditions,
				),
			),
		);

		$fields = array_replace_recursive( $fields, $controls );

		foreach ( $fields as $name => $field ) {
			if ( in_array( $name, $exclude ) ) {
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
		$conditions = $options['conditions'] ?? array();
		$exclude    = $options['exclude'] ?? array();

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
					'condition'  => $conditions,
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
					'condition'  => $conditions,
				),
			),
		);

		$fields = array_replace_recursive( $fields, $controls );

		foreach ( $fields as $name => $field ) {
			if ( in_array( $name, $exclude ) ) {
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
		$conditions     = $options['conditions'] ?? array();
		$exclude        = $options['exclude'] ?? array();

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
					'condition'  => $conditions,
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
					'condition'  => $conditions,
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
					'condition'  => $conditions,
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
				),
			),

			Group_Control_Css_Filter::get_type() => array(
				'is_group'      => true,
				'is_responsive' => false,
				'args'          => array(
					'name'      => "{$prefix}_css_filters",
					'selector'  => "{$selector}",
					'condition' => $conditions,
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
					'condition' => $conditions,
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
					'condition' => $conditions,
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
				),
			),

		);

		$fields = array_replace_recursive( $fields, $controls );

		foreach ( $fields as $name => $field ) {
			if ( in_array( $name, $exclude ) ) {
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
		$conditions = $options['conditions'] ?? array();
		$exclude    = $options['exclude'] ?? array();

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
					'condition'  => $conditions,
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
					'condition' => $conditions,
				),
			),
		);

		$fields = array_replace_recursive( $fields, $controls );

		foreach ( $fields as $name => $field ) {
			if ( in_array( $name, $exclude ) ) {
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
		$conditions = $options['conditions'] ?? array();
		$exclude    = $options['exclude'] ?? array();

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
					'condition'  => $conditions,
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
					'condition'  => $conditions,
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
					'condition'  => $conditions,
				),
			),

			Group_Control_Border::get_type()     => array(
				'is_group' => true,
				'args'     => array(
					'name'       => "{$prefix}_border",
					'selector'   => "{$selector}",
					'responsive' => true,
					'condition'  => $conditions,
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
					'condition'  => $conditions,
				),
			),

		);

		$fields = array_replace_recursive( $fields, $controls );

		foreach ( $fields as $name => $field ) {
			if ( in_array( $name, $exclude ) ) {
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
}
