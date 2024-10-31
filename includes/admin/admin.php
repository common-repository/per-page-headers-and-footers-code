<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Custom_Body_Admin {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		// ACE
		wp_enqueue_script('ace', CUSTOM_BODY_DIR_URL . 'assets/libraries/ace/ace.js', array(), '1.2.3', true);
		
		// Plugin
		wp_enqueue_script('custom-body', CUSTOM_BODY_DIR_URL . 'assets/js/admin.js', array('ace'), CUSTOM_BODY_VERSION, true);
	}

	/**
	 * Enqueue styles
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

		// Plugin
		wp_enqueue_style('custom-body', CUSTOM_BODY_DIR_URL . 'assets/css/admin.css', array(), CUSTOM_BODY_VERSION, 'all');
	}
}

new Custom_Body_Admin();