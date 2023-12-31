<?php
/**
 * Create a metabox to added some custom filed in posts.
 *
 * @package CodeVibrant
 * @subpackage Enrollment
 * @since 1.0.0
 */

add_action( 'add_meta_boxes', 'enrollment_post_meta_options' );

if ( ! function_exists( 'enrollment_post_meta_options' ) ):
    
    function  enrollment_post_meta_options() {
        add_meta_box(
            'enrollment_post_meta',
            esc_html__( 'Post Options', 'enrollment' ),
            'enrollment_post_meta_callback',
            'post',
            'normal',
            'high'
        );
    }

endif;

$enrollment_post_sidebar_options = array(
    'default-sidebar' => array(
        'id'		=> 'post-default-sidebar',
        'value'     => 'default_sidebar',
        'label'     => esc_html__( 'Default Sidebar', 'enrollment' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/default-sidebar.png'
    ),
    'left-sidebar' => array(
        'id'		=> 'post-right-sidebar',
        'value'     => 'left_sidebar',
        'label'     => esc_html__( 'Left sidebar', 'enrollment' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/left-sidebar.png'
    ),
    'right-sidebar' => array(
        'id'		=> 'post-left-sidebar',
        'value'     => 'right_sidebar',
        'label'     => esc_html__( 'Right sidebar', 'enrollment' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/right-sidebar.png'
    ),
    'no-sidebar' => array(
        'id'		=> 'post-no-sidebar',
        'value'     => 'no_sidebar',
        'label'     => esc_html__( 'No sidebar Full width', 'enrollment' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/no-sidebar.png'
    ),
    'no-sidebar-center' => array(
        'id'		=> 'post-no-sidebar-center',
        'value'     => 'no_sidebar_center',
        'label'     => esc_html__( 'No sidebar Content Centered', 'enrollment' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/no-sidebar-center.png'
    )
);


if ( ! function_exists( 'enrollment_post_meta_callback' ) ) :
	
    /**
     * Callback function for post option
     */
    function enrollment_post_meta_callback() {
		global $post, $enrollment_post_sidebar_options;

        $get_post_meta_identity = get_post_meta( $post->ID, 'post_meta_identity', true );
        $post_identity_value = empty( $get_post_meta_identity ) ? 'cv-metabox-info' : $get_post_meta_identity;

		wp_nonce_field( basename( __FILE__ ), 'enrollment_post_meta_nonce' );
?>
		<div class="cv-meta-container clearfix">
			<ul class="cv-meta-menu-wrapper">
				<li class="cv-meta-tab <?php if ( $post_identity_value == 'cv-metabox-info' ) { echo 'active'; } ?>" data-tab="cv-metabox-info"><span class="dashicons dashicons-clipboard"></span><?php esc_html_e( 'Information', 'enrollment' ); ?></li>
				<li class="cv-meta-tab <?php if ( $post_identity_value == 'cv-metabox-sidebar' ) { echo 'active'; } ?>" data-tab="cv-metabox-sidebar"><span class="dashicons dashicons-exerpt-view"></span><?php esc_html_e( 'Sidebars', 'enrollment' ); ?></li>
			</ul><!-- .cv-meta-menu-wrapper -->
			<div class="cv-metabox-content-wrapper">
				
				<!-- Info tab content -->
				<div class="cv-single-meta active" id="cv-metabox-info">
					<div class="content-header">
						<h4><?php esc_html_e( 'About Metabox Options', 'enrollment' ) ;?></h4>
					</div><!-- .content-header -->
					<div class="meta-options-wrap"><?php esc_html_e( 'At Metabox there are option for sidebars.', 'enrollment' ); ?></div><!-- .meta-options-wrap  -->
				</div><!-- #cv-info-content -->

				<!-- Sidebar tab content -->
				<div class="cv-single-meta" id="cv-metabox-sidebar">
					<div class="content-header">
						<h4><?php esc_html_e( 'Available Sidebars', 'enrollment' ) ;?></h4>
						<span class="section-desc"><em><?php esc_html_e( 'Select sidebar from available options which replaced sidebar layout from customizer settings.', 'enrollment' ); ?></em></span>
					</div><!-- .content-header -->
					<div class="cv-meta-options-wrap">
						<div class="buttonset">
							<?php
			                   	foreach ( $enrollment_post_sidebar_options as $field ) {
			                    	$enrollment_post_sidebar = get_post_meta( $post->ID, 'single_post_sidebar', true );
                                    $enrollment_post_sidebar = ( $enrollment_post_sidebar ) ? $enrollment_post_sidebar : 'default_sidebar';
			                ?>
			                    	<input type="radio" id="<?php echo esc_attr( $field['id'] ); ?>" value="<?php echo esc_attr( $field['value'] ); ?>" name="single_post_sidebar" <?php checked( $field['value'], $enrollment_post_sidebar ); ?> />
			                    	<label for="<?php echo esc_attr( $field['id'] ); ?>">
			                    		<span class="screen-reader-text"><?php echo esc_html( $field['label'] ); ?></span>
			                    		<img src="<?php echo esc_url( $field['thumbnail'] ); ?>" title="<?php echo esc_attr( $field['label'] ); ?>" alt="<?php echo esc_attr( $field['label'] ); ?>" />
			                    	</label>
			                    
			                <?php } ?>
						</div><!-- .buttonset -->
					</div><!-- .meta-options-wrap  -->
				</div><!-- #cv-sidebar-content -->

			</div><!-- .cv-metabox-content-wrapper -->
            <div class="clear"></div>
            <input type="hidden" id="post-meta-selected" name="post_meta_identity" value="<?php echo esc_attr( $post_identity_value ); ?>" />
		</div><!-- .cv-meta-container -->
<?php
	}

endif;

/*------------------------------------------------------------------------------------------------------------------------------------*/

add_action( 'save_post', 'enrollment_save_post_meta' );

if ( ! function_exists( 'enrollment_save_post_meta' ) ):

    /**
     * Function for save value of meta options
     *
     * @since 1.0.0
     */
    function enrollment_save_post_meta( $post_id ) {

        global $post;

        // Verify the nonce before proceeding.
        $enrollment_post_nonce   = isset( $_POST['enrollment_post_meta_nonce'] ) ? $_POST['enrollment_post_meta_nonce'] : '';
        $enrollment_post_nonce_action = basename( __FILE__ );

        //* Check if nonce is set...
        if ( ! isset( $enrollment_post_nonce ) ) {
            return;
        }

        //* Check if nonce is valid...
        if ( ! wp_verify_nonce( $enrollment_post_nonce, $enrollment_post_nonce_action ) ) {
            return;
        }

        //* Check if user has permissions to save data...
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

        //* Check if not an autosave...
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }

        //* Check if not a revision...
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        /*Page sidebar*/
        $old = get_post_meta( $post_id, 'single_post_sidebar', true );
        $new = sanitize_text_field( $_POST['single_post_sidebar'] );

        if ( $new && $new != $old ) {
            update_post_meta ( $post_id, 'single_post_sidebar', $new );
        } elseif ( '' == $new && $old ) {
            delete_post_meta( $post_id,'single_post_sidebar', $old );
        }

        /**
         * post meta identity
         */
        $post_identity = get_post_meta( $post_id, 'post_meta_identity', true );
        $stz_post_identity = sanitize_text_field( $_POST[ 'post_meta_identity' ] );

        if ( $stz_post_identity && '' == $stz_post_identity ){
            add_post_meta( $post_id, 'post_meta_identity', $stz_post_identity );
        }elseif ( $stz_post_identity && $stz_post_identity != $post_identity ) {
            update_post_meta($post_id, 'post_meta_identity', $stz_post_identity );
        } elseif ( '' == $stz_post_identity && $post_identity ) {
            delete_post_meta( $post_id, 'post_meta_identity', $post_identity );
        }
    }
    
endif;  