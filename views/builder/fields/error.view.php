<?php
/**
 * Error View
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

<?php if ( is_string( $errors ) ) : ?>
	<p class="csmf--error-text"><?php echo esc_html( $errors ); ?></p>
<?php endif; ?>

<?php if ( is_array( $errors ) ) : ?>
	<?php foreach ( $errors as $error ) : ?>
		<p class="csmf--error-text"><?php echo esc_html( $error ); ?></p>
	<?php endforeach; ?>
<?php endif; ?>
