<?php
/*
Plugin Name: DJS-Wallstreet-Pro AngularJS
Plugin URI: https://github.com/DSchuppelius/djs-wallstreet-angularjs
Update URI: https://github.com/DSchuppelius/djs-wallstreet-angularjs/releases/latest/
Description: Adds AngularJS-Options to Theme-Customizer
Version: 1.1.0
Author: Daniel Joerg Schuppelius
Author URI: https://schuppelius.org
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: wallstreet-angularjs
Domain Path: /lang
*/
defined('ABSPATH') or die('Hm, Are you ok?');

require_once "functions.php";

$start_wallstreet_pro_angularjs = new Wallstreet_Pro_AngularJS();

class Wallstreet_Pro_AngularJS
{
    public $customizer;

    public function __construct()
    {
        load_plugin_textdomain("wallstreet-angularjs", DJS_ANGULARJS_PLUGIN_DIR . "lang");
        $this->customizer = new Customizer_Wallstreet_Pro_AngularJS();
        $this->customizer->load_angular_scripts();
    }
}