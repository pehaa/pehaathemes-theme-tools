<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://github.com/pehaa/pehaathemes-theme-tools/
 * @since      1.0.0
 *
 * @package    PeHaaThemes_Theme_Tools
 * @subpackage PeHaaThemes_Theme_Tools/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    PeHaaThemes_Theme_Tools
 * @subpackage PeHaaThemes_Theme_Tools/public
 * @author     PeHaa THEMES <info@pehaa.com>
 */
class PeHaaThemes_Theme_Tools_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * Load public css for themes by other authors.
		 *
		 */

		if ( class_exists( 'PeHaaThemes_Theme_Start') ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pehaathemes-theme-tools-public.css', array(), $this->version, 'all' );

	}

}