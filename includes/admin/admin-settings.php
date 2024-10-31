<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Custom_Body_Admin_Settings {

	private $page_slug = 'custom-body';
	private $page_settings = array();

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action('admin_menu', array($this, 'register_menu'));
		add_action('admin_init', array($this, 'register_settings'));
	}

	/**
	 * Register admin menu
	 *
	 * @since 1.0.0
	 */
	public function register_menu() {
        add_options_page(
            __('Custom Header Settings', 'custom-body'), 
            __('Custom Header', 'custom-body'), 
            'manage_options', 
            $this->page_slug, 
            array($this, 'output_settings')
        );
	}

	/**
	 * Output settings page
	 *
	 * @since 1.0.0
	 */
	public function output_settings() { 
		$this->page_settings = get_option('custom_body_settings', array()); ?>

		<div class="wrap">
			<h2><?php _e('Custom Header Settings', 'custom-body'); ?></h2>

			<form method="post" action="options.php">
				<?php settings_fields('custom_body_settings'); ?>
				<?php do_settings_sections($this->page_slug); ?>
				<?php submit_button(); ?>
			</form>
		</div>

		<?php
	}

	/**
	 * Register admin settings
	 *
	 * @since 1.0.0
	 */
	public function register_settings() {
		register_setting(
			'custom_body_settings',
			'custom_body_settings',
			array($this, 'sanitize_settings')
		);

		# General Settings

		add_settings_section(
			'custom_body_general_setings',
			__('General Settings', 'custom-body'),
			array($this, 'output_section_field'),
			$this->page_slug
		);

		add_settings_field(
			'post_types',
			__('Activate the plugin on', 'custom-body'),
			array($this, 'output_post_types'),
			$this->page_slug,
			'custom_body_general_setings'
		);

		add_settings_field(
			'editor_theme',
			__('Choose your editor theme', 'custom-body'),
			array($this, 'output_editor_theme'),
			$this->page_slug,
			'custom_body_general_setings'
		);

		add_settings_field(
			'header_scripts',
			__('Add GLOBAL header code/scripts', 'custom-body'),
			array($this, 'output_header_scripts'),
			$this->page_slug,
			'custom_body_general_setings'
		);

		add_settings_field(
			'footer_scripts',
			__('Add GLOBAL footer code/scripts', 'custom-body'),
			array($this, 'output_footer_scripts'),
			$this->page_slug,
			'custom_body_general_setings'
		);

	}

	/**
	 * Sanitize setting fields
	 *
	 * @since 1.0.0
	 * @param mixed $input
	 * @return mixed $input
	 */
	public function sanitize_settings($input) {
		$settings = isset($_POST['custom_body_settings']) ? $_POST['custom_body_settings'] : array();

		return $input;
	}

	/**
	 * Output setting section field
	 *
	 * @since 1.0.0
	 */
	public function output_section_field() {
		printf('');
	}

	/**
	 * Output "Post Types" setting field
	 *
	 * @since 1.0.0
	 */
	public function output_post_types() {
		$post_types = get_post_types(array(
			'public' => true,
			'publicly_queryable' => true
		), 'objects'); 

		$current_post_types = get_custom_body_setting('post_types', array()); ?>

		<label>
			<input type="checkbox" <?php checked(in_array('page', $current_post_types), true); ?> value="page" name="custom_body_settings[post_types][]" />
			<?php echo __('Pages'); ?>
		</label>

		<br />

		<?php foreach ($post_types as $post_type) : ?>
			<?php if ($post_type->name == 'attachment') continue; ?>

			<label>
				<input type="checkbox" <?php checked(in_array($post_type->name, $current_post_types), true); ?> value="<?php echo $post_type->name; ?>" name="custom_body_settings[post_types][]" />
				<?php echo $post_type->label; ?>
			</label>

			<br />
		<?php endforeach; ?>

		<?php
	}

	/**
	 * Output "Editor Theme" setting field
	 *
	 * @since 1.0.0
	 */
	public function output_editor_theme() { 
		$themes = apply_filters('custom_body_editor_themes', array(
				'ambiance' => 'Ambiance',
				'chaos' => 'Chaos',
				'chrome' => 'Chrome',
				'cloud' => 'Cloud',
				'clouds_midnight' => 'Clouds Midnight',
				'cobalt' => 'Cobalt',
				'crimson_editor' => 'Crimson',
				'dawn' => 'Dawn',
				'dreamweaver' => 'Dreamweaver',
				'eclipse' => 'Eclipse',
				'github' => 'Github',
				'idle_fingers' => 'Idle Fingers',
				'iplastic' => 'iPlastic',
				'katzenmilch' => 'Katzenmilch',
				'kr_theme' => 'KR Theme',
				'kuroir' => 'Kuroir',
				'merbivore' => 'Merbivore',
				'merbivore_soft' => 'Merbivore Soft',
				'mono_industrial' => 'Mono Industrial',
				'monokai' => 'Monokai',
				'pastel_on_dark' => 'Pastel on Dark',
				'solarized_dark' => 'Solarized Dark',
				'solarized_light' => 'Solarized Light',
				'sqlserver' => 'SQLServer',
				'terminal' => 'Terminal',
				'textmate' => 'Textmate',
				'tomorrow' => 'Tomorrow',
				'tomorrow_night' => 'Tomorrow Night',
				'tomorrow_night_blue' => 'Tomorrow Night (Blue)',
				'tomorrow_night_bright' => 'Tomorrow Night (Bright)',
				'tomorrow_night_eighties' => 'Tomorrow Night (Eighties)',
				'twilight' => 'Twilight', 
				'vibrant_ink' => 'Vibrant Ink',
				'xcode' => 'XCode'
			)
		); 

		$current_theme = get_custom_body_setting('editor_theme'); ?>

		<select name="custom_body_settings[editor_theme]">
			<?php foreach ($themes as $theme => $theme_label) : ?>
				<option value="<?php echo $theme; ?>" <?php selected($current_theme, $theme); ?>><?php echo $theme_label; ?></option>
			<?php endforeach; ?>
		</select>

		<?php
	}

	/**
	 * Output "Header Code/Scripts" setting field
	 *
	 * @since 1.0.0
	 */
	public function output_header_scripts() { ?>

		<textarea name="custom_body_settings[header_scripts]" class="large-text code ace-editor" rows="10" cols="50" data-ace-mode="html" data-ace-theme="<?php echo get_custom_body_setting('editor_theme'); ?>"><?php echo $this->get_setting('header_scripts'); ?></textarea>

		<?php
	}

	/**
	 * Output "Footer Code/Scripts" setting field
	 *
	 * @since 1.0.0
	 */
	public function output_footer_scripts() { ?>

		<textarea name="custom_body_settings[footer_scripts]" class="large-text code ace-editor" rows="10" cols="50" data-ace-mode="html" data-ace-theme="<?php echo get_custom_body_setting('editor_theme'); ?>"><?php echo $this->get_setting('footer_scripts'); ?></textarea>

		<?php
	}


	# Helpers

	/**
	 * Retrieve setting field
	 *
	 * @since 1.0.0
	 * @param string $setting
	 * @return mixed
	 */
	public function get_setting($setting) {
		return (isset($this->page_settings[$setting])) ? $this->page_settings[$setting] : null;
	}
}

new Custom_Body_Admin_Settings();