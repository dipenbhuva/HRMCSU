<?php
/**
 * Welcome page of Enrollment Theme
 *
 * @package Code Vibrant
 * @subpackage Enrollment
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Enrollment_Welcome' ) ) :

class Enrollment_Welcome {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'load-themes.php', array( $this, 'admin_notice' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'about_theme_styles' ) );
		add_filter( 'admin_footer_text', array( $this, 'enrollment_admin_footer_text' ) );

		add_action( 'wp_ajax_enrollment_notice_dissmiss', array( $this, 'enrollment_hide_notices' ) );
        add_action( 'wp_ajax_nopriv_enrollment_notice_dissmiss', array( $this, 'enrollment_hide_notices' ) );

        //about theme review notice
        add_action( 'after_setup_theme', array( $this, 'enrollment_theme_rating_notice' ) );
		add_action( 'switch_theme', array( $this, 'enrollment_theme_rating_notice_data_remove' ) );
	}

	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		$theme = wp_get_theme( get_template() );

		$page = add_theme_page( esc_html__( 'Welcome', 'enrollment' ), esc_html__( 'Welcome', 'enrollment' ), 'activate_plugins', 'enrollment-welcome', array( $this, 'welcome_screen' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function about_theme_styles( $hook ) {

		global $enrollment_version;

		wp_enqueue_style( 'mt-theme-review-notice', get_template_directory_uri() . '/inc/about/theme-review-notice.css', array(), esc_attr( $enrollment_version ) );

		if ( 'appearance_page_enrollment-welcome' != $hook && 'themes.php' != $hook ) {
			return;
		}

		wp_enqueue_style( 'welcome-theme-style', get_template_directory_uri() . '/inc/welcome/welcome.css', array(), esc_attr( $enrollment_version ) );

		wp_enqueue_script( 'welcome-theme-script', get_template_directory_uri() . '/inc/welcome/welcome.js', array('jquery'), esc_attr( $enrollment_version ), true );
	}

	/**
	 * Add admin notice.
	 */
	public function admin_notice() {
		global $enrollment_version, $pagenow;

		// Let's bail on theme activation.
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );

		// No option? Let run the notice wizard again..
		} elseif ( ! get_option( 'enrollment_admin_notice_welcome' ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}

	/**
	 * Hide a notice if the GET variable is set.
	 */
	public function enrollment_hide_notices() {

		$output = array();
        $output['status'] = false;

        $wpnonce = ( isset( $_GET['_wpnonce'] ) ) ? esc_attr( wp_unslash( $_GET['_wpnonce'] ) ) : '';

        if ( ! wp_verify_nonce( $wpnonce, 'enrollment_dismiss_welcome_nonce' ) ) {
        	wp_send_json( $output );
        }

        update_option( 'enrollment_admin_notice_welcome', 1 );

        $output['status'] = true;

        wp_send_json( $output );
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {
		$theme 			= wp_get_theme( get_template() );
		$theme_name 	= $theme->get( 'Name' );
?>
		<div id="cv-theme-message" class="updated enrollment-message notice is-dismissible" data-nonce="<?php echo esc_attr( wp_create_nonce( 'enrollment_dismiss_welcome_nonce' ) ); ?>">
			<h2 class="welcome-title"><?php printf( esc_html__( 'Welcome to %s', 'enrollment' ), esc_html( $theme_name ) ); ?></h2>
			<p><?php printf( esc_html__( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our %2$s welcome page %3$s.', 'enrollment' ), esc_html( $theme_name ), '<a href="' . esc_url( admin_url( 'themes.php?page=enrollment-welcome' ) ) . '">', '</a>' ); ?></p>
			<p><a class="button button-primary button-hero" href="<?php echo esc_url( admin_url( 'themes.php?page=enrollment-welcome' ) ); ?>"><?php printf( esc_html__( 'Get started with %1$s', 'enrollment' ), esc_html( $theme_name ) ); ?></a></p>
		</div>
<?php
	}

	/**
	 * Intro text/links shown to all about pages.
	 *
	 * @access private
	 */
	private function intro() {
		global $enrollment_version;

		$theme 				= wp_get_theme( get_template() );
		$theme_name 		= $theme->get( 'Name' );
		$theme_description 	= $theme->get( 'Description' );
		$theme_uri 			= $theme->get( 'ThemeURI' );
		$author_uri 		= $theme->get( 'AuthorURI' );
		$author_name 		= $theme->get( 'Author' );
?>
		<div class="theme-info-wrapper">
			<div class="enrollment-theme-info">
				<h1> <?php printf( esc_html__( 'About %1$s', 'enrollment' ), esc_html( $theme_name ) ); ?> </h1>
				<div class="author-credit">
					<span class="theme-version"><?php printf( esc_html__( 'Version: %1$s', 'enrollment' ), $enrollment_version ); ?></span>
					<span class="author-link"><?php printf( wp_kses_post( 'By <a href="%1$s" target="_blank">%2$s</a>', 'enrollment' ), $author_uri, $author_name ); ?></span>
				</div>
				<div class="welcome-description-wrap">
					<div class="about-text"><?php echo wp_kses_post( $theme_description ); ?></div>

					<div class="enrollment-screenshot">
						<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
					</div>
				</div>
			</div>

			<p class="enrollment-actions">
				<a href="<?php echo esc_url( $theme_uri ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'enrollment' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'enrollment_demo_url', 'https://demo.codevibrant.com/enrollment/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'enrollment' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'enrollment_pro_theme_url', 'https://codevibrant.com/wpthemes/enrollment-pro/' ) ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'enrollment' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'enrollment_rating_url', 'https://wordpress.org/support/theme/enrollment/reviews/?filter=5' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'enrollment' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'enrollment_wp_tutorials', 'https://wpallresources.com/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'More Tutorials', 'enrollment' ); ?></a>
			</p>

			<div class="nav-tab-wrapper">
				<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'enrollment-welcome' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'enrollment-welcome' ), 'themes.php' ) ) ); ?>">
					<?php echo esc_html( $theme->display( 'Name' ) ); ?>
				</a>
				
				<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'enrollment-welcome', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>">
					<?php esc_html_e( 'Free Vs Pro', 'enrollment' ); ?>
				</a>

				<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'more_themes' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'enrollment-welcome', 'tab' => 'more_themes' ), 'themes.php' ) ) ); ?>">
					<?php esc_html_e( 'More Themes', 'enrollment' ); ?>
				</a>

				<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'enrollment-welcome', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>">
					<?php esc_html_e( 'Changelog', 'enrollment' ); ?>
				</a>
			</div>
		</div><!-- .theme-info-wrapper -->
<?php
	}

	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
		$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

		// Look for a {$current_tab}_screen method.
		if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
			return $this->{ $current_tab . '_screen' }();
		}

		// Fallback to about screen.
		return $this->about_screen();
	}

	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		$theme 		= wp_get_theme( get_template() );
		$theme_name = $theme->get( 'Name' );
	?>
		<div class="cv-wrap about-wrap">

			<?php $this->intro(); ?>

			<div class="changelog">
				<div class="under-the-hood two-col">
					<div class="col">
						<h3><?php esc_html_e( 'Theme Customizer', 'enrollment' ); ?></h3>
						<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'enrollment' ) ?></p>
						<p><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'enrollment' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Documentation', 'enrollment' ); ?></h3>
						<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'enrollment' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://docs.codevibrant.com/enrollment/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Documentation', 'enrollment' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got theme support question?', 'enrollment' ); ?></h3>
						<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'enrollment' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://codevibrant.com/support/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Support', 'enrollment' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Need more features?', 'enrollment' ); ?></h3>
						<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'enrollment' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://codevibrant.com/wpthemes/enrollment-pro/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'View PRO version', 'enrollment' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Have you need customization?', 'enrollment' ); ?></h3>
						<p><?php esc_html_e( 'Please send message with your requirement.', 'enrollment' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://codevibrant.com/contact/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Customization', 'enrollment' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php printf( esc_html( 'Translate %1$s', 'enrollment' ), esc_html( $theme_name ) ); ?></h3>
						<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'enrollment' ) ?></p>
						<p>
							<a href="<?php echo esc_url( 'https://translate.wordpress.org/projects/wp-themes/enrollment/' ); ?>" class="button button-secondary" target="_blank"><?php printf( esc_html( 'Translate %1$s', 'enrollment' ), esc_html( $theme_name ) ); ?></a>
						</p>
					</div>
				</div>
			</div><!-- .point-releases -->

			<div class="return-to-dashboard enrollment">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? esc_html_e( 'Return to Updates', 'enrollment' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'enrollment' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'enrollment' ) : esc_html_e( 'Go to Dashboard', 'enrollment' ); ?></a>
			</div><!-- .return-to-dashboard -->
		</div><!-- .about-wrap -->
	<?php
	}

	/**
	 * Output the more themes screen
	 */
	public function more_themes_screen() {
?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>
			<div class="theme-browser rendered">
				<div class="themes wp-clearfix">
					<?php
						// Set the argument array with author name.
						$args = array(
							'author' 	=> 'codevibrant',
							'per_page' 	=> 100
						);
						// Set the $request array.
						$request = array(
							'body' => array(
								'action'  => 'query_themes',
								'request' => serialize( (object)$args )
							)
						);
						$themes = $this->enrollment_get_themes( $request );
						if ( !is_wp_error( $themes ) ) {
							$active_theme = wp_get_theme()->get( 'Name' );
							$counter = 1;

							// For currently active theme.
							foreach ( $themes->themes as $theme ) {
								if ( $active_theme == $theme->name ) {
					?>
									<div id="<?php echo esc_attr( $theme->slug ); ?>" class="theme active">
										<div class="theme-screenshot">
											<img src="<?php echo esc_url( $theme->screenshot_url ); ?>"/>
										</div>
										<h3 class="theme-name" id="enrollment-name"><strong><?php esc_html_e( 'Active', 'enrollment' ); ?></strong>: <?php echo esc_html( $theme->name ); ?></h3>
										<div class="theme-actions">
											<a class="button button-primary customize load-customize hide-if-no-customize" href="<?php echo esc_url( get_site_url(). '/wp-admin/customize.php' ); ?>"><?php esc_html_e( 'Customize', 'enrollment' ); ?></a>
										</div>
									</div><!-- .theme active -->
						<?php
								$counter++;
								break;
								}
							}

							// For all other themes.
							foreach ( $themes->themes as $theme ) {
								if ( $active_theme != $theme->name ) {
									// Set the argument array with author name.
									$args = array(
										'slug' => esc_attr( $theme->slug ),
									);
									// Set the $request array.
									$request = array(
										'body' => array(
											'action'  => 'theme_information',
											'request' => serialize( (object)$args )
										)
									);
									$theme_details = $this->enrollment_get_themes( $request );
									if ( empty( $theme_details->template ) ) {
							?>
										<div id="<?php echo esc_attr( $theme->slug ); ?>" class="theme">
											<div class="theme-screenshot">
												<img src="<?php echo esc_url( $theme->screenshot_url ); ?>"/>
											</div>

											<h3 class="theme-name"><?php echo esc_html( $theme->name ); ?></h3>

											<div class="theme-actions">
												<?php if ( wp_get_theme( $theme->slug )->exists() ) { ?>
													<!-- Activate Button -->
													<a class="button button-secondary activate"
														href="<?php echo esc_url( wp_nonce_url( admin_url( 'themes.php?action=activate&amp;stylesheet=' . urlencode( $theme->slug ) ), 'switch-theme_' . esc_attr( $theme->slug ) ) ); ?>" ><?php esc_html_e( 'Activate', 'enrollment' ) ?></a>
												<?php } else {
													// Set the install url for the theme.
													$install_url = add_query_arg( array(
														'action' => 'install-theme',
														'theme'  => esc_attr( $theme->slug ),
													), self_admin_url( 'update.php' ) );
												?>
													<!-- Install Button -->
													<a data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_attr( 'Downloaded ', 'enrollment' ). number_format( $theme_details->downloaded ).' '.esc_attr( 'times', 'enrollment' ); ?>" class="button button-secondary activate" href="<?php echo esc_url( wp_nonce_url( $install_url, 'install-theme_' . $theme->slug ) ); ?>" ><?php esc_html_e( 'Install Now', 'enrollment' ); ?></a>
												<?php } ?>

												<a class="button button-primary load-customize hide-if-no-customize" target="_blank" href="<?php echo esc_url( $theme->preview_url ); ?>"><?php esc_html_e( 'Live Preview', 'enrollment' ); ?></a>
											</div>
										</div><!-- .theme -->
					<?php
									}
								}
							}
						}
					?>
				</div>
			</div><!-- .cv-theme-holder -->
		</div><!-- .wrap.about-wrap -->
<?php
	}

	/** 
	 * Get all our themes by using API.
	 */
	private function enrollment_get_themes( $request ) {

		// Generate a cache key that would hold the response for this request:
		$key = 'enrollment_' . md5( serialize( $request ) );

		// Check transient. If it's there - use that, if not re fetch the theme
		if ( false === ( $themes = get_transient( $key ) ) ) {

			// Transient expired/does not exist. Send request to the API.
			$response = wp_remote_post( 'http://api.wordpress.org/themes/info/1.0/', $request );

			// Check for the error.
			if ( !is_wp_error( $response ) ) {

				$themes = unserialize( wp_remote_retrieve_body( $response ) );

				if ( !is_object( $themes ) && !is_array( $themes ) ) {

					// Response body does not contain an object/array
					return new WP_Error( 'theme_api_error', 'An unexpected error has occurred' );
				}

				// Set transient for next time... keep it for 24 hours should be good
				set_transient( $key, $themes, 60 * 60 * 24 );
			}
			else {
				// Error object returned
				return $response;
			}
		}
		return $themes;
	}
	
	/**
	 * Output the changelog screen.
	 */
	public function changelog_screen() {
		global $wp_filesystem;

	?>
		<div class="cv-wrap about-wrap">

			<?php $this->intro(); ?>

			<h4><?php esc_html_e( 'View changelog below:', 'enrollment' ); ?></h4>

			<?php
				$changelog_file = apply_filters( 'enrollment_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
	<?php
	}

	/**
	 * Parse changelog from readme file.
	 * @param  string $content
	 * @return string
	 */
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}

		return wp_kses_post( $changelog );
	}

	/**
	 * Output the free vs pro screen.
	 */
	public function free_vs_pro_screen() {
		$pro_theme_url = 'https://codevibrant.com/wpthemes/enrollment-pro';
		$pro_theme_url = apply_filters( 'enrollment_pro_theme_url', $pro_theme_url );
?>
		<div class="cv-wrap about-wrap">

			<?php $this->intro(); ?>

			<div class="comparison-header">
				<div class="table-info">
					<h3 class="table-title"><?php esc_html_e( 'Upgrade to Pro', 'enrollment' ); ?></h3>
					<p><?php esc_html_e( 'Upgrade to pro version for additional features and better supports.', 'enrollment' ); ?></p>
				</div>
				<div class="table-price"><a href="<?php echo esc_url( $pro_theme_url ); ?>" target="_blank"><?php esc_html_e( 'Buy Now', 'enrollment' ); ?></a></div>
			</div><!-- .comparison-header -->

			<table>
				<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e( 'Features', 'enrollment' ); ?></h3></th>
						<th><h3><?php esc_html_e( 'Enrollment', 'enrollment' ); ?></h3></th>
						<th><h3><?php esc_html_e( 'Enrollment Pro', 'enrollment' ); ?></h3></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><h3><?php esc_html_e( 'Price', 'enrollment' ); ?></h3></td>
						<td><?php esc_html_e( 'Free', 'enrollment' ); ?></td>
						<td><?php esc_html_e( '$59', 'enrollment' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Import Demo Data', 'enrollment' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Pre Loaders', 'enrollment' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Header Layouts', 'enrollment' ); ?></h3></td>
						<td><?php esc_html_e( '1', 'enrollment' ); ?></td>
						<td><?php esc_html_e( '4', 'enrollment' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Archive Pages Layouts', 'enrollment' ); ?></h3></td>
						<td><?php esc_html_e( '2', 'enrollment' ); ?></td>
						<td><?php esc_html_e( '2', 'enrollment' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Google Fonts', 'enrollment' ); ?></h3></td>
						<td><?php esc_html_e('2', 'enrollment');?></td>
						<td><?php esc_html_e( '600+', 'enrollment' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'No. of Widgets', 'enrollment' ); ?></h3></td>
						<td><?php esc_html_e( '8', 'enrollment' ); ?></td>
						<td><?php esc_html_e( '12', 'enrollment' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Custom 404 page', 'enrollment' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Animation on Section', 'enrollment' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="btn-wrapper">
							<a href="<?php echo esc_url( $pro_theme_url ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Buy Pro', 'enrollment' ); ?></a>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
		<?php
	}

	/**
	 * Set the required option value as needed for theme review notice.
	 */
	public function enrollment_theme_rating_notice() {

		// Set the installed time in `enrollment_theme_installed_time` option table.
		$option = get_option( 'enrollment_theme_installed_time' );

		if ( ! $option ) {
			update_option( 'enrollment_theme_installed_time', time() );
		}

		add_action( 'admin_notices', array( $this, 'enrollment_theme_review_notice' ), 0 );
		add_action( 'admin_init', array( $this, 'enrollment_ignore_theme_review_notice' ), 0 );
		add_action( 'admin_init', array( $this, 'enrollment_ignore_theme_review_notice_partially' ), 0 );

	}

	/**
	 * Display the theme review notice.
	 */
	public function enrollment_theme_review_notice() {

		global $current_user;
		$user_id                  = $current_user->ID;
		$ignored_notice           = get_user_meta( $user_id, 'enrollment_ignore_theme_review_notice', true );
		$ignored_notice_partially = get_user_meta( $user_id, 'cv_enrollmentignore_theme_review_notice_partially', true );

		/**
		 * Return from notice display if:
		 *
		 * 1. The theme installed is less than 15 days ago.
		 * 2. If the user has ignored the message partially for 15 days.
		 * 3. Dismiss always if clicked on 'I Already Did' button.
		 */
		if ( ( get_option( 'enrollment_theme_installed_time' ) > strtotime( '- 15 days' ) ) || ( $ignored_notice_partially > time() ) || ( $ignored_notice ) ) {
			return;
		}
?>

		<div class="notice updated theme-review-notice">
			<p>
				<?php
					printf( esc_html__( 'Howdy, %1$s! It seems that you have been using this theme for more than 15 days. We hope you are happy with everything that the theme has to offer. If you can spare a minute, please help us by leaving a 5-star review on WordPress.org.  By spreading the love, we can continue to develop new amazing features in the future, for free!', 'enrollment'
						), '<strong>' . esc_html( $current_user->display_name ) . '</strong>' );
				?>
			</p>

			<div class="links">
				<a href="https://wordpress.org/support/theme/enrollment/reviews/?filter=5#new-post" class="btn button-primary" target="_blank">
					<span class="dashicons dashicons-thumbs-up"></span>
					<span><?php esc_html_e( 'Sure', 'enrollment' ); ?></span>
				</a>

				<a href="?cv_enrollmentignore_theme_review_notice_partially=0" class="btn button-secondary">
					<span class="dashicons dashicons-calendar"></span>
					<span><?php esc_html_e( 'Maybe later', 'enrollment' ); ?></span>
				</a>

				<a href="?cv_enrollmentignore_theme_review_notice=0" class="btn button-secondary">
					<span class="dashicons dashicons-smiley"></span>
					<span><?php esc_html_e( 'I already did', 'enrollment' ); ?></span>
				</a>

				<a href="<?php echo esc_url( 'https://wordpress.org/support/theme/enrollment/' ); ?>" class="btn button-secondary" target="_blank">
					<span class="dashicons dashicons-edit"></span>
					<span><?php esc_html_e( 'Got theme support question?', 'enrollment' ); ?></span>
				</a>
			</div>

			<a class="notice-dismiss" href="?cv_enrollmentignore_theme_review_notice_partially=0"></a>
		</div>

<?php
	}

	/**
	 * Function to remove the theme review notice permanently as requested by the user.
	 */
	public function enrollment_ignore_theme_review_notice() {

		global $current_user;
		$user_id = $current_user->ID;

		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['cv_enrollmentignore_theme_review_notice'] ) && '0' == $_GET['cv_enrollmentignore_theme_review_notice'] ) {
			add_user_meta( $user_id, 'enrollment_ignore_theme_review_notice', 'true', true );
		}

	}

	/**
	 * Function to remove the theme review notice partially as requested by the user.
	 */
	public function enrollment_ignore_theme_review_notice_partially() {

		global $current_user;
		$user_id = $current_user->ID;

		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['cv_enrollmentignore_theme_review_notice_partially'] ) && '0' == $_GET['cv_enrollmentignore_theme_review_notice_partially'] ) {
			update_user_meta( $user_id, 'cv_enrollmentignore_theme_review_notice_partially', strtotime( '+ 7 days' ) );
		}

	}

	/**
	 * Remove the data set after the theme has been switched to other theme.
	 */
	public function enrollment_theme_rating_notice_data_remove() {

		global $current_user;
		$user_id                  = $current_user->ID;
		$theme_installed_time     = get_option( 'enrollment_theme_installed_time' );
		$ignored_notice           = get_user_meta( $user_id, 'enrollment_ignore_theme_review_notice', true );
		$ignored_notice_partially = get_user_meta( $user_id, 'cv_enrollmentignore_theme_review_notice_partially', true );

		// Delete options data.
		if ( $theme_installed_time ) {
			delete_option( 'enrollment_theme_installed_time' );
		}

		// Delete permanent notice remove data.
		if ( $ignored_notice ) {
			delete_user_meta( $user_id, 'enrollment_ignore_theme_review_notice' );
		}

		// Delete partial notice remove data.
		if ( $ignored_notice_partially ) {
			delete_user_meta( $user_id, 'cv_enrollmentignore_theme_review_notice_partially' );
		}

	}

	/**
     * Display custom text on theme welcome page
     *
     * @param string $text
     */
    public function enrollment_admin_footer_text( $text ) {
        $screen = get_current_screen();

        if ( 'appearance_page_enrollment-welcome' == $screen->id ) {

        	$theme = wp_get_theme( get_template() );
			$theme_name = $theme->get( 'Name' );

            $text = sprintf( __( 'If you like <strong>%1$s</strong> please leave us a %2$s rating. A huge thank you from <strong>CodeVibrant</strong> in advance!', 'enrollment' ), esc_html( $theme_name ), '<a href="https://wordpress.org/support/theme/enrollment/reviews/?filter=5" class="theme-rating" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a>' );

        }

        return $text;
    }
}

endif;

return new Enrollment_Welcome();