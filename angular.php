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
        load_plugin_textdomain('wallstreet-angularjs', false, DJS_ANGULARJS_PLUGIN_DIR . "lang");
        $this->customizer = new Customizer_Wallstreet_Pro_AngularJS();
        $this->customizer->load_angular_scripts();

        if (is_active_sidebar('home_right_fixed')) {
            add_action('wp_footer', [$this, 'load_home_right_fixed']);
        }
    }

    public function load_home_right_fixed()
    {
?>
<div ng-style="!check && {'right':'-175px'} || {'right':'-4px'}" ng-app="" class="btn_pos ng-scope"
    ng-init="check=<?php echo is_front_page() ? "true" : "false"; ?>">
    <button ng-show="check == false;" ng-click="check = !check" class="ng-hide not">
        <i class="material-icons"></i>
    </button>
    <button ng-show="check == true" ng-click="check = !check" class="not">
        <i class="material-icons"></i>
    </button>
    <?php
            dynamic_sidebar('home_right_fixed');
            ?>
</div>
<?php
    }
}