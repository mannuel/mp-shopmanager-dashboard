<?php
/**
* mpsmd - MP Shop Manager Dashboard
* Author: Manuel Padilla manuel@plugdigital.net
*/
class mpsmd {
	private static $initiated = false;

	public static function init() {
		$current_user = wp_get_current_user();
		if ($current_user->roles[0] === "shop_manager") {
			if ( ! self::$initiated ) {
				self::init_hooks();
			}
		}
	}

	/**
	 * Initializes WordPress hooks
	 */
	private static function init_hooks() {
		self::$initiated = true;
		add_filter( 'login_redirect',  array( 'mpsmd', 'admin_default_page' ) );
		add_action( 'admin_enqueue_scripts', array( 'mpsmd', 'admin_scripts' ) );
		add_action( 'admin_menu', array( 'mpsmd', 'remove_menus' ) );
		add_filter( 'custom_menu_order', array( 'mpsmd', 'reorder_admin_menu' ) );
		add_filter( 'menu_order', array( 'mpsmd', 'reorder_admin_menu' ) );
		add_action( 'wp_dashboard_setup', array( 'mpsmd', 'remove_dashboard_widgets' ) );
		add_action( 'gettext', array( 'mpsmd', 'rename_header_to_logo' ), 10, 3 );
	}

	/**
	 * Enqueue Scripts
	 */
	public static function admin_scripts() {
		wp_register_style( 'mpsmd-admin-styles', plugin_dir_url( __FILE__ ) . 'assets/css/mp-shopmanager-dashboard.admin.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( 'mpsmd-admin-styles' );
	}

	/**
	 * Removing Dashboard menu options
	 */
	public static function remove_menus(){
		remove_menu_page( 'edit.php?post_type=testimonial' );
		remove_menu_page( 'edit.php?post_type=etheme_portfolio' );
		remove_menu_page( 'edit.php?post_type=staticblocks' );
		remove_menu_page( 'wpcf7' );
		remove_menu_page( 'vc-welcome' );
	}

	/**
	 * Re-order Dashboard menu
	 */
	public static function reorder_admin_menu( $__return_true ) {
		return array(
			'index.php', // Dashboard
			'woocommerce', // Store
			'edit.php?post_type=product', // Products
			'separator1', // --Space--
			'edit.php?post_type=page', // Pages 
			'edit.php', // Posts
			'upload.php', // Media
			'themes.php', // Appearance
			'separator2', // --Space--
			'edit-comments.php', // Comments 
			'users.php', // Users
			'separator3', // --Space--
			'plugins.php', // Plugins
			'tools.php', // Tools
			'options-general.php', // Settings
		);
	}

	/**
	 * Removing Dashboard widgets
	 */
	public static function remove_dashboard_widgets () {
		remove_meta_box('dashboard_quick_press','dashboard','side'); //Quick Press widget
		remove_meta_box('dashboard_recent_drafts','dashboard','side'); //Recent Drafts
		remove_meta_box('dashboard_primary','dashboard','side'); //WordPress.com Blog
		remove_meta_box('dashboard_secondary','dashboard','side'); //Other WordPress News
		remove_meta_box('dashboard_incoming_links','dashboard','normal'); //Incoming Links
		remove_meta_box('dashboard_plugins','dashboard','normal'); //Plugins
		remove_meta_box('dashboard_right_now','dashboard', 'normal'); //Right Now
		remove_meta_box('rg_forms_dashboard','dashboard','normal'); //Gravity Forms
		remove_meta_box('dashboard_recent_comments','dashboard','normal'); //Recent Comments
		remove_meta_box('icl_dashboard_widget','dashboard','normal'); //Multi Language Plugin
		remove_meta_box('dashboard_activity','dashboard', 'normal'); //Activity
		remove_meta_box('woocommerce_dashboard_recent_reviews','dashboard', 'normal'); //Activity
		remove_action('welcome_panel','wp_welcome_panel');
	}

	/**
	 * Change admin default page
	 */
	public static function admin_default_page() {
		return '/wp-admin/admin.php?page=wc-reports';
	}

	/**
	 * Change WooCommerce dashboard menu option
	 */
	public static function rename_header_to_logo( $translated, $original, $domain ) {
		$strings = array(
			'WooCommerce'   => 'Store',
			'Custom Header' => 'Custom Store'
		);

		if ( isset( $strings[$original] ) && is_admin() ) {
			$translations = &get_translations_for_domain( $domain );
			$translated = $translations->translate( $strings[$original] );
		}

		return $translated;
	}


} //class mpsmd end

/**
 * Pwered by shortcode
 */
function poweredby( $atts ) {
	$a = shortcode_atts( array(
		'color' => 'color'
	), $atts );

	switch ($a['color']) {
		case 'color':
			$marq_logo       = MPSMD__PLUGIN_DIR_URL . "assets/img/marq-logo.png";
			$marq_color_text = "#444";
			break;

		case 'white':
			$marq_logo       = MPSMD__PLUGIN_DIR_URL . "assets/img/marq-logo_w.png";
			$marq_color_text = "#fff";
			break;
		
		default:
			$marq_logo       = MPSMD__PLUGIN_DIR_URL . "assets/img/marq-logo.png";
			$marq_color_text = "#444";
			break;
	}
	?>
	<div class="vc_row wpb_row vc_row-fluid">
		<div class="text-right wpb_column vc_column_container vc_col-sm-6 vc_col-xs-7">
			<div class="vc_column-inner ">
				<div class="wpb_wrapper">
					<div class="wpb_text_column wpb_content_element">
						<div class="wpb_wrapper">
							<p style="color: <?php echo $marq_color_text; ?>">Powered by<br>
							<a style="font-weight: bold; font-size: 1.5em; color: <?php echo $marq_color_text; ?>" href="http://marqcreative.com" target="_blank">MarQ Creative</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="wpb_column vc_column_container vc_col-sm-6 vc_col-xs-5">
			<div class="vc_column-inner ">
				<div class="wpb_wrapper">
					<div class="wpb_single_image wpb_content_element vc_align_left">
						<figure class="wpb_wrapper vc_figure">
							<div class="vc_single_image-wrapper vc_box_border_grey">
								<a href="http://marqcreative.com" target="_blank">
									<img class="vc_single_image-img" src="<?php echo $marq_logo; ?>" width="47" height="47" alt="marq-logo" title="marq-logo">
								</a>
							</div>
						</figure>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
add_shortcode( 'poweredby', 'poweredby' );