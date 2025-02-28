<?php
/**
 * Button Trait file
 *
 * @category   Button
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
namespace CodexShaper\Framework\Foundation\Traits\Image;

use CodexShaper\Framework\Foundation\Traits\Button\ButtonControls;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

/**
 *  Button trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Button {

	use ButtonControls;

	/**
	 * Render Button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @param Widget_Base $widget Widget_Base instance.
	 */
	protected function render_button( Widget_Base $widget = null ) {
		if ( empty( $widget ) ) {
			$widget = $this;
		}

		$settings = $widget->get_settings();

		if ( empty( $settings['text'] ) && empty( $settings['selected_icon']['value'] ) ) {
			return;
		}

		$widget->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$widget->add_link_attributes( 'button', $settings['link'] );
			$widget->add_render_attribute( 'button', 'class', 'elementor-button-link' );
		}

		$widget->add_render_attribute( 'button', 'class', 'elementor-button' );
		$widget->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$widget->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			$widget->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$widget->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}
		?>
		<div <?php $widget->print_render_attribute_string( 'wrapper' ); ?>>
			<a <?php $widget->print_render_attribute_string( 'button' ); ?>>
				<?php $this->render_text( $widget ); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Render Button widget text output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @param Widget_Base $widget Widget_Base instance.
	 *
	 * @return void Render Button widget text output on the frontend.
	 */
	protected function render_text( Widget_Base $widget ) {
		$settings = $widget->get_settings();

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		$widget->add_render_attribute(
			array(
				'content-wrapper' => array(
					'class' => 'elementor-button-content-wrapper',
				),
				'icon'            => array(
					'class' => 'elementor-button-icon',
				),
				'text'            => array(
					'class' => 'elementor-button-text',
				),
			)
		);

		// TODO: replace the protected with public
		// $widget->add_inline_editing_attributes( 'text', 'none' );
		?>
		<span <?php $widget->print_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
				<span <?php $widget->print_render_attribute_string( 'icon' ); ?>>
				<?php
				if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['selected_icon'], array( 'aria-hidden' => 'true' ) );
				else :
					?>
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>
			</span>
			<?php endif; ?>
			<?php if ( ! empty( $settings['text'] ) ) : ?>
			<span <?php $widget->print_render_attribute_string( 'text' ); ?>><?php $widget->print_unescaped_setting( 'text' ); ?></span>
			<?php endif; ?>
		</span>
		<?php
	}
}
