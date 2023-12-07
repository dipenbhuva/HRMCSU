<?php
/** 
 * Short Customizer partials.
 *
 * @package Short
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Short_Customizer_Partials' ) ) {

	/**
	 * Customizer Partials.
	 */
	class Short_Customizer_Partials {

		/**
		 * Instance.
		 *
		 * @access private
		 * @var object
		 */
		private static $instance;

		/**
		 * Initiator.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		// site title
		public static function customize_partial_blogname() {
			return get_bloginfo( 'name' );
		}

		// Site tagline
		public static function customize_partial_blogdescription() {
			return get_bloginfo( 'description' );
		}
	}
}

Short_Customizer_Partials::get_instance();