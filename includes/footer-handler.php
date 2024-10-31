<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Custom_Footer_Handler {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->post_types = get_custom_body_setting('post_types', array());

		add_action('wp_footer', array($this, 'enqueue_scripts'));
	}

	/**
	 * Enqueue script codes
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		$global_footer_scripts = get_custom_body_setting('footer_scripts');

		if ($this->post_types && is_singular($this->post_types)) {
			$post_id = get_queried_object_id();
			$footer_scripts = get_post_meta($post_id, '_footer_scripts', true);
			$hide_footer_scripts = get_post_meta($post_id, '_hide_footer_scripts', true);
			$hide_global_footer_scripts = get_post_meta($post_id, '_hide_global_footer_scripts', true);

			if ($hide_global_footer_scripts == false) {
				echo $global_footer_scripts;
			}

			if ($hide_footer_scripts == false) {
				echo $footer_scripts;
			}

		} else  {

			echo $global_footer_scripts;
		}
	}
}

new Custom_Footer_Handler();