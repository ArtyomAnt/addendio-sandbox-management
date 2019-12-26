<?php

/**
 * Class Addendio Sandbox Management Public Router
 *
 * @since      1.0.0
 * @package    Addendio_Sandbox_Management_Public_Router
 * @subpackage Addendio_Sandbox_Management_Public_Router/includes/controllers
 * @author     Artsem Kashel <artem.kashel@gmail.com>
 */
class Addendio_Sandbox_Management_Public_Router {
	/**
	 * Array of allowed actions list.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array $allowed_actions Allowed actions list.
	 */
	private $allowed_actions = array(
		'login'             => '_addendio_login_nonce',
		'register'          => '_addendio_register_nonce',
		'password_recovery' => '_addendio_password_recovery_nonce',
	);

	private $request = array();

	public function __construct() {
		add_action( 'wp_ajax_handle_request', array( $this, 'handle_request' ) );
		add_action( 'wp_ajax_nopriv_handle_request', array( $this, 'handle_request' ) );
	}

	public static function addendio_public_router_register() {
		return new static();
	}

	public function handle_request() {
		$action = $_POST['addendio_action'];
		parse_str( $_POST['addendio_data'], $this->request );

		if (
			! array_key_exists( 'addendio_action', $_POST ) ||
			empty( $_POST['addendio_action'] ) ||
			! array_key_exists( $_POST['addendio_action'], $this->allowed_actions ) ||
			! array_key_exists( 'addendio_data', $_POST ) ||
			! wp_verify_nonce( $this->request[ $this->allowed_actions[ $action ] ], "addendio_{$action}" )
		) {
			wp_send_json_error( array(
				'message' => Addendio_Sandbox_Management::$msg->get_message_public( 'error', 'server', 'common' ),
			) );
		}


		$this->$action();
	}

	private function login() {
		$controller = new Addendio_Sandbox_Management_Login_Register_Controller();
		$controller->login(
			$this->request['addendio-username-in'],
			$this->request['addendio-password-in'],
			$this->request['addendio-rememberme-in']
		);
	}

	private function register() {
		$controller = new Addendio_Sandbox_Management_Login_Register_Controller();
		$controller->register(
			$this->request['addendio-username-up'],
			$this->request['addendio-email-up'],
			$this->request['addendio-password-up']
		);
	}

	private function password_recovery() {
		$controller = new Addendio_Sandbox_Management_Login_Register_Controller();
		$controller->password_recovery(
			$this->request['addendio-username-email']
		);
	}

}