<?php
/*
 * Created on   : Fri Sep 16 2022
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : functions.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */

define("DJS_ANGULARJS_PLUGIN_DIR_URI", plugin_dir_url(__FILE__));
define("DJS_ANGULARJS_PLUGIN_DIR", plugin_dir_path(__FILE__));
define("DJS_ANGULARJS_PLUGIN_ASSETS_PATH", DJS_ANGULARJS_PLUGIN_DIR . "assets");
define("DJS_ANGULARJS_PLUGIN_ASSETS_PATH_URI", DJS_ANGULARJS_PLUGIN_DIR_URI . "assets");
define("DJS_ANGULARJS_PLUGIN_FUNCTIONS_PATH", DJS_ANGULARJS_PLUGIN_DIR . "functions");

require_once DJS_ANGULARJS_PLUGIN_DIR . "plugin_setup_data.php";

require_once DJS_ANGULARJS_PLUGIN_FUNCTIONS_PATH . "/customizer/customizer-global.php";

require_once DJS_ANGULARJS_PLUGIN_FUNCTIONS_PATH . "/scripts.php";
require_once DJS_ANGULARJS_PLUGIN_FUNCTIONS_PATH . "/shortcodes.php";
require_once DJS_ANGULARJS_PLUGIN_FUNCTIONS_PATH . "/widget-areas.php";