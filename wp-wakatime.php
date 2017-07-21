<?php
/**
 * WordPress Wakatime
 *
 * @package     OllyWarren\WP-Wakatime
 * @author      Olly Warren
 * @copyright   2017 Olly Warren
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: WP-Wakatime
 * Plugin URI:  https://github.com/ollywarren/wp-wakatime
 * Description: Integrates Wakatime Stats with WordPress using the Wakatime API.
 * Version:     1.1
 * Author:      Olly Warren
 * Author URI:  https://ollywarren.com
 * Text Domain: wp-wakatime
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

define( 'PLUGIN_VERSION', '1.1' );
define( 'AUTOLOAD_PATH', plugin_dir_path( __FILE__ ) );
define( 'WAKATIME_API_URL', 'https://wakatime.com/api/v1/' );

/**
 * Activates the plugin.
 *
 * @method wp_wakatime_activate_plugin
 * @author Olly Warren
 * @return void
 */
function wp_wakatime_activate_plugin() {
	Wp_Wakatime\Boot::activate();
}

/**
 * Deactivates the plugin
 *
 * @method wp_wakatime_deactivate_plugin
 * @return void
 */
function wp_wakatime_deactivate_plugin() {
	Wp_Wakatime\Boot::deactivate();
}

register_activation_hook( __FILE__, 'wp_wakatime_activate_plugin' );
register_deactivation_hook( __FILE__, 'wp_wakatime_deactivate_plugin' );

// Autoload Classes.
require_once AUTOLOAD_PATH . 'autoload.php';

// Boot the Plugin.
Wp_Wakatime\Boot::on_boot();
