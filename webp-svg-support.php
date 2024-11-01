<?php
/**
 * Plugin Name:       WebP & SVG Support
 * Plugin URI:        https://wordpress.org/plugins/webp-svg-support/
 * Description:       Allows WebP and SVG image file upload into WordPress media and sanitizes before saving it.
 * Version:           1.4.0
 * Author:            Reza Khan
 * Author URI:        https://www.reza-khan.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       webp-svg-support
 * Domain Path:       /languages
 *
 * WebP & SVG Support is a free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.

 * WebP & SVG Support essential is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with WebP & SVG Support. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package webpsvg
 * @category Core
 * @author Reza Khan
 * @version 1.4.0
 */

defined( 'ABSPATH' ) || wp_die( 'No access directly.' );

/**
 * Main class
 *
 * @since 1.0.0
 */
class Webpsvg_Support {

	/**
	 * Instance of Webpsvg_Support class.
	 *
	 * @since 1.0.0
	 *
	 * @var Webpsvg_Support $instance Holds the class singleton instance.
	 */
	public static $instance = null;

	/**
	 * Returns singleton instance of current class.
	 *
	 * @since 1.0.0
	 *
	 * @return Webpsvg_Support
	 */
	public static function init() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor function for Webpsvg_Support class.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'initialize_modules' ) );
	}

	/**
	 * Loads plugin textdomain directory.
	 *
	 * @since 1.0.0
	 */
	public function i18n() {
		load_plugin_textdomain( 'webp-svg-support', false, self::plugin_dir() . 'languages/' );
	}

	/**
	 * Initialize plugin modules.
	 *
	 * @since 1.0.0
	 */
	public function initialize_modules() {
		do_action( 'webpsvg_before_load' );

		require_once self::core_dir() . 'bootstrap.php';
		Webpsvg_Support\Core\Bootstrap::instance()->init();

		do_action( 'webpsvg_after_load' );
	}

	/**
	 * Sets an option when plugin activation hook is called.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function webpsvg_activate() {
		// do something.
		update_option( 'webpsvg_allow_webp', 'yes' );
		update_option( 'webpsvg_allow_svg', 'yes' );
	}

	/**
	 * Sets an option when plugin deactivation hook is called.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function webpsvg_deactivate() {
		// do something.
		delete_option( 'webpsvg_allow_webp' );
		delete_option( 'webpsvg_allow_svg' );
	}

	/**
	 * Plugin Version.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function version() {
		return '1.4.0';
	}

	/**
	 * Core Url.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function core_url() {
		return trailingslashit( self::plugin_url() . 'core' );
	}

	/**
	 * Core Directory Path.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function core_dir() {
		return trailingslashit( self::plugin_dir() . 'core' );
	}

	/**
	 * Plugin Url.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function plugin_url() {
		return trailingslashit( plugin_dir_url( self::plugin_file() ) );
	}

	/**
	 * Plugin Directory Path.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function plugin_dir() {
		return trailingslashit( plugin_dir_path( self::plugin_file() ) );
	}

	/**
	 * Plugins Basename.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function plugins_basename() {
		return plugin_basename( self::plugin_file() );
	}

	/**
	 * Plugin File.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function plugin_file() {
		return __FILE__;
	}
}

/**
 * Load Webpsvg_Support plugin when all plugins are loaded
 *
 * @since 1.0.0
 *
 * @return Webpsvg_Support
 */
function webpsvg() {
	return Webpsvg_Support::init();
}

// Let's go...
webpsvg();

/* Do something when the plugin is activated? */
register_activation_hook( __FILE__, array( 'Webpsvg_Support', 'webpsvg_activate' ) );

/* Do something when the plugin is deactivated? */
register_deactivation_hook( __FILE__, array( 'Webpsvg_Support', 'webpsvg_deactivate' ) );
