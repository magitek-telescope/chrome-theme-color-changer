<?php
/**
 * Plugin Name: Chrome theme color changer
 * Version: 0.1-alpha
 * Description: This is the awesome plugin.
 * Author: Potato4d(Hanatani Takuma)
 * Author URI: http://potato4d.me/
 * Plugin URI: PLUGIN SITE HERE
 * Text Domain: chrome-theme-color-changer
 * Domain Path: /languages
 * @package Chrome-theme-color-changer
 */

class Chrome_Theme_Color_Changer{

	public static function get_instance() {
		static $instance;
		if ( ! $instance instanceof Chrome_Theme_Color_Changer ) {
			$instance = new static;
		}
		return $instance;
	}

	public function __construct(){
		$this->add_actions();
		$this->add_filters();
	}

	public function add_actions(){
	}

	public function add_filters(){
	}
}

add_action( 'plugins_loaded', array( 'Chrome_Theme_Color_Changer', 'get_instance' ) );
