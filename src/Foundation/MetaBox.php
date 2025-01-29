<?php
/**
 * MetaBox Base file
 *
 * @category   Classes
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cxf
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation;

use CodexShaper\Framework\Builder\OptionBuilder\Field;
use CodexShaper\Framework\Builder\OptionBuilder\Section;
use CodexShaper\Framework\Contracts\MetaBoxContract;
use CodexShaper\Framework\Foundation\Traits\Caller;
use CodexShaper\Framework\Foundation\Traits\Getter;
use CodexShaper\Framework\Foundation\Traits\Hook;
use WP_Post;

/**
 * MetaBox Base Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cxf
 * @since      1.0.0
 */
abstract class MetaBox implements MetaBoxContract {

	use Hook;
	use Getter;
	use Caller;

	/**
	 * Meta box ID (used in the 'id' attribute for the meta box).
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The meta box id.
	 */
	protected $id;

	/**
	 * Title of the meta box.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The meta box title.
	 */
	protected $title;

	/**
	 * Post Plural Title
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The meta box plural title.
	 */
	protected $plural_title;

	/**
	 * The screen or screens on which to show the box (such as a post type, 'link', or 'comment').
	 * Accepts a single screen ID, WP_Screen object, or array of screen IDs.
	 * Default is the current screen. If you have used add_menu_page() or add_submenu_page()
	 * to create a new screen (and hence screen_id),
	 * make sure your menu slug conforms to the limits of sanitize_key()
	 * otherwise the 'screen' menu may not correctly render on your page.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @see WP_Screen https://developer.wordpress.org/reference/classes/wp_screen/
	 * @see add_menu_page() https://developer.wordpress.org/reference/functions/add_menu_page/
	 * @see add_submenu_page() https://developer.wordpress.org/reference/functions/add_submenu_page/
	 * @see sanitize_key() https://developer.wordpress.org/reference/functions/sanitize_key/
	 *
	 * @var string  The screens.
	 */
	protected $screen = null;

	/**
	 * The context within the screen where the box should display.
	 * Available contexts vary from screen to screen.
	 * Post edit screen contexts include 'normal', 'side', and 'advanced'.
	 * Comments screen contexts include 'normal' and 'side'.
	 * Menus meta boxes (accordion sections) all use the 'side' context.
	 * Global default is 'advanced'.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The context.
	 */
	protected $context = 'advanced';

	/**
	 * The priority within the context where the box should show.
	 * Accepts 'high', 'core', 'default', or 'low'.
	 * Default 'default'.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The priority.
	 */
	protected $priority = 'default';

	/**
	 * Data that should be set as the $args property of the box array (which is the second parameter passed to your callback).
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The callback arguments.
	 */
	protected $callback_args = null;

	/**
	 * The metabox nonce prefix
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The metabox nonce prefix.
	 */
	protected $nonce = 'cxf_metabox_nonce';

	/**
	 * The metabox options
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array  The metabox options.
	 */
	protected $options = array();

	/**
	 * The metabox sections
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array  The sections.
	 */
	protected $sections = array();

	/**
	 * The Enable data serialization
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var bool Is data serializeable?
	 */
	protected $is_serialize = false;

	/**
	 * MetaBox constructor.
	 */
	public function __construct() {
		$this->id = strtolower( str_replace( array( ' ', '-' ), '_', $this->get_id() ) );

		if ( ! $this->title ) {
			$this->title = join( ' ', array_map( 'ucfirst', explode( '_', $this->id ) ) );
		}

		if ( method_exists( $this, 'get_title' ) ) {
			$this->title = $this->get_title();
		}

		$this->plural_title = cxf_pluralize( $this->title );

		if ( method_exists( $this, 'get_plural_title' ) ) {
			$this->plural_title = $this->get_plural_title();
		}

		if ( method_exists( $this, 'get_screen' ) ) {
			$this->screen = $this->get_screen();
		}

		if ( method_exists( $this, 'get_context' ) ) {
			$this->context = $this->get_context();
		}

		if ( method_exists( $this, 'get_priority' ) ) {
			$this->priority = $this->get_priority();
		}

		if ( method_exists( $this, 'get_callback_args' ) ) {
			$this->callback_args = $this->get_callback_args();
		}

		if ( method_exists( $this, 'get_options' ) ) {
			$this->options = $this->get_options();
		}

		$this->is_serialize = isset( $this->options['data_type'] ) && $this->options['data_type'] === 'serialize';

		// Add custom meta box.
		$this->add_action( 'add_meta_boxes', 'register' );
		// Save meta box data.
		$this->add_action( 'save_post', 'save' );
	}

	/**
	 * Add section.
	 *
	 * @param string $section The section ID.
	 *
	 * @return void
	 */
	public function add_section( $section ) {
		$this->sections[] = $section;
	}

	/**
	 * Get sections.
	 *
	 * @return array The sections.
	 */
	public function get_sections() {
		if ( empty( $this->sections ) && method_exists( $this, 'register_sections' ) ) {
			$this->register_sections();
		}

		return $this->sections;
	}

	/**
	 * Adds a meta box to one or more screens.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		/**
		 * Adds a meta box to one or more screens.
		 *
		 * @since 2.5.0
		 * @since 4.4.0 The `$screen` parameter now accepts an array of screen IDs.
		 *
		 * @global array $wp_meta_boxes Global meta box state.
		 *
		 * @param string                 $id            Meta box ID (used in the 'id' attribute for the meta box).
		 * @param string                 $title         Title of the meta box.
		 * @param callable               $callback      Function that fills the box with the desired content.
		 *                                              The function should echo its output.
		 * @param string|array|WP_Screen $screen        Optional. The screen or screens on which to show the box
		 *                                              (such as a post type, 'link', or 'comment'). Accepts a single
		 *                                              screen ID, WP_Screen object, or array of screen IDs. Default
		 *                                              is the current screen.  If you have used add_menu_page() or
		 *                                              add_submenu_page() to create a new screen (and hence screen_id),
		 *                                              make sure your menu slug conforms to the limits of sanitize_key()
		 *                                              otherwise the 'screen' menu may not correctly render on your page.
		 * @param string                 $context       Optional. The context within the screen where the box
		 *                                              should display. Available contexts vary from screen to
		 *                                              screen. Post edit screen contexts include 'normal', 'side',
		 *                                              and 'advanced'. Comments screen contexts include 'normal'
		 *                                              and 'side'. Menus meta boxes (accordion sections) all use
		 *                                              the 'side' context. Global default is 'advanced'.
		 * @param string                 $priority      Optional. The priority within the context where the box should show.
		 *                                              Accepts 'high', 'core', 'default', or 'low'. Default 'default'.
		 * @param array                  $callback_args Optional. Data that should be set as the $args property
		 *                                              of the box array (which is the second parameter passed
		 *                                              to your callback). Default null.
		 */

		$this->sections = $this->get_sections();

		$this->sections = apply_filters( "cxf_filter_{$this->id}_sections", $this->sections );

		add_meta_box( $this->id, $this->title, array( $this, 'render' ), $this->screen, $this->context, $this->priority, $this->callback_args );
	}

	/** Removes a meta box from one or more screens.
	 *
	 * @since 1.0.0
	 */
	function unregister() {

		if ( ! $this->id || empty( $this->id ) ) {
				$this->id = $this->get_id();
		}

		/**
		 * Removes a meta box from one or more screens.
		 *
		 * @since 2.6.0
		 * @since 4.4.0 The `$screen` parameter now accepts an array of screen IDs.
		 *
		 * @global array $wp_meta_boxes Global meta box state.
		 *
		 * @param string                 $id      Meta box ID (used in the 'id' attribute for the meta box).
		 * @param string|array|WP_Screen $screen  The screen or screens on which the meta box is shown (such as a
		 *                                        post type, 'link', or 'comment'). Accepts a single screen ID,
		 *                                        WP_Screen object, or array of screen IDs.
		 * @param string                 $context The context within the screen where the box is set to display.
		 *                                        Contexts vary from screen to screen. Post edit screen contexts
		 *                                        include 'normal', 'side', and 'advanced'. Comments screen contexts
		 *                                        include 'normal' and 'side'. Menus meta boxes (accordion sections)
		 *                                        all use the 'side' context.
		 */
		remove_meta_box( $this->id, $this->screen, $this->context );
	}

	/**
	 * Get meta box activation status.
	 *
	 * @return bool  is activate?
	 */
	public static function is_active() {
		return true;
	}

	/**
	 * Meta box content display.
	 *
	 * @param WP_Post $post Current post object.
	 *
	 * @return void
	 */
	public function render( $post ) {

		if ( ! $post instanceof WP_Post || ! in_array( $post->post_type, array_filter( (array) $this->get_screen() ) ) ) {
			return;
		}

		if ( ! is_array( $this->sections ) ) {
			return;
		}

		$errors = get_post_meta( $post->ID, 'cxf_metabox_errors_' . $this->id, true );

		if ( $errors ) {
			delete_post_meta( $post->ID, 'cxf_metabox_errors_' . $this->id );
		}

		wp_nonce_field( $this->nonce, "{$this->nonce}_{$this->id}" );

		?>
		<div class="cxf cxf--metabox">
			<div class="cxf--wrapper">
				<div class="cxf--content">
					<div class="cxf--sections">
						<?php
						foreach ( $this->sections as $section ) {
							Section::render( $section, $post->ID, $this->id, $this->options );
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Save the metabox data.
	 *
	 * @param int $post_id  The post ID.
	 *
	 * @return void
	 */
	public function save( int $post_id ) {

		$sections = $this->get_sections();

		if ( ! $post_id || ! is_array( $sections ) ) {
			return;
		}

		$noncekey = "{$this->nonce}_{$this->id}";
		$nonce    = isset( $_POST[ $noncekey ] ) ? sanitize_text_field( wp_unslash( $_POST[ $noncekey ] ) ) : '';

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! wp_verify_nonce( $nonce, $this->nonce ) ) {
			return $post_id;
		}

		// XSS ok. This "POST" requests is sanitizing below.
		$request = isset( $_POST[ $this->id ] ) ? cxf_sanitize_recursive( wp_unslash( $_POST[ $this->id ] ) ) : array();
		$data    = array();
		$errors  = array();

		if ( count( $request ) > 0 ) {

			foreach ( $sections as $key => $section ) {

				$fields = $section['fields'] ?? array();

				if ( is_array( $fields ) && count( $fields ) > 0 ) {

					foreach ( $fields as $field ) {
						// Check id is exists or not otherwise use default value.
						$field_id = $field['id'] ?? '';

						if ( ! $field_id ) {
							continue;
						}

						$field_value = $request[ $field_id ] ?? '';

						// Sanitize "post" request.
						$data[ $field_id ] = $field_value;

						if ( is_string( $field_value ) ) {
							$data[ $field_id ] = wp_kses_post( $field_value );
						}

						if ( is_array( $field_value ) && count( $field_value ) > 0 ) {
							$data[ $field_id ] = wp_kses_post_deep( $field_value );
						}

						if ( isset( $field['sanitize'] ) && is_callable( $field['sanitize'] ) ) {
							$data[ $field_id ] = call_user_func( $field['sanitize'], $field_value );
						}

						// Validate "post" request.
						if ( isset( $field['validate'] ) && is_callable( $field['validate'] ) ) {
							// Call validation function(s) or method(s)
							$has_validated = call_user_func( $field['validate'], $field_value );

							if ( ! $has_validated ) {
								$errors['sections'][ $key + 1 ] = true;
								$errors['fields'][ $field_id ]  = $has_validated;
								$data[ $field_id ]              = Field::get_value( $post_id, $field, $this->id, $this->options );
							}
						}
					}
				}
			}
		}

		$data     = apply_filters( "cxf_{$this->id}_save", $data, $post_id, $this );
		$is_reset = isset( $request['_reset'] ) && $request['_reset'];
		do_action( "cxf_{$this->id}_save_before", $data, $post_id, $this );

		// If both reset enable.
		if ( $is_reset ) {

			if ( $this->is_serialize ) {
				delete_post_meta( $post_id, $this->id );
				return;
			}

			foreach ( $sections as $key => $section ) {
				$fields = $section['fields'] ?? array();
				if ( is_array( $fields ) && count( $fields ) > 0 ) {
					foreach ( $fields as $field ) {
						if ( isset( $field['id'] ) && $field['id'] ) {
							delete_post_meta( $post_id, $field['id'] );
						}
					}
				}
			}

			return;
		}

		// If reset is disabled but serialize is enable.
		if ( $this->is_serialize ) {
			update_post_meta( $post_id, $this->id, $data );
		} else {
			foreach ( $data as $key => $value ) {
				update_post_meta( $post_id, $key, $value );
			}
		}

		// If errors is available update meta date.
		if ( count( $errors ) > 0 ) {
			update_post_meta( $post_id, 'cxf_metabox_errors_' . $this->id, $errors );
		}

		// Perform action after data saved.
		do_action( "cxf_{$this->id}_saved", $data, $post_id, $this );
		do_action( "cxf_{$this->id}_save_after", $data, $post_id, $this );
	}
}
