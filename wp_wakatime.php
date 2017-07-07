<?php

/**
 * @wordpress-plugin
 * Plugin Name:       WP Wakatime
 * Description:       Integrates Wakatime Stats with Wordpress using the Wakatime API.
 * Version:           1.0.0
 * Author:            Olly Warren
 * Author URI:        https://ollywarren.com
 * License: 		  MIT License, GNU General Public License v2.0
 */

/********************************
 * Global Constant Definitions  *
 ********************************/

define( 'PLUGIN_VERSION', '1.0.0' ); //<- REQUIRED
define( 'AUTOLOAD_PATH', plugin_dir_path( __FILE__ ) ); //<- REQUIRED
define( 'WAKATIME_API_URL', 'https://wakatime.com/api/v1/');

/***********************************
 * Activation / Deactivation Setup *
 ***********************************/
function wp_wakatime_activate_plugin() {
	Wp_Wakatime\Boot::activate();
}

function wp_wakatime_deactivate_plugin() {
	Wp_Wakatime\Boot::deactivate();
}

register_activation_hook( __FILE__, 'wp_wakatime_activate_plugin' );
register_deactivation_hook( __FILE__, 'wp_wakatime_deactivate_plugin' );

/** Autoload Classes **/
require_once AUTOLOAD_PATH . 'autoload.php';

/** Boot the Plugin **/
Wp_Wakatime\Boot::onBoot();
