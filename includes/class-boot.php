<?php
/**
 * Class BOot
 * Handles the bootstrapping for the plugin
 *
 * @package     OllyWarren\WP-Wakatime
 * @author      Olly Warren
 * @copyright   2017 Olly Warren
 * @license     GPL-2.0+
 */

namespace Wp_Wakatime;

/**
 * Class that boots the plugin.
 */
class Boot {

	/**
	 * On_boot
	 *
	 * Setup of the plugin when it boots.
	 *
	 *  1. Registers the Options Page with the 'admin_menu' Hook.
	 *  Displays the Options page to add in the Wakatime API Key.
	 *
	 *  2. Registers the custom Widgets to display the Wakatime
	 *  Information on the front side of the Website. Widgets
	 *  are located in the Includes folder and follow the
	 *  following convention for naming: nameWidget.php
	 *
	 *  3. Registers the Stylesheet to manage the Progress bar visuals.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
	public static function on_boot() {
		// 1. Setup Configuration Page.
		add_action( 'admin_menu', [ 'Wp_Wakatime\Boot', 'register_options_page' ] );

		// 2. Register the Custom Widgets.
		add_action( 'widgets_init', function() {
			register_widget( 'Wp_Wakatime\Widgets\languageWidget' );
		});

		// 3. Register the Custom CSS.
		add_action( 'wp_enqueue_scripts', [ 'Wp_Wakatime\Boot', 'queue_styles' ] );
	}

	/**
	 * Activate
	 *
	 * Actions to run on activation.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
	public static function activate() {
	}

	/**
	 * Deactivate
	 *
	 * Actions to run on deactivation.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
	public static function deactivate() {
	}

	/**
	 * Install
	 *
	 * Actions to run on install.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
	public static function install() {
	}

	/**
	 * Uninstall
	 *
	 * Actions to run on uninstall.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
	public static function uninstall() {
	}


	/**
	 * Register_options_page
	 *
	 * 1. Registers the options page with WordPress using the add_options_page function.
	 *    Calls the render_options_page method of this class to render the markup for the
	 *    actual options page itself.
	 *
	 * 2. Registers a options group for the plugin along with a option to hold the API
	 *    token from Wakatime.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
	public static function register_options_page() {
		// 1. Registers the Options Page.
		add_options_page( 'WP Wakatime', 'WP Wakatime', 'manage_options', 'wp-wakatime-settings', [ 'Wp_Wakatime\Boot', 'render_options_page' ] );

		// 2. Configures the Setting. Wakatime API Key
		register_setting( 'wp-wakatime-settings', 'wakatime_api_key' );
	}

	/**
	 * Render_options_page
	 *
	 * Defines the markup for the Options page.
	 *
	 * @author  Olly Warren, Big Bite Creative
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
	public static function render_options_page() {
		echo '<div class="wrap">';
		echo '<h2>WP Wakatime Settings</h2>';
		echo '<hr />';
		echo '<form method="post" action="options.php">';
		settings_fields( 'wp-wakatime-settings' );
		do_settings_sections( 'wp-wakatime-settings' );
		echo '<table class="form-table">';
		echo '<tr valign="top">';
		echo '<th scope="row">Wakatime API Key</th>';
		echo '<td><input type="text" name="wakatime_api_key" value="' . esc_attr( get_option( 'wakatime_api_key' ) ) . '" /></td>';
		echo '</tr>';
		echo '</table>';
		submit_button( 'Save Configuration' );
		echo '</form>';
		echo '</div>';
	}

	/**
	 * Queue_styles
	 *
	 * Queues up the Stylesheet
	 *
	 * @author  Olly Warren, Big Bite Creative
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
	public static function queue_styles() {
		wp_enqueue_style( 'wp-wakatime-style', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/wp_wakatime.css' );
	}
}
