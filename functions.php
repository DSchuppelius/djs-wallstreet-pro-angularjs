<?php
/*
 * Created on   : Fri Sep 16 2022
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : functions.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */

if (!defined('DJS_ANGULARJS_PLUGIN_DIR')) {
    define("DJS_ANGULARJS_PLUGIN", dirname(plugin_basename( __FILE__ )));
    define("DJS_ANGULARJS_PLUGIN_DIR", plugin_dir_path(__FILE__));
    define("DJS_ANGULARJS_PLUGIN_DIR_URI", plugin_dir_url(__FILE__));
    define("DJS_ANGULARJS_PLUGIN_ASSETS_PATH", trailingslashit(DJS_ANGULARJS_PLUGIN_DIR . "assets"));
    define("DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI", trailingslashit(DJS_ANGULARJS_PLUGIN_DIR_URI . "assets"));
    define("DJS_ANGULARJS_PLUGIN_FUNCTIONS_PATH", trailingslashit(DJS_ANGULARJS_PLUGIN_DIR . "functions"));
} elseif (DJS_ANGULARJS_PLUGIN_DIR != plugin_dir_path(__FILE__)) {
    add_action('admin_notices', function() { echo "<div class='error'><p>" . sprintf(esc_html__("%s detected a conflict; please deactivate the plugin located in %s.", DJS_ANGULARJS_PLUGIN), DJS_ANGULARJS_PLUGIN, DJS_ANGULARJS_PLUGIN_DIR) . "</p></div>"; });
    return;
}

// Load plugin textdomain.
function djs_wallstreet_pro_angularjs_load_textdomain() {
    $path = DJS_ANGULARJS_PLUGIN ."/functions/lang";
    $result = load_plugin_textdomain(DJS_ANGULARJS_PLUGIN, false, $path);

    if(defined('WP_DEBUG'))
        if (!$result && WP_DEBUG)
            add_action('admin_notices', function() use ($path) {
                $locale = apply_filters('plugin_locale', get_locale(), DJS_ANGULARJS_PLUGIN);
    
                echo "<div class='notice'><p>" . sprintf(esc_html__("Could not find language file %s/%s-%s.mo.", DJS_ANGULARJS_PLUGIN), $path, DJS_ANGULARJS_PLUGIN, $locale) . "</p></div>";
            });
}
add_action('init', 'djs_wallstreet_pro_angularjs_load_textdomain');

require_once(DJS_ANGULARJS_PLUGIN_DIR . "plugin_setup_data.php");

require_once(DJS_ANGULARJS_PLUGIN_FUNCTIONS_PATH . "customizer/customizer-global.php");
require_once(DJS_ANGULARJS_PLUGIN_FUNCTIONS_PATH . "scripts.php");
