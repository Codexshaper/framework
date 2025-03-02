<?php
/**
 * Upload Preview View
 *
 * @category   View
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="csmf--upload-preview <?php echo !$src ? esc_attr( 'hidden' ) : ''; ?>">
	<div class="csmf--image-preview">
		<span class="csmf--upload-remove-wrap">
			<i class="csmf--upload-remove fas fa-times"></i>
		</span>
		<img class="csmf--upload-preview-img" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $args['alt'] ?? 'Media' ); ?>" />
	</div>
</div>
