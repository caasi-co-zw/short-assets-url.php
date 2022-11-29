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
 * Shortens the urls
 */

function short_assets_url_plugin() {
    /**
     * Returns the url for the specified directory
     * @param string $dir
     * @return string
     */
    function get_dir(?string $dir) {
        $theme = wp_get_theme();

        if (!$dir) {
            return sprintf('wp-content/themes/%s/', $theme->get('TextDomain'));
        }
        $dir = $dir . (dir_exists(get_dir('assets/')) ? 'assets/' : '');
        return sprintf('%s/%s/%s', get_dir(null), $dir, '$1');
    }

    /**
     * Returns true if the specified folder exists.
     *
     * Is used to determine if theme should get assets from an assets folder or not.
     * @return bool
     */
    function dir_exists(string $dir) {
        return file_exists($dir) && is_dir($dir);
    }
    global $wp_rewrite;

    $rules = array(
        'js/(.*)'     => get_dir('js'),
        'css/(.*)'    => get_dir('css'),
        'img/(.*)'    => get_dir('img'),
    );
    $wp_rewrite->non_wp_rules += $rules;
}

add_action('generate_rewrite_rules', 'short_assets_url_plugin');
