<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Retrieve settings
 *
 * @since 1.0.0
 * @return array
 */
function get_custom_body_settings() {
	return get_option('custom_body_settings', array());
}

/**
 * Retrieve setting field
 *
 * @since 1.0.0
 * @param string $setting
 * @param mixed $default
 * @return mixed
 */
function get_custom_body_setting($setting, $default = null) {
	$settings = get_custom_body_settings();
	return (isset($settings[$setting])) ? $settings[$setting] : $default;
}