<?php
/*
Plugin Name: DJS-Wallstreet-Pro AngularJS
Plugin URI: https://github.com/DSchuppelius/djs-wallstreet-pro-angularjs
Update URI: https://github.com/DSchuppelius/djs-wallstreet-pro-angularjs/releases/latest/
Description: Adds AngularJS-Options to WordPress
Version: 1.2.3
Author: Daniel Joerg Schuppelius
Author URI: https://schuppelius.org
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: djs-wallstreet-pro-angularjs
Domain Path: /functions/lang/
*/
defined('ABSPATH') or die('Hm, Are you ok?');

require_once "functions.php";


if (!class_exists('DJS_Wallstreet_Pro_AngularJS')) {
    final class DJS_Wallstreet_Pro_AngularJS {
        private $data;

        // @var mixed False when not logged in; WP_User object when logged in
        public $current_user = false;

        // @var obj Add-ons append to this (Akismet, BuddyPress, etc...)
        public $extend;

        // @var array Topic views
        public $views = [];

        // @var array Overloads get_option()
        public $options = [];

        // @var array Overloads get_user_meta()
        public $user_options = [];

        // @return plugin|null
        public static function instance() {
            // Store the instance locally to avoid private static replication
            static $instance = null;

            // Only run these methods if they haven't been ran previously
            if (null === $instance) {
                $instance = new DJS_Wallstreet_Pro_AngularJS();
                $instance->setup_globals();
                $instance->includes();
                $instance->setup_actions();
            }

            // Always return the instance
            return $instance;
        }

        /**
         * A dummy constructor to prevent plugin from being loaded more than once.
         *
         * @since DJS_Wallstreet_Pro_AngularJS (v1.2.3)
         * @see DJS_Wallstreet_Pro_AngularJS::instance()
         * @see plugin();
         */
        private function __construct() {
            /* Do nothing here */
        }

        // A dummy magic method to prevent plugin from being cloned
        public function __clone() {
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'DJS_Wallstreet_Pro_AngularJS'), '1.2.3');
        }

        // A dummy magic method to prevent plugin from being unserialized
        public function __wakeup() {
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'DJS_Wallstreet_Pro_AngularJS'), '1.2.3');
        }

        // Magic method for checking the existence of a certain custom field
        public function __isset($key) {
            return isset($this->data[$key]);
        }

        // Magic method for getting plugin variables
        public function __get($key) {
            return isset($this->data[$key]) ? $this->data[$key] : null;
        }

        // Magic method for setting plugin variables
        public function __set($key, $value) {
            $this->data[$key] = $value;
        }

        // Magic method for unsetting plugin variables
        public function __unset($key) {
            if (isset($this->data[$key])) unset($this->data[$key]);
        }

        // Magic method to prevent notices and errors from invalid method calls
        public function __call($name = '', $args = []) {
            unset($name, $args);
            return null;
        }

        private function setup_globals() {
            /** Versions **********************************************************/
            $this->version = '1.2.3';
            $this->db_version = 'none';

            // Setup some base path and URL information
            $this->file = __FILE__;
            $this->basename = apply_filters('djs-wallstreet-pro-angularjs_plugin_basenname', plugin_basename($this->file));
            $this->plugin_dir = apply_filters('djs-wallstreet-pro-angularjs_plugin_dir_path', plugin_dir_path($this->file));
            $this->plugin_url = apply_filters('djs-wallstreet-pro-angularjs_plugin_dir_url', plugin_dir_url($this->file));

            /** Paths *************************************************************/
            $this->includes_dir = apply_filters('djs-wallstreet-pro-angularjs_includes_dir', trailingslashit($this->plugin_dir . 'includes'));
            $this->includes_url = apply_filters('djs-wallstreet-pro-angularjs_includes_url', trailingslashit($this->plugin_url . 'includes'));
        }

        private function includes() {
            require($this->includes_dir . "shortcodes.php");
            require($this->includes_dir . "widget-areas.php");
        }

        private function setup_actions() {
            $this->customizer = new Customizer_Wallstreet_Pro_AngularJS();
            $this->widget_areas = new Fixed_Widget_Areas();

            $this->customizer->register();
            $this->widget_areas->register();
        }
    }

    function djs_wallstreet_pro_angularjs() {
        return DJS_Wallstreet_Pro_AngularJS::instance();
    }

    if (defined('DJS_Wallstreet_Pro_AngularJS_LATE_LOAD')) {
        add_action('plugins_loaded', 'djs_wallstreet_pro_angularjs', (int)DJS_Wallstreet_Pro_AngularJS_LATE_LOAD);
    } else {
        djs_wallstreet_pro_angularjs();
    }
}
