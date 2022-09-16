<?php
/*
Plugin Name: DJS-Wallstreet-Pro AngularJS
Description: Adds AngularJS-Options to Theme-Customizer
Version: 1.0
Author: Daniel Joerg Schuppelius
Author URI: https://schuppelius.org
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: wallstreet-angularjs
Domain Path: /lang
*/
defined('ABSPATH') or die('Hm, Are you ok?');

define("ANGUALR_DIR_URI", plugin_dir_url(__FILE__));
define("ANGULAR_DIR", plugin_dir_path(__FILE__));
define("ANGULAR_ASSETS_PATH", ANGULAR_DIR . "assets");
define("ANGULAR_ASSETS_PATH_URI", ANGUALR_DIR_URI . "assets");

$start_wallstreet_pro_angularjs = new Wallstreet_Pro_AngularJS();

class Wallstreet_Pro_AngularJS
{
    public function __construct()
    {
        load_theme_textdomain("wallstreet", ANGULAR_DIR . "lang");

        $wallstreet_theme = wp_get_theme("DJS-Wallstreet-Pro");
        $current_theme = wp_get_theme();

        if ($wallstreet_theme->Name == $current_theme->Name)
            add_action("customize_register", [$this, "register_angularsection"]);
        else
            add_action("customize_register", [$this, "register_angularpanel"]);

        add_action("customize_register", [$this, "register_angularcontrols"]);

        $this->load_angular_scripts();
    }

    public function register_angularsection($wp_customize)
    {
        $wp_customize->add_section("angular_section_settings", [
            "title" => __("AngularJS options", "wallstreet"),
            "panel" => "global_theme_settings",
            "description" => "",
        ]);
    }
    public function register_angularpanel($wp_customize)
    {
        $wp_customize->add_panel("angular_section_settings", [
            "title" => __("AngularJS options", "wallstreet"),
            "description" => "",
        ]);
    }

    public function register_angularcontrols($wp_customize)
    {
        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angularjs_enabled]", [
            "default" => true,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angularjs_enabled]", [
            "label" => __("Enable AngularJS", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
            "description" => __("If enabled the following and enabled features are also taken into account", "wallstreet"),
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angularjs_version]", [
            "default" => '1.8.2',
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angularjs_version]", [
            "label" => __("Select version of AngularJS", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "select",
            'choices' => [
                '1.2.32' => __('Version 1.2.32'),
                '1.8.2' => __('Version 1.8.2'),
            ],
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angularjslocal_enabled]", [
            "default" => true,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angularjslocal_enabled]", [
            "label" => __("Enable AngularJS Locale", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angularjslocal]", [
            "default" => strtolower(get_locale()),
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);
        $wp_customize->add_control("wallstreet_pro_angularjs_options[angularjslocal]", [
            "label" => __("Language", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "text",
            "priority" => 100,
        ]);


        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_animate_enabled]", [
            "default" => true,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_animate_enabled]", [
            "label" => __("Enable AngularJS Animate", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_aria_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_aria_enabled]", [
            "label" => __("Enable AngularJS Aria", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_cookies_enabled]", [
            "default" => true,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_cookies_enabled]", [
            "label" => __("Enable AngularJS Cookies", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_loader_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_loader_enabled]", [
            "label" => __("Enable AngularJS Loader", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_messages_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_messages_enabled]", [
            "label" => __("Enable AngularJS Message", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_message_format_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_message_format_enabled]", [
            "label" => __("Enable AngularJS Messageformat", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_mocks_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_mocks_enabled]", [
            "label" => __("Enable AngularJS Mocks", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);


        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_parse_ext_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_parse_ext_enabled]", [
            "label" => __("Enable AngularJS Parse Extension", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_resource_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_resource_enabled]", [
            "label" => __("Enable AngularJS Resource", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_route_enabled]", [
            "default" => true,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_route_enabled]", [
            "label" => __("Enable AngularJS Route", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_sanitize_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_sanitize_enabled]", [
            "label" => __("Enable AngularJS Sanitize", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_scenario_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_scenario_enabled]", [
            "label" => __("Enable AngularJS Scenario", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
            "description" => __("Only in Version 1.2.32", "wallstreet"),
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_touch_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_touch_enabled]", [
            "label" => __("Enable AngularJS Touch", "wallstreet"),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);
    }

    private function plugin_data_setup()
    {
        return [
            "angularjs_enabled" => true,
            "angularjs_version" => "1.8.2",
            "angularjslocal_enabled" => true,
            "angularjslocal" => strtolower(get_locale()),
            "angular_animate_enabled" => true,
            "angular_aria_enabled" => false,
            "angular_cookies_enabled" => true,
            "angular_loader_enabled" => false,
            "angular_messages_enabled" => false,
            "angular_message_format_enabled" => false,
            "angular_mocks_enabled" => false,
            "angular_parse_ext_enabled" => false,
            "angular_resource_enabled" => false,
            "angular_route_enabled" => true,
            "angular_sanitize_enabled" => false,
            "angular_scenario_enabled" => false,
            "angular_touch_enabled" => false,
        ];
    }

    public function get_current_options()
    {
        $djs_wallstreet_pro_angularjs_options = $this->plugin_data_setup();
        return wp_parse_args(get_option("wallstreet_pro_angularjs_options", []), $djs_wallstreet_pro_angularjs_options);
    }

    public function load_angular_scripts()
    {
        $current_options = $this->get_current_options();

        if ($current_options["angularjs_enabled"]) {
            wp_enqueue_script("angularjs",                      ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular.min.js");
            if ($current_options["angularjslocal_enabled"]) {
                wp_enqueue_script("angularjs-local",            ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/i18n/angular-locale_" . str_replace("_", "-", $current_options["angularjslocal"]) . ".js");
            }
            if ($current_options["angular_animate_enabled"]) {
                wp_enqueue_script("angularjs-animate",          ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-animate.min.js");
            }
            if ($current_options["angular_aria_enabled"]) {
                wp_enqueue_script("angularjs-aria",             ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-aria.min.js");
            }
            if ($current_options["angular_cookies_enabled"]) {
                wp_enqueue_script("angularjs-cookies",          ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-cookies.min.js");
            }
            if ($current_options["angular_loader_enabled"]) {
                wp_enqueue_script("angularjs-loader",           ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-loader.min.js");
            }
            if ($current_options["angular_messages_enabled"]) {
                wp_enqueue_script("angularjs-messages",         ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-messages.min.js");
            }
            if ($current_options["angular_message_format_enabled"]) {
                wp_enqueue_script("angularjs-message-format",   ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-message-format.min.js");
            }
            if ($current_options["angular_mocks_enabled"]) {
                wp_enqueue_script("angularjs-mocks",            ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-mocks.js");
            }
            if ($current_options["angular_parse_ext_enabled"]) {
                wp_enqueue_script("angularjs-parse-ext",        ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-parse-ext.min.js");
            }
            if ($current_options["angular_resource_enabled"]) {
                wp_enqueue_script("angularjs-resource",         ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-resource.min.js");
            }
            if ($current_options["angular_route_enabled"]) {
                wp_enqueue_script("angularjs-route",            ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-route.min.js");
            }
            if ($current_options["angular_sanitize_enabled"]) {
                wp_enqueue_script("angularjs-sanitize",         ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-sanitize.min.js");
            }
            if ($current_options["angular_scenario_enabled"]) {
                wp_enqueue_script("angularjs-scenario",         ANGULAR_ASSETS_PATH_URI . "/js/angularjs/1.2.32/angular-scenario.js");
            }
            if ($current_options["angular_touch_enabled"]) {
                wp_enqueue_script("angularjs-touch",            ANGULAR_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-touch.min.js");
            }
        }
    }
}