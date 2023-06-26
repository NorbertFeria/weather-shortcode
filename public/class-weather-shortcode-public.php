<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://github.com/NorbertFeria
 * @since      1.0.0
 *
 * @package    Weather_Shortcode
 * @subpackage Weather_Shortcode/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Weather_Shortcode
 * @subpackage Weather_Shortcode/public
 * @author     Norbert Feria <norbert.feria@gmail.com>
 */
class Weather_Shortcode_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    		The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// Part 3 initiate the shortcode.
		add_shortcode('show_weather', array($this, 'show_weather_function'));

	}

	// Part 3
	/**
	 * shortcode function for show_weather. 
	 *
	 * @since    1.0.0
	 * @param      string    $atts       attribute parameters for the shorcode.
	 * @return     string    $output     the string output of the weather on the city.
	 * 
	 * sample usage [show_weather city="New York"] you may omit the city parameter which defaults to davao city philippines.
	 */
	function show_weather_function($atts) {
		// Extract attributes
		$attributes = shortcode_atts(
			array(
				'city' => 'Davao',
			),
			$atts
		);
	
		// Access individual attributes
		$city = $attributes['city'];

		$output = fetchFromOpenWeatherMap($city);
		return $output;
	}


}
