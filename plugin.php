<?php
/**
 * Plugin Name: Per Page Headers and Footers Code
 * Description: The ability to add custom code (CSS, javascript, etc.) to the header and footer section of your wordpress website on a per page and/or global basis.
 * Version: 1.0.0
 * Author: Jaber Marketing
 * Author URI: https://www.jabermarketing.com
 * Requires at least: 4.0
 * Tested up to: 4.9.4
 *
 * Text Domain: custom-body
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

define('CUSTOM_BODY_VERSION', '1.0.5');
define('CUSTOM_BODY_DIR_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('CUSTOM_BODY_DIR_URL', trailingslashit(plugin_dir_url(__FILE__)));

register_activation_hook(__FILE__, 'custom_body_activate');
register_deactivation_hook(__FILE__, 'custom_body_deactivate');

/**
 * Plugin activation
 *
 * @since 1.0.0
 */
function custom_body_activate() {
	do_action('custom_body_activate');
}

/**
 * Plugin deactivation
 *
 * @since 1.0.0
 */
function custom_body_deactivate() {
	do_action('custom_body_deactivate');
}

/**
 * Plugin initialization
 *
 * @since 1.0.0
 */
function custom_body_init() {

	require_once(CUSTOM_BODY_DIR_PATH . 'includes/functions.php');

	require_once(CUSTOM_BODY_DIR_PATH . 'includes/header-handler.php');
	require_once(CUSTOM_BODY_DIR_PATH . 'includes/footer-handler.php');

	if (is_admin()) {
		require_once(CUSTOM_BODY_DIR_PATH . 'includes/admin/admin.php');
		require_once(CUSTOM_BODY_DIR_PATH . 'includes/admin/admin-campaign.php');
		require_once(CUSTOM_BODY_DIR_PATH . 'includes/admin/admin-settings.php');
		require_once(CUSTOM_BODY_DIR_PATH . 'includes/admin/admin-meta-box.php');
	}
}
add_action('plugins_loaded', 'custom_body_init');