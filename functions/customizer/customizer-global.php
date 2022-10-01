<?php
/*
 * Created on   : Wed Jun 22 2022
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : customizer-global.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */
class Customizer_Wallstreet_Pro_AngularJS
{
    public $is_djs_wallstreet_pro_theme;

    public function __construct() {
        $wallstreet_theme = wp_get_theme("DJS-Wallstreet-Pro");
        $current_theme = wp_get_theme();

        $this->is_djs_wallstreet_pro_theme = $wallstreet_theme->Name == $current_theme->Name;
    }

    public function register() {
        if (!$this->is_djs_wallstreet_pro_theme) {            
            add_action("customize_register", [$this, "register_angularpanel"]);
            add_action("customize_register", [$this, "register_colorpickercontrols"]);
            add_action("customize_register", [$this, "register_symolicfontcontrols"]);
        }
        add_action("customize_register", [$this, "register_angularsection"]);
        add_action("customize_register", [$this, "register_angularcontrols"]);
    }

    public function register_angularpanel($wp_customize) {
        $wp_customize->add_panel("angular_panel_settings", [
            "title" => esc_html__("AngularJS options", DJS_ANGULARJS_PLUGIN),
            "description" => "",
        ]);
    }

    public function register_angularsection($wp_customize) {
        if ($this->is_djs_wallstreet_pro_theme) {
            $wp_customize->add_section("angular_section_settings", [
                "title" => esc_html__("AngularJS options", DJS_ANGULARJS_PLUGIN),
                "panel" => "global_theme_settings",
                "description" => "",
            ]);
        } else {
            $wp_customize->add_section("angular_section_settings", [
                "title" => esc_html__("AngularJS options", DJS_ANGULARJS_PLUGIN),
                "panel" => "angular_panel_settings",
                "description" => "",
            ]);

            $wp_customize->add_section("angularfont_section_settings", [
                "title" => esc_html__("Font settings", DJS_ANGULARJS_PLUGIN),
                "panel" => "angular_panel_settings",
                "description" => "",
            ]);
        }
    }

    public function register_colorpickercontrols($wp_customize) {
        $wp_customize->add_setting("wallstreet_pro_angularjs_options[customcolor_enabled]", [
            "default" => "#cccccc",
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "wallstreet_pro_angularjs_options[customcolor_enabled]", [
            'label' => esc_html__('Fixed Home Widget Background', DJS_ANGULARJS_PLUGIN),
            'section' => 'colors',
            'settings' => 'wallstreet_pro_angularjs_options[customcolor_enabled]'
        ]));

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[customtextcolor_enabled]", [
            "default" => "#ffffff",
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "wallstreet_pro_angularjs_options[customtextcolor_enabled]", [
            'label' => esc_html__('Fixed Home Widget Textcolor', DJS_ANGULARJS_PLUGIN),
            'section' => 'colors',
            'settings' => 'wallstreet_pro_angularjs_options[customtextcolor_enabled]'
        ]));
    }

    public function register_symolicfontcontrols($wp_customize) {
        $wp_customize->add_setting("wallstreet_pro_angularjs_options[symbolfonts_enabled]", [
            "default" => $this->is_djs_wallstreet_pro_theme,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[symbolfonts_enabled]", [
            "label" => esc_html__("Load symbolic fonts", DJS_ANGULARJS_PLUGIN),
            "section" => "angularfont_section_settings",
            "type" => "checkbox",
            "priority" => 100,
            "description" => esc_html__("enable if some icons are not displayed", DJS_ANGULARJS_PLUGIN),
        ]);
    }

    public function register_angularcontrols($wp_customize) {
        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angularjs_enabled]", [
            "default" => true,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angularjs_enabled]", [
            "label" => esc_html__("Enable AngularJS", DJS_ANGULARJS_PLUGIN),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
            "description" => esc_html__("If enabled the following and enabled features are also taken into account", DJS_ANGULARJS_PLUGIN),
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angularjs_version]", [
            "default" => '1.8.2',
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angularjs_version]", [
            "label" => esc_html__("Select version of AngularJS", DJS_ANGULARJS_PLUGIN),
            "section" => "angular_section_settings",
            "type" => "select",
            'choices' => [
                '1.2.32' => esc_html__('Version 1.2.32'),
                '1.8.2' => esc_html__('Version 1.8.2'),
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
            "label" => esc_html__("Enable AngularJS Locale", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Language", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Animate", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Aria", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Cookies", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Loader", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Message", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Messageformat", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Mocks", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Parse Extension", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Resource", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Route", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Sanitize", DJS_ANGULARJS_PLUGIN),
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
            "label" => esc_html__("Enable AngularJS Scenario", DJS_ANGULARJS_PLUGIN),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
            "description" => esc_html__("Only in Version 1.2.32", DJS_ANGULARJS_PLUGIN),
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_touch_enabled]", [
            "default" => false,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_touch_enabled]", [
            "label" => esc_html__("Enable AngularJS Touch", DJS_ANGULARJS_PLUGIN),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);

        $wp_customize->add_setting("wallstreet_pro_angularjs_options[angular_uibootstrap_enabled]", [
            "default" => true,
            "capability" => "edit_theme_options",
            "sanitize_callback" => "sanitize_text_field",
            "type" => "option",
        ]);

        $wp_customize->add_control("wallstreet_pro_angularjs_options[angular_uibootstrap_enabled]", [
            "label" => esc_html__("Enable AngularJS UI Bootstrap", DJS_ANGULARJS_PLUGIN),
            "section" => "angular_section_settings",
            "type" => "checkbox",
            "priority" => 100,
        ]);
    }
}
