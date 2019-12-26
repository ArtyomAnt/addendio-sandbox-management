<?php

/**
 * Class Addendio Sandbox Management Public Router
 *
 * @since      1.0.0
 * @package    Addendio_Sandbox_Management_Message
 * @subpackage Addendio_Sandbox_Management_Message/includes
 * @author     Artsem Kashel <artem.kashel@gmail.com>
 */
class Addendio_Sandbox_Management_Message {

	public $messages_public = array();

	public function __construct() {
		$this->specify_messages_public();
	}

	private function specify_messages_public() {
		$this->messages_public = array(
			'error' => array(
				'server'    => array(
					'common' => __( 'Something went wrong. Please try one more time!', 'addendio-sandbox-management' ),
				),
				'login_reg' => array(
					'invalid_credentials'           => __( 'Username/Email or Password are invalid!', 'addendio-sandbox-management' ),
					'username_exists'               => __( 'User with such username already exists!', 'addendio-sandbox-management' ),
					'email_exists'                  => __( 'User with such email already exists!', 'addendio-sandbox-management' ),
					'password_recovery_fail_email'  => __( 'System is unable to send you mail containg your new password.', 'addendio-sandbox-management' ),
					'password_recovery_fail_common' => __( 'Oops! Something went wrong while updaing your account.', 'addendio-sandbox-management' ),
				),
			),

			'success' => array(
				'login_reg' => array(
					'password_recovery_success' => __( 'Check your email address for you new password.', 'addendio-sandbox-management' ),
					'user_register_success' => __( 'Congratulations! You are registered. You can now login using your credentials.', 'addendio-sandbox-management' ),
					'user_login_success' => __( 'Congratulations! You successfully logged in.', 'addendio-sandbox-management' ),
				),
			),
		);
	}

	public function get_messages_public() {
		return $this->messages_public;
	}

	public function get_message_public( $type, $category, $message ) {
		if ( ! array_key_exists( $message, $this->messages_public[ $type ][ $category ] ) ) {
			return new \Exception( 'Message does not exist!' );
		}

		return $this->messages_public[ $type ][ $category ][ $message ];
	}

}