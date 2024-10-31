<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Custom_Body_Admin_Meta_Box {

	protected $post_types;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->post_types = get_custom_body_setting('post_types', array());

		add_action('add_meta_boxes', array($this, 'register_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_box'), 10, 2);
	}

	/**
	 * Register meta boxes
	 *
	 * @since 1.0.0
	 */
	public function register_meta_boxes() {
		if ($this->post_types) {
			foreach ($this->post_types as $post_type) {
				add_meta_box(
					'custom-body-meta-box',
					__('Custom Header', 'custom-body'),
					array( $this, 'output_meta_box'),
					$post_type,
					'advanced',
					'default'
				);
			}
		}
	}

	/**
	 * Output meta box
	 *
	 * @since 1.0.0
	 * @param WP_Post $post
	 * @return void
	 */
	public function output_meta_box($post) {
		$post_id = $post->ID; 

		$meta_fields = array(
			'hide_global_header_scripts' => get_post_meta($post_id, '_hide_global_header_scripts', true),
			'hide_global_footer_scripts' => get_post_meta($post_id, '_hide_global_footer_scripts', true),
			'hide_header_scripts' => get_post_meta($post_id, '_hide_header_scripts', true),
			'hide_footer_scripts' => get_post_meta($post_id, '_hide_footer_scripts', true),
			'header_scripts' => get_post_meta($post_id, '_header_scripts', true),
			'footer_scripts' => get_post_meta($post_id, '_footer_scripts', true),
		); 
	?>
		
		<?php wp_nonce_field('custom_body_nonce', 'custom_body_nonce'); ?>
		
		<div class="meta-field">
			<label><?php _e('Deactivate Global Header Code/Scripts', 'custom-body'); ?></label>

			<input type="checkbox" name="hide_global_header_scripts" value="1" <?php checked($meta_fields['hide_global_header_scripts'], 1); ?> />
		</div>
		
		<div class="meta-field">
			<label><?php _e('Hide global footer scripts?', 'custom-body'); ?></label>

			<input type="checkbox" name="hide_global_footer_scripts" value="1" <?php checked($meta_fields['hide_global_footer_scripts'], 1); ?> />
		</div>
		
		<div class="meta-field">
			<label><?php _e('Deactivate Header Code/Scripts Below', 'custom-body'); ?></label>

			<input type="checkbox" name="hide_header_scripts" value="1" <?php checked($meta_fields['hide_header_scripts'], 1); ?> />
		</div>

		<div class="meta-field meta-field-hide_header_scripts">
			<label><?php _e('Header Code/Scripts', 'custom-body'); ?></label>

			<textarea name="header_scripts" class="large-text code ace-editor" rows="10" cols="50" data-ace-mode="html" data-ace-theme="<?php echo get_custom_body_setting('editor_theme'); ?>"><?php echo $meta_fields['header_scripts']; ?></textarea>
		</div>
		
		<div class="meta-field">
			<label><?php _e('Deactivate Footer Code/Scripts Below', 'custom-body'); ?></label>

			<input type="checkbox" name="hide_footer_scripts" value="1" <?php checked($meta_fields['hide_footer_scripts'], 1); ?> />
		</div>


		<div class="meta-field meta-field-hide_footer_scripts">
			<label><?php _e('Footer Code/Scripts', 'custom-body'); ?></label>

			<textarea name="footer_scripts" class="large-text code ace-editor" rows="10" cols="50" data-ace-mode="html" data-ace-theme="<?php echo get_custom_body_setting('editor_theme'); ?>"><?php echo $meta_fields['footer_scripts']; ?></textarea>
		</div>

        <?php
	}

	/**
	 * Save meta box data
	 *
	 * @since 1.0.0
	 * @param int $post_id
	 * @param WP_Post $post
	 * @return void
	 */
	public function save_meta_box($post_id, $post) {

		if ( ! wp_verify_nonce(isset($_POST['custom_body_nonce']) ? $_POST['custom_body_nonce'] : '', 'custom_body_nonce')) {
			return false;
		}

		if ( ! current_user_can('edit_post', $post_id) || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
			return false;
		}

		$meta_fields = array(
			'hide_global_header_scripts',
			'hide_global_footer_scripts',
			'hide_header_scripts',
			'hide_footer_scripts',
			'header_scripts',
			'footer_scripts',
		); 

		foreach ($meta_fields as $meta_field) {
			if (isset($_POST["{$meta_field}"])) {
				update_post_meta($post_id, "_{$meta_field}", $_POST["{$meta_field}"]);
			} else {
				update_post_meta($post_id, "_{$meta_field}", null);
			}
		}
	}
}

new Custom_Body_Admin_Meta_Box();