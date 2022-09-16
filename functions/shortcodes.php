<?php
// The [ng-app name="my-app" class="class"] shortcode
function angluarapp_div($atts, $content = null)
{
    extract(shortcode_atts([
        'name'  => 'my-app',
        'class' => 'ng-scope',
        'style' => '',
        'id'    => '',
    ], $atts));

    $result = '<div';
    if (!empty($name))  $result .= ' ng-app="' . $name . '" ';
    if (!empty($class)) $result .= ' class="' . $class . '" ';
    if (!empty($style)) $result .= ' style="' . $style . '" ';
    if (!empty($id))    $result .= ' id="' . $id . '" ';
    $result .= '>';
    if (!empty($content)) $result .= $content . "</div>";
    return $result;
}
add_shortcode('ng-app', 'angluarapp_div');

// The [ng-app-end] shortcode
function angluarapp_end_div()
{
    return '</div>';
}
add_shortcode('ng-app-end', 'angluarapp_end_div');

// The [ng-form controller="my-controller" class="class"] shortcode
function angluarapp_form($atts, $content = null)
{
    extract(shortcode_atts([
        'controller'    => 'my-controller',
        'name'          => 'my-form',
        'class'         => '',
        'style'         => '',
        'id'            => '',
    ], $atts));

    $result = '<form';
    if (!empty($name))          $result .= ' name="' . $name . '" ';
    if (!empty($controller))    $result .= ' ng-controller="' . $controller . '" ';
    if (!empty($class))         $result .= ' class="' . $class . '" ';
    if (!empty($style))         $result .= ' style="' . $style . '" ';
    if (!empty($id))            $result .= ' id="' . $id . '" ';
    $result .= '>';
    if (!empty($content))       $result .= $content . "</form>";
    return $result;
}
add_shortcode('ng-form', 'angluarapp_form');

// The [ng-form-end] shortcode
function angluarapp_end_form()
{
    return '</form>';
}
add_shortcode('ng-form-end', 'angluarapp_end_form');