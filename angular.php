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
Requires Plugins: djs-wallstreet-pro-core
*/
defined('ABSPATH') or die('Hm, Are you ok?');

require_once "functions.php";

if (!class_exists('DJS_Wallstreet_Pro_AngularJS') && class_exists('DJS_Base')) {
    final class DJS_Wallstreet_Pro_AngularJS extends DJS_Base {
        private $customizers;

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

                add_action('plugins_loaded', [$instance, 'load_plugin_textdomain']);
            }

            // Always return the instance
            return $instance;
        }

        protected function setup_globals() {
            parent::setup_globals();
            /** Versions **********************************************************/
            $this->version = '1.2.3';
            $this->db_version = 'none';
        }

        private function includes() {
            require($this->includes_dir . "shortcodes.php");
            require($this->includes_dir . "widget-areas.php");
        }

        private function setup_actions() {
            $this->customizers["angularjs"] = new Customizer_Wallstreet_Pro_AngularJS();
            $this->customizers["widget_areas"] = new Fixed_Widget_Areas();

            foreach($this->customizers as $customizer){
                $customizer->register();
            }
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