<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://github.com/pehaa/pehaathemes-theme-tools/
 * @since             1.0.0
 * @package           PeHaaThemes_Theme_Tools
 *
 * @wordpress-plugin
 * Plugin Name:       PeHaa THEMES Theme Tools
 * Plugin URI:        http://github.com/pehaa/pehaathemes-theme-tools/
 * Description:       A few tools for PeHaa THEMES Premium Themes 
 * Version:           1.0.4
 * Author:            PeHaa THEMES
 * Author URI:        http://wptemplates.pehaa.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pehaathemes-theme-tools
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pehaathemes-theme-tools-activator.php
 */
function activate_pehaathemes_theme_tools() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pehaathemes-theme-tools-activator.php';
	PeHaaThemes_Theme_Tools_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pehaathemes-theme-tools-deactivator.php
 */
function deactivate_pehaathemes_theme_tools() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pehaathemes-theme-tools-deactivator.php';
	PeHaaThemes_Theme_Tools_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pehaathemes_theme_tools' );
register_deactivation_hook( __FILE__, 'deactivate_pehaathemes_theme_tools' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pehaathemes-theme-tools.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pehaathemes_theme_tools() {

	$plugin = new PeHaaThemes_Theme_Tools();
	$plugin->run();

}
run_pehaathemes_theme_tools();

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://wp-plugins.pehaa.com/pehaathemes-theme-tools/metadata.json',
    __FILE__,
    'pehaathemes-theme-tools'
);