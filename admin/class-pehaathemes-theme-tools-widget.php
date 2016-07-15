<?php
/**
 *
 * @package   Coollab
 * @author    PeHaa THEMES <info@pehaa.com>
 */

if ( ! class_exists( 'PeHaaThemes_Theme_Tools_Widget' ) ) :

class PeHaaThemes_Theme_Tools_Widget extends WP_Widget {

	protected function pehaathemes_theme_tools_before_widget( $args ) {

		if ( !isset( $args['before_widget'] ) ) {
			return;
		}

		echo $args['before_widget'];

	}

	protected function pehaathemes_theme_tools_widget_title( $title, $args ) {

		if ( $title ) { 
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; 
		}
		
	}

	protected function pehaathemes_theme_tools_after_widget( $args ) {

		if ( !isset( $args['after_widget'] ) ) {
			return;
		}

		echo $args['after_widget'];
		
	}
}

endif;