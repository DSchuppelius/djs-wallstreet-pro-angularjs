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
    $current_setup = AangularJS_Plugin_Setup::instance();

    if($current_setup->get("symbolfonts_enabled")) {
        wp_enqueue_style("font-awesome",                    DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "css/fonts/font-awesome/css/all.min.css");
        wp_enqueue_style("icon_font-faces",                 DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "css/fonts/icon_font-faces.css");
    }

    if($current_setup->get("customcolor_enabled") != "#cccccc" || $current_setup->get("customtextcolor_enabled") != "#ffffff") {
        add_action('wp_head', 'widget_colorsettings');
    }

    wp_enqueue_style("angularjs-widget-area",               DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "css/widget-area.css");
    wp_enqueue_style("angularjs-font",                      DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "css/fonts/font.css");
}
add_action('wp_enqueue_scripts', 'angularjs_plugin_styles');

function angularjs_plugin_scripts() {
    $setup = AangularJS_Plugin_Setup::instance();

    if (!(defined("WP_ADMIN") && WP_ADMIN) && $setup->get("angularjs_enabled")) {
        $version  = $setup->get("angularjs_version");
        $base_uri = DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI . "js/angularjs/" . $version . "/";
        $base_path = DJS_ANGULARJS_PLUGIN_ASSETS_PATH . "js/angularjs/" . $version . "/";

        $scripts = [
            "angularjs"                 => ["file" => "angular.min.js"],
            "angularjs-locale"         => ["file" => "i18n/angular-locale_" . str_replace("_", "-", $setup->get("angularjslocal")) . ".js", "condition" => $setup->get("angularjslocal_enabled")],
            "angularjs-animate"        => ["file" => "angular-animate.min.js",        "condition" => $setup->get("angular_animate_enabled")],
            "angularjs-aria"           => ["file" => "angular-aria.min.js",           "condition" => $setup->get("angular_aria_enabled")],
            "angularjs-cookies"        => ["file" => "angular-cookies.min.js",        "condition" => $setup->get("angular_cookies_enabled")],
            "angularjs-loader"         => ["file" => "angular-loader.min.js",         "condition" => $setup->get("angular_loader_enabled")],
            "angularjs-messages"       => ["file" => "angular-messages.min.js",       "condition" => $setup->get("angular_messages_enabled")],
            "angularjs-message-format" => ["file" => "angular-message-format.min.js", "condition" => $setup->get("angular_message_format_enabled")],
            "angularjs-mocks"          => ["file" => "angular-mocks.js",              "condition" => $setup->get("angular_mocks_enabled")],
            "angularjs-parse-ext"      => ["file" => "angular-parse-ext.min.js",      "condition" => $setup->get("angular_parse_ext_enabled")],
            "angularjs-resource"       => ["file" => "angular-resource.min.js",       "condition" => $setup->get("angular_resource_enabled")],
            "angularjs-route"          => ["file" => "angular-route.min.js",          "condition" => $setup->get("angular_route_enabled")],
            "angularjs-sanitize"       => ["file" => "angular-sanitize.min.js",       "condition" => $setup->get("angular_sanitize_enabled")],
            "angularjs-scenario"       => ["file" => "../1.2.32/angular-scenario.js", "condition" => $setup->get("angular_scenario_enabled")],
            "angularjs-touch"          => ["file" => "angular-touch.min.js",          "condition" => $setup->get("angular_touch_enabled")],
            "angularjs-uibootstrap"    => ["file" => "ui-bootstrap-tpls-2.5.0.min.js","condition" => $setup->get("angular_uibootstrap_enabled")],
        ];

        foreach ($scripts as $handle => $daten) {
            $condition = $daten['condition'] ?? true;
            $file     = $daten['file'];

            if ($condition) {
                if ($handle === 'angularjs-locale' && !file_exists($base_path . $file)) {
                    continue;
                }

                wp_enqueue_script($handle, $base_uri . $file, [], null, ['strategy' => 'defer', 'in_footer' => true]);
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'angularjs_plugin_scripts');

function widget_colorsettings() {
    $current_setup = AangularJS_Plugin_Setup::instance(); ?>
<style>
<?php if ($current_setup->get("customcolor_enabled") !="#cccccc") {
    ?>.wallstreet.fixed-widget {
        background-color: <?php echo $current_setup->get("customcolor_enabled");
        ?>;
    }

    <?php
}

if ($current_setup->get("customtextcolor_enabled") !="#ffffff") {

    ?>.wallstreet.fixed-widget,
    .wallstreet.fixed-widget button,
    .wallstreet.fixed-widget button:hover,
    .wallstreet.fixed-widget>div a,
    .wallstreet.fixed-widget>div a:hover {
        color: <?php echo $current_setup->get("customtextcolor_enabled");
        ?>;
    }

    <?php
}

?>
</style>
<?php } ?>
