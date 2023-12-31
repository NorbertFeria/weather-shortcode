<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://https://github.com/NorbertFeria
 * @since      1.0.0
 *
 * @package    Weather_Shortcode
 * @subpackage Weather_Shortcode/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Weather_Shortcode
 * @subpackage Weather_Shortcode/includes
 * @author     Norbert Feria <norbert.feria@gmail.com>
 */
class Weather_Shortcode {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Weather_Shortcode_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The label of this plugin. PART 1.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_label    The string used to uniquely identify this plugin.
	 */
	protected $plugin_label;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WEATHER_SHORTCODE_VERSION' ) ) {
			$this->version = WEATHER_SHORTCODE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'weather_shortcode';
		$this->plugin_label = 'Weather Shortcode';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_settings_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Weather_Shortcode_Loader. Orchestrates the hooks of the plugin.
	 * - Weather_Shortcode_i18n. Defines internationalization functionality.
	 * - Weather_Shortcode_Admin. Defines all hooks for the admin area.
	 * - Weather_Shortcode_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-weather-shortcode-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-weather-shortcode-i18n.php';

		/**
		 * The class responsible for the setting page of the plugin in the admin area. PART 1.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-admin-settings.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-weather-shortcode-public.php';

		/**
		 * This file contains custom functions used to connect third party through API PART 2
		 * 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/custom-functions.php';

		$this->loader = new Weather_Shortcode_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Weather_Shortcode_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Weather_Shortcode_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}


	/**
	 * Register all of the hooks related to the admin settings
	 * of the plugin. PART 1.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_settings_hooks() {

		$plugin_settings = new Plugin_Admin_Settings( $this->get_plugin_name(), $this->get_plugin_label(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_settings, 'enqueue_settings_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_settings, 'enqueue_settings_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_settings, 'add_menu_options' );
		$this->loader->add_action('admin_init', $plugin_settings, 'register_settings' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Weather_Shortcode_Public( $this->get_plugin_name(), $this->get_version() );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The label of the plugin. PART 1.
	 *
	 * @since     1.0.0
	 * @return    string    The label of the plugin.
	 */
	public function get_plugin_label() {
		return $this->plugin_label;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Weather_Shortcode_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
