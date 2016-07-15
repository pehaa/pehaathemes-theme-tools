<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://github.com/pehaa/pehaathemes-theme-tools/
 * @since      1.0.0
 *
 * @package    PeHaaThemes_Theme_Tools
 * @subpackage PeHaaThemes_Theme_Tools/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    PeHaaThemes_Theme_Tools
 * @subpackage PeHaaThemes_Theme_Tools/includes
 * @author     PeHaa THEMES <info@pehaa.com>
 */
class PeHaaThemes_Theme_Tools_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'pehaathemes-theme-tools',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
