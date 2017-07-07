<?php

namespace Wp_Wakatime;

class Boot {

	/**
	 * onBoot
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
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
    public static function onBoot()
    {
	    //1. Setup Configuration Page
	    add_action( 'admin_menu', ['Wp_Wakatime\Boot', 'registerOptionsPage'] );

	    //2. Register the Custom Widgets
	    add_action( 'widgets_init', function(){
	    	register_widget('Wp_Wakatime\Widgets\languageWidget');
	    });
    }

	/**
	 * activate
	 *
	 * Actions to run on activation.
	 *
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
    public static function activate()
    {
    }

	/**
	 * deactivate
	 *
	 * Actions to run on deactivation.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
    public static function deactivate()
    {
    }

	/**
	 * install
	 *
	 * Actions to run on install.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
    public static function install()
    {
    }

	/**
	 * uninstall
	 *
	 * Actions to run on uninstall.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
    public static function uninstall()
    {
    }


	/**
	 * registerOptionsPage
	 *
	 * 1. Registers the options page with wordpress using the add_options_page function.
	 *    Calls the renderOptionsPage method of this class to render the markup for the
	 *    actual options page itself.
	 *
	 * 2. Registers a options group for the plugin along with a option to hold the API
	 *    token from Wakatime.
	 *
	 * @author  Olly Warren
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
    public static function registerOptionsPage()
    {
	    //1. Registers the Options Page.
	    add_options_page('WP Wakatime', 'WP Wakatime', 'manage_options', 'wp-wakatime-settings', ['Wp_Wakatime\Boot', 'renderOptionsPage']);

	    //2. Configures the Setting. Wakatime API Key
	    register_setting('wp-wakatime-settings', 'wakatime_api_key');
    }

	/**
	 * renderOptionsPage
	 *
	 * Defines the markup for the Options page.
	 *
	 * @author  Olly Warren, Big Bite Creative
	 * @package Wp_Wakatime\Boot
	 * @version 1.0
	 */
    public static function renderOptionsPage()
    {
	    echo '<div class="wrap">';
	    echo '<h2>WP Wakatime Settings</h2>';
	    echo '<hr />';
	    echo '<form method="post" action="options.php">';
		settings_fields( 'wp-wakatime-settings' );
		do_settings_sections( 'wp-wakatime-settings' );
		echo '<table class="form-table">';
	    echo '<tr valign="top">';
	    echo '<th scope="row">Wakatime API Key</th>';
	    echo '<td><input type="text" name="wakatime_api_key" value="'.esc_attr(get_option('wakatime_api_key')).'" /></td>';
	    echo '</tr>';
		echo '</table>';
		submit_button('Save Configuration');
	    echo '</form>';
	    echo '</div>';
    }
}
