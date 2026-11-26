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
            add_action('wp_footer', [$this, 'inject_widget_script'], 99);
        }
    }

    /**
     * Auf/Zu-Schalter der Randleisten ohne AngularJS: frueher lud allein dafuer auf jeder Seite
     * das ganze Framework. Der Zustand steht als Klasse .is-open im Markup (Startseite: offen),
     * schmale Bildschirme (<= 1024px) starten per CSS geschlossen, bis jemand schaltet (.is-toggled).
     */
    public function inject_widget_script() { ?>
<script>
if (window.matchMedia("(max-width: 1024px)").matches) {
    document.querySelectorAll(".fixed-widget.is-open [data-fixed-widget-toggle]").forEach(function (button) {
        button.setAttribute("aria-expanded", "false");
    });
}
document.addEventListener("click", function (event) {
    var button = event.target.closest ? event.target.closest("[data-fixed-widget-toggle]") : null;
    if (!button) return;
    var panel = button.closest(".fixed-widget");
    if (!panel) return;
    var narrowStart = !panel.classList.contains("is-toggled") && window.matchMedia("(max-width: 1024px)").matches;
    var open = narrowStart ? true : !panel.classList.contains("is-open");
    panel.classList.add("is-toggled");
    panel.classList.toggle("is-open", open);
    button.setAttribute("aria-expanded", String(open));
});
</script>
<?php
    }

    public function load_home_widgets_fixed() { ?>
<div id="angularJSHomeWidgetID">
    <?php if ($this->right_enabled) {
                $this->home_right_fixed();
            }
            if ($this->left_enabled) {
                $this->home_left_fixed();
            } ?>
</div>
<?php }

    private function toggle_button() {
        $open = is_front_page(); ?>
    <button type="button" class="not" data-fixed-widget-toggle aria-expanded="<?php echo $open ? "true" : "false"; ?>" aria-label="<?php esc_attr_e("Toggle panel", DJS_ANGULARJS_PLUGIN); ?>">
        <i class="material-icons fixed-widget__closed" aria-hidden="true">&#xE408;</i>
        <i class="material-icons fixed-widget__opened" aria-hidden="true">&#xE409;</i>
    </button>
<?php }

    public function home_right_fixed() { ?>
<div class="wallstreet fixed-widget right<?php echo is_front_page() ? " is-open" : ""; ?>">
    <?php $this->toggle_button(); ?>
    <?php dynamic_sidebar('home_right_fixed'); ?>
</div>
<?php }

    public function home_left_fixed() { ?>
<div class="wallstreet fixed-widget left<?php echo is_front_page() ? " is-open" : ""; ?>">
    <?php dynamic_sidebar('home_left_fixed'); ?>
    <?php $this->toggle_button(); ?>
</div>
<?php }
}
