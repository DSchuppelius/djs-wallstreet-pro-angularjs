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
    final class DJS_Wallstreet_Pro_AngularJS extends Plugin_Base {
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

                add_action('init', [$instance, 'load_textdomain']);
            }

            // Always return the instance
            return $instance;
        }

        // Load plugin textdomain.
        public function load_textdomain() {
            $path = $this->plugin_name ."/functions/lang";
            $result = load_plugin_textdomain($this->plugin_name, false, $path);

            if(defined('WP_DEBUG'))
                if (!$result && WP_DEBUG)
                    add_action('admin_notices', function() use ($path) {
                        $locale = apply_filters('plugin_locale', get_locale(), $this->plugin_name);
                    
                        echo "<div class='notice'><p>" . sprintf(esc_html__("Could not find language file %s/%s-%s.mo.", $this->plugin_name), $path, $this->plugin_name, $locale) . "</p></div>";
                    });
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
            $this->plugin_name = apply_filters('djs-wallstreet-pro-post-types_plugin_name', dirname($this->basename));

            /** Paths *************************************************************/
            $this->includes_dir = apply_filters('djs-wallstreet-pro-angularjs_includes_dir', trailingslashit($this->plugin_dir . 'includes'));
            $this->includes_url = apply_filters('djs-wallstreet-pro-angularjs_includes_url', trailingslashit($this->plugin_url . 'includes'));
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
