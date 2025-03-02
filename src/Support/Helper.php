<?php
/**
 * Helper functions
 *
 * @category   Support
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Support;

use CodexShaper\Framework\Foundation\Traits\Image\Helper as ImageHelper;
use CodexShaper\Framework\Foundation\Traits\Pagination\Pagination;
use CodexShaper\Framework\Foundation\Traits\Slider\SliderHelper;

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Button widget class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Helper {

	use ImageHelper;
	use SliderHelper;
	use Pagination;

	/**
	 * Instance
	 *
	 * @var \CodexShaper\Framework\Core\Helper
	 * @static
	 * @since 1.0.0
	 */
	protected static $instance;

	/**
	 * Constructor
	 *
	 * Admin menu register.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		add_filter(
			'wp_check_filetype_and_ext',
			array( $this, 'csmf_disable_real_mime_check' ),
			10,
			4
		);
	}

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return \CodexShaper\Framework\Core\Helper An instance of the class.
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Post thumbnail
	 *
	 * Display post thumbnail.
	 *
	 * @since 1.0.0
	 *
	 * @return null|void
	 */
	public function postThumbnail() {
		if ( is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>
			<?php the_post_thumbnail( 'csmf_classic' ); ?>
		<?php else : ?>
			<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'csmf_classic',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>
			<?php
		endif;
	}

	/**
	 * Terms
	 *
	 * Get term names.
	 *
	 * @since 1.0.0
	 *
	 * @param string $taxonomy_name The taxonomy name.
	 * @param string $output The output text.
	 * @param bool   $hide_empty Hide empty or not.
	 *
	 * @return array
	 */
	public function getTermsNames( $taxonomy_name = '', $output = '', $hide_empty = false ) {
		$return_val = array();
		$terms      = get_terms(
			array(
				'taxonomy'   => $taxonomy_name,
				'hide_empty' => $hide_empty,
			)
		);
		foreach ( $terms as $term ) {
			if ( 'id' === $output ) {
				$return_val[ $term->term_id ] = $term->name;
			} else {
				$return_val[ $term->slug ] = $term->name;
			}
		}
		return $return_val;
	}

	/**
	 * Sanitize
	 *
	 * Autoload all missing classes by their namespace.
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Sanitizeable value.
	 *
	 * @return string
	 */
	public function sanitizePx( $value ) {
		$return_val = $value;
		if ( filter_var( $value, FILTER_VALIDATE_INT ) ) {
			$return_val = $value . 'px';
		}
		return $return_val;
	}

	/**
	 * Mime check
	 *
	 * Check disable real mime.
	 *
	 * @since 1.0.0
	 *
	 * @param array         $data Mime data.
	 * @param mixed         $file The mime file.
	 * @param string        $filename The file name.
	 * @param string[]|null $mimes Mimes.
	 *
	 * @return array
	 */
	public function disableRealMimeCheck( $data, $file, $filename, $mimes ) {
		$wp_filetype = wp_check_filetype( $filename, $mimes );

		$ext             = $wp_filetype['ext'];
		$type            = $wp_filetype['type'];
		$proper_filename = $data['proper_filename'];

		return compact( 'ext', 'type', 'proper_filename' );
	}

	/**
	 * Mime check
	 *
	 * Check disable real mime.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function linkPages() {

		$defaults = array(
			'before'         => '<div class="wp-link-pages"><span>' . esc_html__( 'Pages:', 'codexshaper-framework' ) . '</span>',
			'after'          => '</div>',
			'link_before'    => '',
			'link_after'     => '',
			'next_or_number' => 'number',
			'separator'      => ' ',
			'pagelink'       => '%',
			'echo'           => 1,
		);
		wp_link_pages( $defaults );
	}

	/**
	 * Post pagination
	 *
	 * Print post pagination.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $nav_query Nav query.
	 *
	 * @return void
	 */
	public function postPagination( $nav_query = null ) {
		global $wp_query;
		$allowed_html = self::ksesAllowedHtml( 'all' );
		$big          = 12345678;
		if ( null === $nav_query ) {
			$page_format = paginate_links(
				array(
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => max( 1, get_query_var( 'paged' ) ),
					'total'     => $wp_query->max_num_pages,
					'type'      => 'array',
					'prev_text' => '«',
					'next_text' => '»',
				)
			);
			if ( is_array( $page_format ) ) {
				$paged = ( get_query_var( 'paged' ) === 0 ) ? 1 : get_query_var( 'paged' );
				echo '<div class="blog-pagination margin-top-60"><ul>';
				echo '<li><span>' . esc_html( $paged ) . esc_html__( ' of ', 'codexshaper-framework' ) . esc_html( $wp_query->max_num_pages ) . '</span></li>';
				foreach ( $page_format as $page ) {
					echo '<li>' . wp_kses( $page, $allowed_html ) . '</li>';
				}
				print '</ul></div>';
			}
		} else {

			$page_format = paginate_links(
				array(
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => max( 1, get_query_var( 'paged' ) ),
					'total'     => $nav_query->max_num_pages,
					'type'      => 'array',
					'prev_text' => '«',
					'next_text' => '»',
				)
			);

			if ( is_array( $page_format ) ) {
				$paged = ( get_query_var( 'paged' ) === 0 ) ? 1 : get_query_var( 'paged' );
				echo '<div class="blog-pagination margin-top-60"><ul>';
				echo '<li><span>' . esc_html( $paged ) . esc_html__( ' of ', 'codexshaper-framework' ) . esc_html( $nav_query->max_num_pages ) . '</span></li>';
				foreach ( $page_format as $page ) {
					echo '<li>' . wp_kses( $page, $allowed_html ) . '</li>';
				}
				print '</ul></div>';
			}
		}
	}

	/**
	 * Posted On
	 *
	 * Printed posted on date.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function postedOn() {

		$time_string = sprintf( '<span class="entry-date published updated">%1$s</span>', esc_attr( get_the_date() ) );
		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) )
		);

		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><i class="fas fa-calendar-alt"></i> ' . esc_html( $time_string ) . '</a>';

		echo '<span class="posted-on">' . esc_html( $posted_on ) . '</span>'; // WPCS: XSS OK.
	}

	/**
	 * Author meta
	 *
	 * Prints HTML with meta information of posted by or authors.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function postedBy() {
		$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="fas fa-user"></i> ' . esc_html__( 'By ', 'codexshaper-framework' ) . esc_html( get_the_author() ) . '</a></span>';

		echo '<span class="byline"> ' . esc_html( $byline ) . '</span>'; // WPCS: XSS OK.
	}

	/**
	 * Posted Tags
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function postedTag() {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			echo '<ul class="tags"><li class="title">' . esc_html__( 'Tags: ', 'codexshaper-framework' ) . '</li><li>' . esc_html( $tags_list ) . '</li></ul>'; // WPCS: XSS OK.
		}
	}

	/**
	 * The post navigation.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function postNavigation() {
		the_post_navigation(
			array(
				'prev_text' => '<i class="fas fa-angle-double-left"></i>&nbsp;' . esc_html__( 'Prev Post', 'codexshaper-framework' ),
				'next_text' => esc_html__( 'Next Post', 'codexshaper-framework' ) . '&nbsp;<i class="fas fa-angle-double-right"></i>',
			)
		);
		echo wp_kses( '<div class="clearfix"></div>', self::ksesAllowedHtml( 'all' ) );
	}

	/**
	 * Check if is Home page
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function isHomePage() {
		$check_home_page = true;
		if ( is_home() && is_front_page() ) {
			$check_home_page = true;
		} elseif ( is_front_page() && ! is_home() ) {
			$check_home_page = true;
		} elseif ( is_home() && ! is_front_page() ) {
			$check_home_page = false;
		}
		$return_val = $check_home_page;

		return $return_val;
	}

	/**
	 * Get terms by post ID
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_id Post ID.
	 * @param string $taxonomy taxonomy.
	 *
	 * @return array
	 */
	public function getTermsByPostId( $post_id, $taxonomy ) {
		$all_terms     = array();
		$all_term_list = get_the_terms( $post_id, $taxonomy );

		foreach ( $all_term_list as $term_item ) {
			$term_url               = get_term_link( $term_item->term_id, $taxonomy );
			$all_terms[ $term_url ] = $term_item->name;
		}
		return $all_terms;
	}

	/**
	 * Sanitize HTML
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $allowed_tags Allowed tags.
	 *
	 * @return array
	 */
	public function ksesAllowedHtml( $allowed_tags = 'all' ) {
		$allowed_html = array(
			'div'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'header' => array(
				'class' => array(),
				'id'    => array(),
			),
			'h1'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h2'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h3'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h4'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h5'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h6'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'p'      => array(
				'class' => array(),
				'id'    => array(),
			),
			'span'   => array(
				'class' => array(),
				'id'    => array(),
			),
			'i'      => array(
				'class' => array(),
				'id'    => array(),
			),
			'mark'   => array(
				'class' => array(),
				'id'    => array(),
			),
			'strong' => array(
				'class' => array(),
				'id'    => array(),
			),
			'br'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'b'      => array(
				'class' => array(),
				'id'    => array(),
			),
			'em'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'del'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'ins'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'u'      => array(
				'class' => array(),
				'id'    => array(),
			),
			's'      => array(
				'class' => array(),
				'id'    => array(),
			),
			'nav'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'ul'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'li'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'form'   => array(
				'class' => array(),
				'id'    => array(),
			),
			'select' => array(
				'class' => array(),
				'id'    => array(),
			),
			'option' => array(
				'class' => array(),
				'id'    => array(),
			),
			'img'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'a'      => array(
				'class' => array(),
				'id'    => array(),
				'href'  => array(),
			),
		);

		if ( 'all' === $allowed_tags ) {
			return $allowed_html;
		} elseif ( is_array( $allowed_tags ) && ! empty( $allowed_tags ) ) {
				$specific_tags = array();
			foreach ( $allowed_tags as $allowed_tag ) {
				if ( array_key_exists( $allowed_tag, $allowed_html ) ) {
					$specific_tags[ $allowed_tag ] = $allowed_html[ $allowed_tag ];
				}
			}
				return $specific_tags;
		}
	}

	/**
	 * Get theme global info
	 *
	 * @since 1.0.0
	 *
	 * @param string $type Type.
	 *
	 * @return string
	 */
	public function getThemeInfo( $type = 'name' ) {

		$theme_information = array();
		if ( is_child_theme() ) {
			$theme      = wp_get_theme();
			$parent     = $theme->get( 'Template' );
			$theme_info = wp_get_theme( $parent );
		} else {
			$theme_info = wp_get_theme();
		}
		$theme_information['THEME_NAME']       = $theme_info->get( 'Name' );
		$theme_information['THEME_VERSION']    = $theme_info->get( 'Version' );
		$theme_information['THEME_AUTHOR']     = $theme_info->get( 'Author' );
		$theme_information['THEME_AUTHOR_URI'] = $theme_info->get( 'AuthorURI' );

		switch ( $type ) {
			case ( 'name' ):
				$return_val = $theme_information['THEME_NAME'];
				break;
			case ( 'version' ):
				$return_val = $theme_information['THEME_VERSION'];
				break;
			case ( 'author' ):
				$return_val = $theme_information['THEME_AUTHOR'];
				break;
			case ( 'author_uri' ):
				$return_val = $theme_information['THEME_AUTHOR_URI'];
				break;
			default:
				$return_val = $theme_information;
				break;
		}
		return $return_val;
	}

	/**
	 * Get page ID
	 *
	 * @since 1.0.0
	 *
	 * @return int|mixed
	 */
	public function pageId() {
		global $post, $wp_query;
		$page_type_id = ( isset( $post->ID ) && in_array( $post->ID, self::getPagesId(), true ) ) ? $post->ID : false;

		if ( false === $page_type_id ) {
			$page_type_id = isset( $wp_query->post->ID ) ? $wp_query->post->ID : false;
		}
		$page_id = ( isset( $page_type_id ) ) ? $page_type_id : false;
		$page_id = is_home() ? get_option( 'page_for_posts' ) : $page_id;

		return $page_id;
	}

	/**
	 * Get pages ID
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function getPagesId() {
		$pages_id = false;
		$pages    = get_pages(
			array(
				'post_type'   => 'page',
				'post_status' => 'publish',
			)
		);

		if ( ! empty( $pages ) && is_array( $pages ) ) {
			$pages_id = array();
			foreach ( $pages as $page ) {
				$pages_id[] = $page->ID;
			}
		}
		return $pages_id;
	}

	/**
	 * Check woocommerce Activation
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function isWoocommerceActive() {
		return defined( 'WC_PLUGIN_FILE' );
	}

	/**
	 * Check cmf active
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function isCmfActive() {
		$theme_name_array   = array( 'CodexShaper_Framework', 'CMF Child' );
		$current_theme      = wp_get_theme();
		$current_theme_name = $current_theme->get( 'Name' );
		return in_array( $current_theme_name, $theme_name_array, true ) ? true : false;
	}

	/**
	 * Render elementor link attributes
	 *
	 * @since 1.0.0
	 *
	 * @param string $link Link.
	 * @param mixed  $class_list Class list.
	 *
	 * @return string
	 */
	public function renderElementorLinkAttributes( $link, $class_list = null ) {
		$return_val = '';

		if ( ! empty( $link['url'] ) ) {
			$return_val .= 'href="' . esc_url( $link['url'] ) . '"';
		}
		if ( ! empty( $link['is_external'] ) ) {
			$return_val .= 'target="_blank"';
		}
		if ( ! empty( $link['nofollow'] ) ) {
			$return_val .= 'rel="nofollow"';
		}
		if ( ! empty( $class_list ) ) {
			if ( is_array( $class_list ) ) {
				$return_val .= 'class="';
				foreach ( $class_list as $cl ) {
					$return_val .= $cl . ' ';
				}
				$return_val .= '"';
			} else {
				$return_val .= 'class="' . esc_attr( $class_list ) . '"';
			}
		}

		return $return_val;
	}

	/**
	 * Sanitize multi upload.
	 *
	 * @param array $fields Fields.
	 *
	 * @return array The sanitized fields.
	 */
	private static function sanitize_multi_upload( array $fields ): array {
		return array_map(
			static function ( $field ) {
				return array_map( array( self::class, 'sanitize_file_name' ), $field );
			},
			$fields
		);
	}

	/**
	 * Sanitize a file name.
	 *
	 * @param array $file File data.
	 *
	 * @return array The sanitized file data.
	 */
	private static function sanitize_file_name( array $file ): array {
		if ( isset( $file['name'] ) ) {
			$file['name'] = sanitize_file_name( $file['name'] );
		}

		return $file;
	}

	/**
	 * Get a value from a superglobal array in a safe way.
	 *
	 * @param array  $superGlobal Superglobal array (e.g., $_POST, $_FILES).
	 * @param string $key         The key to retrieve.
	 *
	 * @return mixed|null The sanitized value, or null if the key is not set.
	 */
	public static function get_super_global_value( array $superGlobal, string $key, $nonce_action = '' ) {

		if ( $nonce_action && isset( $superGlobal['_wpnonce'] ) && ! wp_verify_nonce( $superGlobal['_wpnonce'],  $nonce_action) ) {
            return;
        }

		if ( ! array_key_exists( $key, $superGlobal ) ) {
			return null;
		}

		if ( $superGlobal === $_FILES ) {
			return isset( $superGlobal[ $key ]['name'] )
				? self::sanitize_file_name( $superGlobal[ $key ] )
				: self::sanitize_multi_upload( $superGlobal[ $key ] );
		}

		return wp_kses_post_deep( wp_unslash( $superGlobal[ $key ] ) );
	}

	/**
	 * Check if the current request is a REST request.
	 *
	 * @return bool Whether the current request is a REST request.
	 */
	public static function is_rest_request() {
		$request_uri = static::get_super_global_value( $_SERVER, 'REQUEST_URI' );

		return false !== wp_get_referer() &&
			isset( $_SERVER['REQUEST_URI'] ) &&
			( false !== strpos( $request_uri, 'wp-json' ) || false !== strpos( $request_uri, 'rest_route' ) );
	}
}

