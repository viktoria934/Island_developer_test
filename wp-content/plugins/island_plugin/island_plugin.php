<?php

/**
 * Test API to Wordpress
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.1
 * @package           Island_API
 *
 * @wordpress-plugin
 * Plugin Name:       Island API
 * Description:       Island API
 * Version:           1.0.0
 * Author:            Innowise
 * Text Domain:       island_plugin
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

function activate_island_api_wp() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-island-api-activator.php';
    Island_Wp_Activator::activate();
}

function deactivate_island_api_wp() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-island-api-deactivation.php';
    Island_Wp_Deactivator::deactivate();
}

require plugin_dir_path( __FILE__ ) . 'includes/class-island-api.php';
register_activation_hook( __FILE__, 'activate_island_api_wp' );
register_deactivation_hook( __FILE__, 'deactivate_island_api_wp' );

function run_island_api_wp() {
    new Island_Api_Wp();
}
run_island_api_wp();