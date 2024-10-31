<?php

/*
    Plugin Name: Redirect attachment pages for WordPress
    Plugin URI: https://code4life.it/shop/plugins/redirect-attachment-pages-for-wordpress/
    Description: Prevent attachment pages to be viewed from users and to be indexed from search engines.
    Author: Code4Life
    Author URI: https://code4life.it/
    Version: 1.0.3
    Text Domain: wpsapi
 	Domain Path: /i18n/
	License: GPLv3
	License URI: http://www.gnu.org/licenses/gpl-3.0.html

    Tested up to: 6.6
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Add language support to internationalize plugin
add_action( 'init', function() {
	load_plugin_textdomain( 'wpsapi', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n/' );
} );

// HPOS compatibility
add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );

// Prevent attachment pages to be indexed
add_action( 'template_redirect', function() {
	if ( is_attachment() ) {
		global $post;
		if ( $post && $post->post_parent ) {
			wp_safe_redirect( esc_url( get_permalink( $post->post_parent ) ), 301 );
			exit;
		} else {
			wp_safe_redirect( esc_url( home_url( '/' ) ), 301 );
			exit;
		}
	}
} );