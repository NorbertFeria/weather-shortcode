<?php

/**
 * The admin-settings-specific functionality of the plugin. PART 1.
 *
 * @link       https://https://github.com/NorbertFeria
 * @since      1.0.0
 *
 * @package    Weather_Shortcode
 * @subpackage Weather_Shortcode/admin
 */

/**
 * The admin-settings-specific functionality of the plugin.
 * @author     Norbert Feria <norbert.feria@gmail.com>
 */

class Plugin_Admin_Settings {

    /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

    /**
	 * The label of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_label    
	 */
	protected $plugin_label;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


    public function __construct( $plugin_name, $plugin_label, $version ) {

		$this->plugin_name = $plugin_name;
        $this->plugin_label = $plugin_label;
		$this->version = $version;

	}

    /**
	 * Register the stylesheets for the admin settings area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_settings_styles() {

		wp_enqueue_style( $this->plugin_name."-settings-css", plugin_dir_url( __FILE__ ) . 'css/admin-settings.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin settings area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_settings_scripts() {

		wp_enqueue_script( $this->plugin_name."-settings-js", plugin_dir_url( __FILE__ ) . 'js/admin-settings.js', array( 'jquery' ), $this->version, false );

	}

    public function register_settings(){
        register_setting( $this->plugin_name.'_options_group', 'cache_results' );
        register_setting( $this->plugin_name.'_options_group', 'api_key' );
    }

    public function add_menu_options(){
        add_options_page(
            $this->plugin_label.' Options Page', // page <title>Title</title>
            $this->plugin_label, // menu link text
            'manage_options', // capability to access the page
            $this->plugin_name.'-settings', // page URL slug
            array($this, 'render_options_page'), // callback function /w content
            'dashicons-star-half', // menu icon
            2 // priority
        );

    }

    public function render_options_page(){

        $cache_results = get_option('cache_results');

        switch ($cache_results) {
			case 1:
				$yes_cache_selected = 'selected';
				$no_cache_selected = '';
			  	break;
			case 0:
				$yes_cache_selected = '';
				$no_cache_selected = 'selected';
			  	break;
		}
        ?>
        <div class="settings_page_body">
            <h1><?php echo $this->plugin_label; ?> Settings Page</h1>
            <div class="settings_button_bar">
                <div class="settings_tabs">
                    <button class="tab-links"
                        onclick="opentab( event, 'general-settings' )"
                        id="general-settings-tab">
                        GENERAL SETTINGS
                    </button>
                    <button class="tab-links"
                            onclick="opentab( event, 'api-settings' )"
                            id="api-settings-tab">
                        API CREDENTIALS
                    </button>
                </div>
            </div>

            <form method="post" name="settings-form" id="settings-form" action="options.php">
            <?php settings_fields( $this->plugin_name.'_options_group' ); ?>
            <div id="general-settings" class="settings_body">
                <table>
                    <tr><td colspan="2"> <span class="subheader"><?php esc_html_e( 'General settings for '.$this->plugin_label, $this->plugin_name ); ?></span></td><tr>
                    <tr valign="top">
                        <th scope="row"><label for="cache_results">Cache results</label></th>
                        <td>
                            <select name="cache_results" id="cache_results">
                                <option value=1 <?php echo $yes_cache_selected; ?>>Yes</option>
                                <option value=0 <?php echo $no_cache_selected; ?>>No</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>    
            <div id="api-settings" class="settings_body">
                <table>
                    <tr><td colspan="2"> <span class="subheader"><?php esc_html_e( 'API settings for '.$this->plugin_label, $this->plugin_name ); ?></span></td><tr>
                    <tr valign="top">
                        <th scope="row"><label for="api_key">API KEY</label></th>
                        <td><input type="text" id="api_key" name="api_key" size="100" value="<?php echo get_option('api_key'); ?>" /></td>
                    </tr>
                </table>
            </div>
            <?php
            submit_button(
                null,
                'primary',
                'submit-footer',
                true,
                array(
                    'form' => 'settings-form',
                )
            );
            ?>
            </form>
        </div>
        <?php
    }

}