<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              mailto:artem.kashel@gmail.com
 * @since             1.0.0
 * @package           Addendio_Sandbox_Management
 *
 * @wordpress-plugin
 * Plugin Name:       Addendio Sandbox Management
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Artsem Kashel
 * Author URI:        mailto:artem.kashel@gmail.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       addendio-sandbox-management
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-addendio-sandbox-management-activator.php
 */
function activate_addendio_sandbox_management() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-addendio-sandbox-management-activator.php';
	Addendio_Sandbox_Management_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-addendio-sandbox-management-deactivator.php
 */
function deactivate_addendio_sandbox_management() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-addendio-sandbox-management-deactivator.php';
	Addendio_Sandbox_Management_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_addendio_sandbox_management' );
register_deactivation_hook( __FILE__, 'deactivate_addendio_sandbox_management' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-addendio-sandbox-management.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_addendio_sandbox_management() {

	$plugin = new Addendio_Sandbox_Management();
	$plugin->run();

}
run_addendio_sandbox_management();
