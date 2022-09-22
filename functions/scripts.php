<?php
/*
 * Created on   : Fri Sep 16 2022
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : scripts.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */
function angularjs_plugin_styles() {
    wp_enqueue_style("angularjs-widget-area-style", DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/css/widget-area.css");
}
add_action('wp_enqueue_scripts', 'angularjs_plugin_styles');

function angularjs_plugin_scripts() {
    $current_options = get_current_angularjs_options();

    if (!(defined("WP_ADMIN") && WP_ADMIN) && $current_options["angularjs_enabled"]) {
        wp_enqueue_script("angularjs",                      DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular.min.js");
        if ($current_options["angularjslocal_enabled"] && file_exists(DJS_ANGULARJS_PLUGIN_ASSETS_PATH . "/js/angularjs/" . $current_options["angularjs_version"] . "/i18n/angular-locale_" . str_replace("_", "-", $current_options["angularjslocal"]) . ".js")) {
            wp_enqueue_script("angularjs-locale",            DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/i18n/angular-locale_" . str_replace("_", "-", $current_options["angularjslocal"]) . ".js");
        }
        if ($current_options["angular_animate_enabled"]) {
            wp_enqueue_script("angularjs-animate",          DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-animate.min.js");
        }
        if ($current_options["angular_aria_enabled"]) {
            wp_enqueue_script("angularjs-aria",             DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-aria.min.js");
        }
        if ($current_options["angular_cookies_enabled"]) {
            wp_enqueue_script("angularjs-cookies",          DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-cookies.min.js");
        }
        if ($current_options["angular_loader_enabled"]) {
            wp_enqueue_script("angularjs-loader",           DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-loader.min.js");
        }
        if ($current_options["angular_messages_enabled"]) {
            wp_enqueue_script("angularjs-messages",         DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-messages.min.js");
        }
        if ($current_options["angular_message_format_enabled"]) {
            wp_enqueue_script("angularjs-message-format",   DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-message-format.min.js");
        }
        if ($current_options["angular_mocks_enabled"]) {
            wp_enqueue_script("angularjs-mocks",            DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-mocks.js");
        }
        if ($current_options["angular_parse_ext_enabled"]) {
            wp_enqueue_script("angularjs-parse-ext",        DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-parse-ext.min.js");
        }
        if ($current_options["angular_resource_enabled"]) {
            wp_enqueue_script("angularjs-resource",         DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-resource.min.js");
        }
        if ($current_options["angular_route_enabled"]) {
            wp_enqueue_script("angularjs-route",            DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-route.min.js");
        }
        if ($current_options["angular_sanitize_enabled"]) {
            wp_enqueue_script("angularjs-sanitize",         DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-sanitize.min.js");
        }
        if ($current_options["angular_scenario_enabled"]) {
            wp_enqueue_script("angularjs-scenario",         DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/1.2.32/angular-scenario.js");
        }
        if ($current_options["angular_touch_enabled"]) {
            wp_enqueue_script("angularjs-touch",            DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/" . $current_options["angularjs_version"] . "/angular-touch.min.js");
        }
        if ($current_options["angular_uibootstrap_enabled"]) {
            wp_enqueue_script("angularjs-uibootstrap",      DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "/js/angularjs/ui-bootstrap-tpls-2.5.0.min.js");
        }
    }
}
add_action('wp_enqueue_scripts', 'angularjs_plugin_scripts');

