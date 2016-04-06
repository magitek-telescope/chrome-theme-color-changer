<?php
/**
 * Plugin Name: Chrome Theme Color Changer
 * Version: 1.0
 * Description: Address bar color changer for android chrome.
 * Author: Potato4d(Hanatani Takuma)
 * Author URI: http://potato4d.me/
 * Text Domain: chrome-theme-color-changer
 * Domain Path: /languages
 * @package Chrome-theme-color-changer
 */

class Chrome_Theme_Color_Changer{

	public static function get_instance() {
		static $instance;

		if (!$instance instanceof Chrome_Theme_Color_Changer) {
			$instance = new static;
		}
		return $instance;
	}

	public function __construct(){
		$this->add_actions();
		$this->add_filters();
	}

	private function add_actions(){
		add_action('admin_init', array($this, 'admin_init'));
		add_action('wp_head'   , array($this, 'set_theme_color'));
	}

	private function add_filters(){
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_action_links'));
		add_filter('admin_menu', array($this, 'add_page'));
	}

	public function admin_init(){
		if(!(isset($_POST['chrome-theme-color-changer']) && $_POST['chrome-theme-color-changer'])) return;
		if(check_admin_referer('chrome-theme-color-changer-key', 'chrome-theme-color-changer')){
			update_option('chrome-theme-color-changer-color', isset($_POST['color']) ? $_POST['color'] : '');
			wp_safe_redirect(menu_page_url('chrome-theme-color-changer', false));
			exit();
		}
	}

	public function add_action_links($links){
		$links[] = '<a href="' . menu_page_url('chrome-theme-color-changer', false) . '">' . __('Settings', 'chrome-theme-color-changer') . '</a>';
		return $links;
	}

	public function add_page(){
		add_options_page(
			__('Theme color', 'chrome-theme-color-changer'),
			__('Theme color', 'chrome-theme-color-changer'),
			'administrator',
			'chrome-theme-color-changer',
			array($this, 'chrome_theme_color_changer_menu')
		);
	}

	public function chrome_theme_color_changer_menu(){
		require_once __DIR__ . '/res/templates/form.php';

		wp_register_script('chrome-theme-color-changer-lib-jscolor', plugins_url('lib/jscolor.min.js', __FILE__), array()        , false, true);
		wp_register_script('chrome-theme-color-changer-admin-js'   , plugins_url('res/js/main.js', __FILE__), array('jquery'), false, true);

		wp_register_style('chrome-theme-color-changer-admin-css', plugins_url('res/css/style.css', __FILE__));

		wp_enqueue_script('chrome-theme-color-changer-lib-jscolor');
		wp_enqueue_script('chrome-theme-color-changer-admin-js');
		wp_enqueue_style('chrome-theme-color-changer-admin-css');
	}

	public function set_theme_color(){
		$color = get_option('chrome-theme-color-changer-color');
		if(in_array($color, array('',null), true)) return false;
		echo '<meta name="theme-color" content="' . '#' . esc_html($color) . '">' . "\n";
		return true;
	}

}

add_action('plugins_loaded', array('Chrome_Theme_Color_Changer', 'get_instance'));
