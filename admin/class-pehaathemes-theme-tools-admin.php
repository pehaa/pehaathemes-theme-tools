<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://github.com/pehaa/pehaathemes-theme-tools/
 * @since      1.0.0
 *
 * @package    PeHaaThemes_Theme_Tools
 * @subpackage PeHaaThemes_Theme_Tools/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    PeHaaThemes_Theme_Tools
 * @subpackage PeHaaThemes_Theme_Tools/admin
 * @author     PeHaa THEMES <info@pehaa.com>
 */
class PeHaaThemes_Theme_Tools_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function register_widgets() {

		require_once 'class-pehaathemes-theme-tools-widget.php';

		if ( class_exists( 'PeHaaThemes_Theme_Tools_Widget' ) ) {
			require_once 'class-pehaathemes-theme-tools-widget-recent-posts.php';
			require_once 'class-pehaathemes-theme-tools-widget-image-and-text.php';
			register_widget( 'PeHaaThemes_Theme_Tools_Widget_Recent_Posts' );
			register_widget( 'PeHaaThemes_Theme_Tools_Widget_Image_and_Text' );
		}	
	}

	public static function require_importer() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/pehaathemes-wp-importer/pehaathemes-wp-importer.php';
	}

}