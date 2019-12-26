<?php

/**
 * Handles all actions and regarding Sign In, Sign Up or Password Recovery
 *
 * @link       mailto:artem.kashel@gmail.com
 * @since      1.0.0
 *
 * @package    Addendio_Sandbox_Management
 * @subpackage Addendio_Sandbox_Management/includes/controllers/public
 */
class Addendio_Sandbox_Management_Login_Register_Controller {

	public function login( $login, $password, $remember_me ) {
		$credentials = array();

		$credentials['user_login']    = sanitize_text_field( $login );
		$credentials['user_password'] = sanitize_text_field( $password );
		$credentials['remember']      = ( isset( $remember_me ) ) ? false : true;
		$user                         = wp_signon( $credentials, false );

		if ( is_wp_error( $user ) ) {
			wp_send_json_error( array(
				'message' => preg_replace( '#<[^>]*a[^>]*>#msiU', '', $user->get_error_message() ),
			) );
		}

		wp_send_json_success( array(
			'message' => Addendio_Sandbox_Management::$msg->get_message_public( 'success', 'login_reg', 'user_login_success' )
		) );
	}

	public function register( $login, $email, $password ) {
		if ( validate_username( $login ) && username_exists( $login ) ) {
			wp_send_json_error( array(
				'message' => Addendio_Sandbox_Management::$msg->get_message_public( 'error', 'login_reg', 'username_exists' )
			) );
		}

		if ( is_email( $email ) && email_exists( $email ) ) {
			wp_send_json_error( array(
				'message' => Addendio_Sandbox_Management::$msg->get_message_public( 'error', 'login_reg', 'email_exists' )
			) );
		}

		$user = wp_create_user(
			sanitize_text_field( $login ),
			sanitize_text_field( $password ),
			sanitize_email( $email )
		);

		if ( is_wp_error( $user ) ) {
			wp_send_json_error( array(
				'message' => $user->get_error_message(),
			) );
		}

		wp_send_json_success( array(
			'message' => Addendio_Sandbox_Management::$msg->get_message_public( 'success', 'login_reg', 'user_register_success' )
		) );
	}

	public function password_recovery( $email_or_login ) {
		$get_by = false;

		if ( validate_username( $email_or_login ) && username_exists( $email_or_login ) ) {
			$get_by         = 'login';
			$email_or_login = sanitize_text_field( $email_or_login );
		}

		if ( is_email( $email_or_login ) && email_exists( $email_or_login ) ) {
			$get_by         = 'email';
			$email_or_login = sanitize_email( $email_or_login );
		}

		if ( $get_by ) {
			$user            = get_user_by( $get_by, $email_or_login );
			$random_password = wp_generate_password();

			$update_user = wp_update_user( array( 'ID' => $user->ID, 'user_pass' => $random_password ) );
		}

		if ( $update_user ) {
			$sitename = strtolower( $_SERVER['SERVER_NAME'] );
			if ( substr( $sitename, 0, 4 ) == 'www.' ) {
				$sitename = substr( $sitename, 4 );
			}
			$admin_email = 'admin@' . $sitename;

			$subject = __( 'Your new password', 'addendio-sandbox-management' );
			$sender  = __( 'From: ', 'addendio-sandbox-management' ) . get_option( 'name' ) . ' <' . $admin_email . '>';

			$message = __( 'Your new password is:', 'addendio-sandbox-management' ) . ' ' . $random_password;

			$headers = array(
				$sender,
			);

			$mail = wp_mail( $user->user_email, $subject, $message, $headers );

			if ( $mail ) {
				wp_send_json_success( array(
					'message' => Addendio_Sandbox_Management::$msg->get_message_public( 'success', 'login_reg', 'password_recovery_success' ),
				) );
			} else {
				wp_send_json_error( array(
					'message' => Addendio_Sandbox_Management::$msg->get_message_public( 'error', 'login_reg', 'password_recovery_fail_email' ),
				) );
			}

		}

		wp_send_json_error( array(
			'message' => Addendio_Sandbox_Management::$msg->get_message_public( 'error', 'login_reg', 'password_recovery_fail_common' ),
		) );

	}

}