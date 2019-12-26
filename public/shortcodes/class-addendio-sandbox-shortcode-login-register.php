<?php

/**
 * Class Addendio_Sandbox_Management_Shortcode_Login_Register
 *
 * The class to output custom login form on page.
 *
 * @since      1.0.0
 * @package    Addendio_Sandbox_Management
 * @subpackage Addendio_Sandbox_Management/public/shortcodes
 * @author     Artsem Kashel <artem.kashel@gmail.com>
 */
class Addendio_Sandbox_Management_Shortcode_Login_Register extends Addendio_Sandbox_Management_Shortcode {

	/**
	 * Actual plugin shortcode.
	 */
	const SHORTCODE = 'addendio_login_register';

	/**
	 * Outputs Sign In form HTML markup.
	 *
	 * @param string $profile_link link to user profile page.
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @return string $html Sign In form HTML markup.
	 */
	private function login_form_html( $profile_link ) {
		$html = "<form id=\"addendio-form-login\" class=\"addendio-form addendio-form--login\" data-profile=\"{$profile_link}\" method=\"post\" action=\"\">";
		$html .= '<h2 class="addendio-form__title">' . __( 'Sign In', 'addendio-sandbox-management' ) . '</h2>';
		$html .= '<label for="addendio-username-in">' . __( 'Username', 'addendio-sandbox-management' );
		$html .= '<input id="addendio-username-in" type="text" name="addendio-username-in" required></label>';
		$html .= '<label for="addendio-password-in">' . __( 'Password', 'addendio-sandbox-management' );
		$html .= '<input id="addendio-password-in" type="password" name="addendio-password-in" required></label>';
		$html .= '<label for="addendio-rememberme-in">' . __( 'Remember Me', 'addendio-sandbox-management' ) . '&nbsp;';
		$html .= '<input id="addendio-rememberme-in" type="checkbox" name="addendio-rememberme-in" value="true" checked></label>';
		$html .= '<div class="addendio-input-group">';
		$html .= '<a href="#addendio-form-password-recovery" class="js-addendio-login-form-switch addendio-link addendio-link--action" href="#">' . __( 'Lost your password?', 'addendio-sandbox-management' ) . '</a>';
		$html .= '<input class="addendio-link" type="submit" value="' . __( 'Login', 'addendio-sandbox-management' ) . '" name="addendio-submit-in">';
		$html .= '</div>';
		$html .= wp_nonce_field( 'addendio_login', '_addendio_login_nonce', true, false );
		$html .= '</form>';

		return $html;
	}

	/**
	 * Outputs Password Recovery form HTML markup.
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @return string $html Password Recovery form HTML markup.
	 */
	private function password_recovery_form_html() {
		$recovery_text = __( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'addendio-sandbox-management' );

		$html = "<form style=\"display: none;\" id=\"addendio-form-password-recovery\" class=\"addendio-form addendio-form--password-recovery\" method=\"post\" action=\"\">";
		$html .= '<h2 class="addendio-form__title">' . __( 'Password Recovery', 'addendio-sandbox-management' ) . '</h2>';
		$html .= "<p>$recovery_text</p>";
		$html .= '<label for="addendio-username-email">' . __( 'Username or Email Address', 'addendio-sandbox-management' );
		$html .= '<input id="addendio-username-email" type="text" name="addendio-username-email" required></label>';
		$html .= '<div class="addendio-input-group">';
		$html .= '<a href="#addendio-form-login" class="js-addendio-login-form-switch addendio-link addendio-link--action" href="#">&#8678; ' . __( 'Back to Login', 'addendio-sandbox-management' ) . '</a>';
		$html .= '<input class="addendio-link" type="submit" value="' . __( 'Get New Password', 'addendio-sandbox-management' ) . '" name="addendio-submit-pr">';
		$html .= '</div>';
		$html .= wp_nonce_field( 'addendio_password_recovery', '_addendio_password_recovery_nonce', true, false );
		$html .= '</form>';

		return $html;
	}

	/**
	 * Outputs Sign Up form HTML markup.
	 *
	 * @param string $profile_link link to user profile page.
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @return string $html Sign Up form HTML markup.
	 */
	private function register_form_html( $profile_link ) {
		$html = "<form id=\"addendio-form-register\" class=\"addendio-form addendio-form--register\" data-profile=\"{$profile_link}\" method=\"post\" action=\"\">";
		$html .= '<h2 class="addendio-form__title">' . __( 'Sign Up', 'addendio-sandbox-management' ) . '</h2>';
		$html .= '<label for="addendio-username-up">' . __( 'Username', 'addendio-sandbox-management' );
		$html .= '<input id="addendio-username-up" type="text" name="addendio-username-up" required></label>';
		$html .= '<label for="addendio-email-up">' . __( 'Email', 'addendio-sandbox-management' );
		$html .= '<input id="addendio-email-up" type="text" name="addendio-email-up" required></label>';
		$html .= '<label for="addendio-password-up">' . __( 'Password', 'addendio-sandbox-management' );
		$html .= '<input id="addendio-password-up" type="password" name="addendio-password-up" required></label>';
		$html .= '<label for="addendio-password-retype-up">' . __( 'Re-enter Password', 'addendio-sandbox-management' );
		$html .= '<input id="addendio-password-retype-up" type="password" name="addendio-password-retype-up" required></label>';
		$html .= '<input class="addendio-link" type="submit" value="' . __( 'Register', 'addendio-sandbox-management' ) . '" name="addendio-submit-up">';
		$html .= wp_nonce_field( 'addendio_register', '_addendio_register_nonce', true, false );
		$html .= '</form>';

		return $html;
	}

	/**
	 * Outputs shortcode html markup.
	 *
	 * @since    1.0.0
	 * @access   public
	 *
	 * @return string $html Shortcode HTML
	 */
	public function shortcode_html( $atts ) {
		$atts = shortcode_atts( array(
			'profile_page' => 'profile',
		), $atts );

		$profile_link = str_replace( '"', '', get_permalink( get_page_by_path( $atts['profile_page'] ) ) );

		$html = '<section class="addendio-section">';
		$html .= '<h1>' . __( 'My Account', 'addendio-sandbox-management' ) . '</h1>';
		$html .= '<div id="addendio-forms" class="addendio-box addendio-row">';
		$html .= '<div class="addendio-column addendio-column-1-2">';
		$html .= $this->login_form_html( $profile_link );
		$html .= $this->password_recovery_form_html();
		$html .= '</div>';
		$html .= '<div class="addendio-column addendio-column-1-2">';
		$html .= $this->register_form_html( $profile_link );
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</section>';

		return $html;
	}

}