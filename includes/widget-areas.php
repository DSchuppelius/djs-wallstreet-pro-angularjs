<?php
/*
 * Created on   : Fri Sep 16 2022
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : widget-areas.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */

function wallstreet_angularjs_widgets_init() {
    foreach ( [ 'right', 'left' ] as $pos ) {
        register_sidebar([
            'name'          => esc_html__( "Home {$pos} fixed-sidebar", 'wallstreet-angularjs' ),
            'id'            => "home_{$pos}_fixed",
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);
    }
}
add_action('widgets_init', 'wallstreet_angularjs_widgets_init');

class Fixed_Widget_Areas {
    private bool $left_enabled;
    private bool $right_enabled;

    public function __construct() {
        $this->right_enabled = is_active_sidebar('home_right_fixed');
        $this->left_enabled = is_active_sidebar('home_left_fixed');
    }

    public function register() {
        if($this->right_enabled || $this->left_enabled) {
            add_action('wp_footer', [$this, 'load_home_widgets_fixed']);
            add_action('wp_footer', [$this, 'inject_angular_widget_script'], 99);
        }
    }

    public function inject_angular_widget_script() { ?>
<script>
(function waitForAngular(retries) {
    if (typeof angular === 'undefined') {
        if (retries <= 0) {
            console.error("AngularJS konnte nicht geladen werden.");
            return;
        }
        return setTimeout(() => waitForAngular(retries - 1), 50);
    }

    function getWidth() {
        return Math.max(
            document.body.scrollWidth,
            document.documentElement.scrollWidth,
            document.body.offsetWidth,
            document.documentElement.offsetWidth,
            document.documentElement.clientWidth
        );
    }

    const widgetModule = angular.module('angularJSHomeWidget', []);
    widgetModule.controller('widgetController', function($scope) {
        $scope.rcheck = <?php echo is_front_page() ? "true" : "false"; ?>;
        $scope.lcheck = <?php echo is_front_page() ? "true" : "false"; ?>;

        if (getWidth() <= 1024) {
            $scope.rcheck = false;
            $scope.lcheck = false;
        }
    });

    angular.element(function() {
        angular.bootstrap(document.getElementById("angularJSHomeWidgetID"), ['angularJSHomeWidget']);
    });
})(20);
</script>
<?php
    }

    public function load_home_widgets_fixed() {
        $show_widget = is_front_page() ? "true" : "false"; ?>
<div id="angularJSHomeWidgetID" ng-controller="widgetController">
    <?php if ($this->right_enabled) {
                $this->home_right_fixed();
            }
            if ($this->left_enabled) {
                $this->home_left_fixed();
            } ?>
</div>
<?php }

    public function home_right_fixed() { ?>
<div ng-style="!rcheck && {'right':'-175px'} || {'right':'-4px'}" class="wallstreet fixed-widget right">
    <button ng-show="rcheck == false;" ng-click="rcheck = !rcheck" class="not">
        <i class="material-icons"></i>
    </button>
    <button ng-show="rcheck == true" ng-click="rcheck = !rcheck" class="not">
        <i class="material-icons"></i>
    </button>
    <?php dynamic_sidebar('home_right_fixed'); ?>
</div>
<?php }

    public function home_left_fixed() { ?>
<div ng-style="!lcheck && {'left':'-175px'} || {'left':'-4px'}" class="wallstreet fixed-widget left">
    <?php dynamic_sidebar('home_left_fixed'); ?>
    <button ng-show="lcheck == true;" ng-click="lcheck = !lcheck" class="not">
        <i class="material-icons"></i>
    </button>
    <button ng-show="lcheck == false" ng-click="lcheck = !lcheck" class="not">
        <i class="material-icons"></i>
    </button>
</div>
<?php }
}
