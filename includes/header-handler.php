<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Custom_Header_Handler {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->post_types = get_custom_body_setting('post_types', array());

		add_action('wp_head', array($this, 'enqueue_scripts'));
	}

	/**
	 * Enqueue script codes
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		$global_header_scripts = get_custom_body_setting('header_scripts');

		if ($this->post_types && is_singular($this->post_types)) {
			$post_id = get_queried_object_id();
			$header_scripts = get_post_meta($post_id, '_header_scripts', true);
			$hide_header_scripts = get_post_meta($post_id, '_hide_header_scripts', true);
			$hide_global_header_scripts = get_post_meta($post_id, '_hide_global_header_scripts', true);

			if ($hide_global_header_scripts == false) {
				echo $global_header_scripts;
			}

			if ($hide_header_scripts == false) {
				echo $header_scripts;
			}

		} else  {

			echo $global_header_scripts;
		}
	}
}

new Custom_Header_Handler();