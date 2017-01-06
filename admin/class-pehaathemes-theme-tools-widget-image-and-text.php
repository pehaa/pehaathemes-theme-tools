<?php
/**
 * Text widget class
 *
 */
class PeHaaThemes_Theme_Tools_Widget_Image_and_Text extends PeHaaThemes_Theme_Tools_Widget {

	public function __construct() {
		$widget_ops = array( 
			'classname' => 'widget_text pehaathemes_theme_tools_widget_image_and_text', 
			'description' => esc_html__( 'Arbitrary text or HTML starting with a rounded image. It works great for some short introductory about text.', 'pehaathemes-theme-tools' ) 
			);
		$control_ops = array( 'width' => 400, 'height' => 350 );

		$title_starts = class_exists( 'PeHaaThemes_Theme_Start' ) ? PeHaaThemes_Theme_Start::$theme_name : 'PeHaa THEMES';

		parent::__construct( 'pehaathemes_theme_tools_widget_image_and_text', sprintf( esc_html__( '%s - About Widget', 'pehaathemes-theme-tools' ), $title_starts ), $widget_ops, $control_ops );

		add_action( 'admin_enqueue_scripts', array( $this, 'upload_scripts' ) );
	}

	public function upload_scripts() {

		$screen = get_current_screen();

		if ( NULL === $screen ) {
			return;
		}
		if ( ! in_array( $screen->id, array( 'widgets', 'customize' ) ) ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_script( 'pehaathemes-theme-tools-media-widget-scipt',  plugin_dir_url( __FILE__ ) . 'js/pehaathemes-theme-tools-upload-media.min.js', array( 'jquery', 'media-upload' ) );
		wp_enqueue_style( 'pehaathemes-theme-tools-media-widget-style', plugin_dir_url( __FILE__ ) . 'css/pehaathemes-theme-tools-widgets.css' );
	}

	public function widget( $args, $instance ) {

		$img_dimension = 144;

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		$text = apply_filters( 'pehaathemes_theme_tools_widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$img_id = apply_filters( 'pehaathemes_theme_tools_widget_img', empty( $instance['img_id'] ) ? '' : $instance['img_id'], $instance );
		$style = apply_filters( 'pehaathemes_theme_tools_widget_style', empty( $instance['style'] ) ? '' : $instance['style'], $instance );
		
		$this->pehaathemes_theme_tools_before_widget( $args );
		$this->pehaathemes_theme_tools_widget_title( $title, $args ); 

		if ( $img_id && wp_get_attachment_image( $img_id ) ) {
			if ( function_exists( 'pehaathemes_get_att_img' ) ) {
				$image = pehaathemes_get_att_img( $img_id, array( $img_dimension, $img_dimension ), false, array( 'width' => $img_dimension, 'height' => $img_dimension, 'class' => 'pht-rounded' ) );
			} else {
				$image = wp_get_attachment_image( $img_id );
			}
			 
			if ( $image ) {
				printf( '<p class="pht-text-center">%s</p>', $image );
			}
		} 

		$class = $style ? 'textwidget pht-spacedletters pht-text-center' : 'textwidget'; ?>
		
		<div class="<?php echo esc_attr( $class ); ?>"><?php echo wpautop( $text ); ?></div>

		<?php $this->pehaathemes_theme_tools_after_widget( $args );
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] =  $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed
		}
			
		$instance['style'] = ! empty( $new_instance['style'] );
		$instance['img_id'] = (int) $new_instance['img_id'];
		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'img_id' => '' ) );
		$title = strip_tags( $instance['title'] );
		$text = esc_textarea( $instance['text'] );
		$img_id = (int) $instance['img_id'];
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title:', 'pehaathemes-theme-tools' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('text') ); ?>"><?php echo wp_kses_post( $text ); ?></textarea>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" type="checkbox" <?php checked( isset($instance['style'] ) ? $instance['style'] : 0); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Center and increase the letter spacing.', 'pehaathemes-theme-tools' ); ?></label>
		</p>
		<p class="pht-clear">
			<a href="#" class="js-pht-upload-thumbnail pht-upload-thumbnail button button-primary"><?php esc_html_e( 'Set Image', 'pehaathemes-theme-tools' ); ?></a>
			<input type="hidden" id="<?php echo esc_attr( $this->get_field_name( 'img_id' ) ); ?>" class="pht-new-media-image widefat code edit-menu-item-megamenu-thumbnail" name="<?php echo esc_attr( $this->get_field_name( 'img_id' ) ); ?>" value="<?php echo esc_attr( $img_id ); ?>" />
			<?php 
				if ( $img_id && wp_get_attachment_image( $img_id ) ) { 
					echo wp_get_attachment_image( $img_id, 'thumbnail', '', array( 'class' => 'pht-megamenu-img-placeholder' ) ); 
				} else { ?>
					<img class="pht-megamenu-img-placeholder" src="">
				<?php }
			?>
			<a href="#" class="js-pht-remove-thumbnail pht-remove-thumbnail"><?php esc_html_e( 'Remove Image', 'pehaathemes-theme-tools' ); ?></a>			
		</p>
<?php
	}
}