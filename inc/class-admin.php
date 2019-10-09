<?php
/**
 * Class provided for admin interface
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractor;

/**
 * Class provided for admin interface
 *
 * @since      1.0.0
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */
class Admin {

	/**
	 * Polylang constructor.
	 *
	 * @param Init $plugin PolylangStringExtractor plugin container.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Register all of the hooks related to the form post type
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function run() {
		$this->plugin['loader']->add_action( 'admin_footer', $this, 'display_scan_for_translations_button' );
		$this->plugin['loader']->add_action( 'admin_init', $this, 'handle_scan_for_translation' );
	}

	/**
	 * Add scan for translations button
	 *
	 * There is no any hook to print html on post table so we will use
	 * javascript to do it.
	 *
	 * @since    1.0.0
	 */
	public function display_scan_for_translations_button() {

		if ( ! $this->is_polylang_string_translation_view() ) {
			return;
		}

		?>
		<script type="text/html" id="tmpl-pllse-scan-for-translations">
			<input type="submit" name="pllse_scan_for_translations" id="pllse-scan-for-translations" class="button button-primary" style="margin: 1px 8px 0 0;" value="<?php echo esc_html__( 'Scan for translations', 'pllse' ); ?>">
		</script>
		<script type="text/javascript">

			(function($){

				$button = $('#post-query-submit');
				$tpl    = $('#tmpl-pllse-scan-for-translations');

				$button.after( $tpl.html() );

			})(jQuery);

		</script>
		<?php
	}

	/**
	 * Handle request when user click "Scan for translation" button
	 */
	public function handle_scan_for_translation() {

		$scan_for_translation = filter_input( INPUT_POST, 'pllse_scan_for_translations', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE );

		if ( false === $scan_for_translation ) {
			return;
		}

		$this->plugin['scanner']->scan();
	}

	/**
	 * Check if current view is form post type table view
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function is_polylang_string_translation_view() {

		$screen = get_current_screen();

		return 'languages_page_mlang_strings' === $screen->id;
	}
}
