<?php
/**
 * MetaBox Base file
 *
 * @category   Classes
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cmf
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
 * @link       https://github.com/CodexShaper-Devs/cmf
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
	protected $nonce = 'csmf_metabox_nonce';

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
	protected $is_serialize = true;

	/**
	 * Metabox Active status
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string  The Metabox is active?
	 */
	protected $is_active = true;

	/**
	 * MetaBox constructor.
	 * 
	 * @param array $args The arguments.
	 * 
	 * @return void
	 */
	public function __construct($id = '', $sections = array(), $options = array()) {

		if (!empty($id)) {
			$this->id = $id;
		}

		if (!empty($sections)) {
			$this->sections = $sections;
		}

		if (!empty($options)) {
			$this->options = $options;
		}

		if (isset($this->options['post_type'])) {
			$this->screen = $this->options['post_type'];
		}
		
		$this->prepare_options($options);

		// Add custom meta box.
		$this->add_action( 'add_meta_boxes', 'register' );
		// Save meta box data.
		$this->add_action( 'save_post', 'save' );
		$this->add_action( 'edit_attachment', 'save' );
	}

	/**
	 * Prepare options.
	 *
	 * @return void
	 */
	protected function prepare_options($args = array()) {

		if ( is_array($args) && !empty($args) ) {

			foreach($args as $option => $value) {
				if (property_exists($this, $option)) {
					$this->{$option} = $value;
				}
			}
		}

		$this->id = strtolower( str_replace( array( ' ', '-' ), '_', $this->get_id() ) );

		if ( ! $this->title ) {
			$this->title = join( ' ', array_map( 'ucfirst', explode( '_', $this->id ) ) );
		}

		if ( method_exists( $this, 'get_title' ) ) {
			$this->title = $this->get_title();
		}

		$this->plural_title = csmf_pluralize( $this->title );

		if ( method_exists( $this, 'get_plural_title' ) ) {
			$this->plural_title = $this->get_plural_title();
		}

		if ( method_exists( $this, 'get_screen' ) ) {
			$this->screen = $this->get_screen();
		}

		if ( method_exists( $this, 'get_is_serialize' ) ) {
			$this->is_serialize = $this->get_is_serialize();
		}

		if ( method_exists( $this, 'get_is_active' ) ) {
			$this->is_active = $this->get_is_active();
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

		if (isset( $this->options['data_type'] )) {
			$this->is_serialize = $this->options['data_type'] === 'serialize';
		}
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

		$this->sections = apply_filters( "csmf_filter_{$this->id}_sections", $this->sections );

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

		$errors = get_post_meta( $post->ID, 'csmf_metabox_errors_' . $this->id, true );

		if ( $errors ) {
			delete_post_meta( $post->ID, 'csmf_metabox_errors_' . $this->id );
		}

		wp_nonce_field( $this->nonce, "{$this->nonce}_{$this->id}" );

		?>
		<div class="cmf csmf--metabox">
			<div class="csmf--wrapper">
				<div class="csmf--content">
					<div class="csmf--sections">
						<?php
						if (isset($this->options['data_type'])) {
							$this->options['data_type'] = $this->is_serialize ? 'serialize' : '';
						}
						foreach ( $this->sections as $section ) {
							Section::render( $section, $this->id, $this->options, $post->ID, $this->is_serialize );
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
	 * @param int $post_id The post ID.
	 *
	 * @return void
	 */
	public function save(int $post_id) {
		if (!$post_id || !is_array($sections = $this->get_sections())) {
			return;
		}

		$nonce_key = "{$this->nonce}_{$this->id}";
		$nonce     = isset($_POST[$nonce_key]) ? sanitize_text_field(wp_unslash($_POST[$nonce_key])) : '';

		// Verify nonce and autosave check.
		if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || !wp_verify_nonce($nonce, $this->nonce)) {
			return;
		}

		// XSS ok. This "POST" requests is sanitizing below.
		$request = isset($_POST[$this->id]) ? csmf_sanitize_recursive(wp_unslash($_POST[$this->id])) : [];
		$data    = [];
		$errors  = [];

		foreach ($sections as $key => $section) {
			$fields = $section['fields'] ?? [];
			if (!is_array($fields)) {
				continue;
			}

			foreach ($fields as $field) {
				$field_id = $field['id'] ?? '';
				if (!$field_id) {
					continue;
				}

				$field_value = $request[$field_id] ?? '';
				$sanitized_value = $this->sanitize_field($field, $field_value);

				// Handle validation.
				if (!$this->validate_field($field, $field_value)) {
					$errors['sections'][$key + 1] = true;
					$errors['fields'][$field_id] = false; // Validation failed.
					$sanitized_value = Field::get_value($post_id, $field, $this->id, $this->options);
				}

				$data[$field_id] = $sanitized_value;
			}
		}

		// Filter and reset handling.
		$data     = apply_filters("csmf_{$this->id}_save", $data, $post_id, $this);
		$is_reset = isset($request['_reset']) && $request['_reset'];
		do_action("csmf_{$this->id}_save_before", $data, $post_id, $this);

		if ($is_reset) {
			$this->handle_reset($post_id, $sections);
			return;
		}

		// Save data: Serialized or individual fields.
		$this->save_meta_data($post_id, $data);

		// Save errors if available.
		if (!empty($errors)) {
			update_post_meta($post_id, 'csmf_metabox_errors_' . $this->id, $errors);
		}

		// Perform actions after saving.
		do_action("csmf_{$this->id}_saved", $data, $post_id, $this);
		do_action("csmf_{$this->id}_save_after", $data, $post_id, $this);
	}

	/**
	 * Sanitize a single field value based on field configuration.
	 *
	 * @param array  $field The field configuration.
	 * @param mixed  $value The field value.
	 * @return mixed Sanitized value.
	 */
	private function sanitize_field(array $field, $value) {
		if (is_string($value)) {
			$value = wp_kses_post($value);
		} elseif (is_array($value)) {
			$value = wp_kses_post_deep($value);
		}

		if (isset($field['sanitize']) && is_callable($field['sanitize'])) {
			$value = call_user_func($field['sanitize'], $value);
		}

		return $value;
	}

	/**
	 * Validate a single field value based on field configuration.
	 *
	 * @param array  $field The field configuration.
	 * @param mixed  $value The field value.
	 * @return bool True if valid, false otherwise.
	 */
	private function validate_field(array $field, $value): bool {
		if (isset($field['validate']) && is_callable($field['validate'])) {
			return call_user_func($field['validate'], $value);
		}

		return true; // Default to valid if no validation callback is provided.
	}

	/**
	 * Handle reset logic for meta fields.
	 *
	 * @param int   $post_id The post ID.
	 * @param array $sections The sections configuration.
	 * @return void
	 */
	private function handle_reset(int $post_id, array $sections): void {
		if ($this->is_serialize) {
			delete_post_meta($post_id, $this->id);
		} else {
			foreach ($sections as $section) {
				foreach ($section['fields'] ?? [] as $field) {
					if (!empty($field['id'])) {
						delete_post_meta($post_id, $field['id']);
					}
				}
			}
		}
	}

	/**
	 * Save meta data for the post.
	 *
	 * @param int   $post_id The post ID.
	 * @param array $data    The meta data to save.
	 * @return void
	 */
	private function save_meta_data(int $post_id, array $data): void {

		if ($this->is_serialize) {
			update_post_meta($post_id, $this->id, $data);
		} else {
			foreach ($data as $key => $value) {
				update_post_meta($post_id, $key, $value);
			}
		}
	}
}
