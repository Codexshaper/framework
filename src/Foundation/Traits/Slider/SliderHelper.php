<?php
/**
 * Slider Helper file
 *
 * @category   Helper
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Traits\Slider;

use Elementor\Plugin;
use Elementor\Widget_Base;

/**
 * Slider Helper trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait SliderHelper {

	/**
	 * Slider Control Prefix
	 *
	 * @var string
	 */
	protected $slider_control_prefix = 'cxf';

	/**
	 * Thumb Slider Control Prefix
	 *
	 * @var string
	 */
	protected $thumb_slider_control_prefix = 'cxf_thumb';

	/**
	 * Add Slider Attributes
	 *
	 * @param Widget_Base $widget
	 * @param array       $data
	 * @param string      $prefix
	 * @param string      $attribute_id
	 * @param string      $slider_class
	 *
	 * @return void
	 */
	public function add_slider_attributes(
		Widget_Base $widget,
		$data = array(),
		$prefix = '',
		$attribute_id = 'slider-wrapper',
		$slider_class = 'cxf--slider',
	) {
		$swiper_class = Plugin::instance()->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$classes      = $data['class'] ?? '';
		$prefix       = $prefix ?? $this->slider_control_prefix;
		$widget->add_render_attribute(
			$attribute_id,
			array(
				'class'       => "{$slider_class} {$swiper_class} {$classes}",
				'dir'         => $widget->get_settings_for_display( 'cxf_dir' ),
				'style'       => 'position: static',
				'data-prefix' => $prefix,
			)
		);
	}

	/**
	 * Add Thumb Slider Attributes
	 *
	 * @param Widget_Base $widget
	 * @param array       $data
	 * @param string      $prefix
	 * @param string      $attribute_id
	 * @param string      $slider_class
	 *
	 * @return void
	 */
	public function add_thumb_slider_attributes(
		Widget_Base $widget,
		$data = array(),
		$prefix = '',
		$attribute_id = 'thumb-slider-wrapper',
		$slider_class = 'cxf--thumb-slider'
	) {
		$swiper_class = Plugin::instance()->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$classes      = $data['class'] ?? '';
		$prefix       = $prefix ?? $this->thumb_slider_control_prefix;
		$widget->add_render_attribute(
			$attribute_id,
			array(
				'class'       => "{$slider_class} {$swiper_class} {$classes}",
				'dir'         => $widget->get_settings_for_display( 'cxf_thumb_dir' ),
				'style'       => 'position: static',
				'data-prefix' => $prefix,
			)
		);
	}
}
