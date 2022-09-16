<?php
function plugin_setup_data()
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

function get_current_angularjs_options()
{
    $current_options = plugin_setup_data();
    return wp_parse_args(get_option("wallstreet_pro_angularjs_options", []), $current_options);
}
