<?php
/**
 * Template Name: Home Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CodeVibrant
 * @subpackage Enrollment
 * @since 1.0.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				/**
				 * Display the widget area section at homepage
				 *
				 * @since 1.0.0
				 */
	        	if ( is_active_sidebar( 'enrollment_home_section_area' ) ) {
	            	dynamic_sidebar( 'enrollment_home_section_area' );
	         	}
			?>
			
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
