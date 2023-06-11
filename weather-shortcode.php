<?php

/**
 *
 * @link              https://https://github.com/NorbertFeria
 * @since             1.0.0
 * @package           Weather_Shortcode
 *
 * @wordpress-plugin
 * Plugin Name:       Weather shortcode
 * Plugin URI:        https://https://github.com/NorbertFeria
 * Description:       weather shortcode plugin will display the weather when a shortcode is used. the plugin reads API from openweathermap.org
 * Version:           1.0.0
 * Author:            Norbert Feria
 * Author URI:        https://https://github.com/NorbertFeria
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       weather-shortcode
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'WEATHER_SHORTCODE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-weather-shortcode-activator.php
 */
function activate_weather_shortcode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-weather-shortcode-activator.php';
	Weather_Shortcode_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-weather-shortcode-deactivator.php
 */
function deactivate_weather_shortcode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-weather-shortcode-deactivator.php';
	Weather_Shortcode_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_weather_shortcode' );
register_deactivation_hook( __FILE__, 'deactivate_weather_shortcode' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-weather-shortcode.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_weather_shortcode() {

	$plugin = new Weather_Shortcode();
	$plugin->run();

}
run_weather_shortcode();
