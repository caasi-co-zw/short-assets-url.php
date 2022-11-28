<?php

/**
 * Plugin Name: Assets Url Shortener
 * Plugin URI: https://github.com/caasi-co-zw/short-assets-url.php
 * Description: Shorten your assets url. You can simply use /css/style.css for your assets.
 * Version: 1.0
 * Author: Caasi
 * Author URI: https://caasi.co.zw
 */

/**
 * In case Caasi Groomer is in use, let it know.
 */
@define('WP_SHORTEN_ASSETS_URL', false);

/**
 * Returns the url for the specified directory
 * @param string $dir
 * @return string
 */
function get_dir(string $dir) {
    $theme = wp_get_theme();
    return sprintf('wp-content/themes/%s/assets/%s/$1', $theme->get('Name'), $dir);
}

/**
 * Shortens the urls
 */

function init() {

    global $wp_rewrite;
    $new_non_wp_rules = array(
        'css/(.*)'       => get_dir('css'),
        'js/(.*)'        => get_dir('js'),
        'img/(.*)'    => get_dir('image'),
    );
    $wp_rewrite->non_wp_rules += $new_non_wp_rules;
}

add_action('generate_rewrite_rules', 'init');
