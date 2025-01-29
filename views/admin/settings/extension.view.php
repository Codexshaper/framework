<?php
/**
 * Admin View: Settings Extensions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$global_config = $GLOBALS['cxf_config'] ?? array();
$extensions    = $global_config['extensions'] ?? array();
$extensions    = apply_filters( 'cxf/extensions', $extensions );
?>
<form action="POST" class="cxf--settings" name="cxf_animation">
	<div class="settings-wrapper">
		<div class="settings-header">
			<h3 class="settings-title"><?php echo esc_html__( 'Extension Settings', 'codexshaper-framework' ); ?></h3>
			<div class="header-right">
				<div class="switcher-wrapper">
					<div class="switcher">
						<input type="checkbox" id="cxf--disable-extensions" class="cxf--global-switch">
						<label for="cxf--disable-extensions">
							<?php esc_html_e( 'Disable All', 'codexshaper-framework' ); ?>
						</label>
					</div>
					<div class="switcher">
						<input type="checkbox" id="cxf--enable-extensions" class="cxf--global-switch">
						<label for="cxf--enable-extensions">
							<?php esc_html_e( 'Enable All', 'codexshaper-framework' ); ?>
						</label>
					</div>
				</div>
				<button type="button" class="cxf--f-btn cxf--f-btn-primary cxf--animation-settings-save">
					<?php esc_html_e( 'Save Animation Settings', 'codexshaper-framework' ); ?>
				</button>
			</div>
		</div>
		<div class="settings-group">
			<h3 class="settings-title"><?php esc_html_e( 'Extensions', 'codexshaper-framework' ); ?></h3>
			<div class="settings-items">
				<div class="switcher gsap">
					<?php $status = ! defined( 'CXF_VERSION' ) ? 'disabled' : checked( 1, cxf_settings( 'cxf_animation', 'gsap' ), false ); ?>
					<input type="checkbox" id="view-gsap" class="cxf--gsap-switch cxf--settings-item" name="gsap" <?php echo esc_attr( $status ); ?>>
					<label for="view-gsap">
						<?php esc_html_e( 'GSAP', 'codexshaper-framework' ); ?>
					</label>
				</div>
				<div class="switcher smooth-scroll">
					<?php $status = ! defined( 'CXF_VERSION' ) ? 'disabled' : checked( 1, cxf_settings( 'cxf_animation', 'smooth_scroller' ), false ); ?>
					<input type="checkbox" id="view-smooth-scroller" class="cxf--smooth-scroller-switch cxf--settings-item" name="smooth_scroller" <?php echo esc_attr( $status ); ?>>
					<label for="view-smooth-scroller">
						<?php esc_html_e( 'Smooth Scroller', 'codexshaper-framework' ); ?>
					</label>
				</div>
				<div class="switcher mobile-smooth-scroll">
					<?php $status = ! defined( 'CXF_VERSION' ) ? 'disabled' : checked( 1, cxf_settings( 'cxf_animation', 'mobile_smooth_scroller' ), false ); ?>
					<input type="checkbox" id="view-mobile-smooth-scroller" class="cxf--mobile-smooth-scroller-switch cxf--settings-item" name="mobile_smooth_scroller" <?php echo esc_attr( $status ); ?>>
					<label for="view-mobile-smooth-scroller">
						<?php esc_html_e( 'Mobile Smooth Scroller', 'codexshaper-framework' ); ?>
					</label>
				</div>
				<div class="number">
					<label for="view-smooth-amount">
						<?php esc_html_e( 'Smooth Amount', 'codexshaper-framework' ); ?>
					</label>
					<input type="number" id="view-smooth-amount" class="cxf--smooth-amount-switch cxf--settings-item" name="smooth_amount" value="<?php echo esc_attr( cxf_settings( 'cxf_animation', 'smooth_amount' ) ); ?>" >
				</div>
			</div>
		</div>
	</div>
</form>


