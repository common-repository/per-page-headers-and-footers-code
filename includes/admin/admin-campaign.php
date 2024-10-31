<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Custom_Body_Admin_Campaign {

	public function __construct() {

		add_action('admin_notices', array($this, 'display'));
		add_action('admin_init', array($this, 'send'));

		add_action('wp_ajax_custom_body_admin_ignore', array($this, 'ignore'));
	}

	/**
	 * Output notices
	 *
	 * @since 1.0.5
	 */
	public function display() {
		if ($this->hidden()) {
			return;
		}

		$user = get_userdata(get_current_user_id());

	    ?>

		<div class="notice notice-success is-dismissible custom-body-campaign">
			<form class="custom-body-campaign-form" action="" method="post">
				<p><strong>Important:</strong> Make sure you submit your name and email in the form below, so you can receive updates and other important information.</p>
				<p>
					<input name="name" type="text" value="<?php echo $user->user_name; ?>" class="regular-text ltr" placeholder="<?php _e('Your Name'); ?>">
					<input name="email" type="email" value="<?php echo $user->user_email; ?>" class="regular-text ltr" placeholder="<?php _e('Your Email'); ?>">
				</p>
				<p>
					<input type="submit" name="custom-body-campaign" id="submit" class="button button-primary" value="<?php _e('Submit'); ?>">
				</p>
			</form>
		</div>

		<?php
	}

	public function send() {

		if ( ! isset($_POST['custom-body-campaign'])) {
			return;
		}

		$data = array(
			'email' => isset($_POST['email']) ? $_POST['email'] : null,
			'name' => isset($_POST['name']) ? $_POST['name'] : null,
		);

		if (empty($data['email'])) {
			return;
		}

		$response = wp_remote_post('http://jabermarketing.com/api/campaigns', array(
			'method' => 'POST',
			'body' => array(
				'email' => $data['email'],
				'name' => $data['name'],
			)
		));

		if ($response && ( ! is_wp_error($response))) {
			$data = json_decode(wp_remote_retrieve_body($response), true);

			if ($data['success'] == true) {
				$this->hide();
			}
		}
	}

	public function ignore() {

		$this->hide();
	}


	# Helpers

	protected function hide() {
		update_option('custom_body_ignore_notice', true);
	}

	protected function hidden() {
		return get_option('custom_body_ignore_notice', false);
	}
}

new Custom_Body_Admin_Campaign();