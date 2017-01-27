<?php
/**
 * Recent_Posts with thumbnails widget class
 *
 */
class PeHaaThemes_Theme_Tools_Widget_Recent_Posts extends PeHaaThemes_Theme_Tools_Widget {

	public function __construct() {
		$widget_ops = array( 
			'classname' => 'widget_recent_entries pehaathemes_theme_tools_widget_recent_posts', 
			'description' => esc_html__( 'Most Recent Posts with Thumbnails.', 'pehaathemes-theme-tools' ) 
		);

		$title_starts = class_exists( 'PeHaaThemes_Theme_Start' ) ? PeHaaThemes_Theme_Start::$theme_name : 'PeHaa THEMES';

		parent::__construct( 'pehaathemes_theme_tools_widget_recent_posts', sprintf( esc_html__( '%s - Recent Entries with Thumbnails', 'pehaathemes-theme-tools' ), $title_starts ), $widget_ops );
		$this->alt_option_name = 'pehaathemes_theme_tools_widget_recent_posts';

	}

	public function widget( $args, $instance ) {

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Posts', 'pehaathemes-theme-tools' );

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$post_type = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : 'post';

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
			
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$show_subtitle = isset( $instance['show_subtitle'] ) ? $instance['show_subtitle'] : false;

		$r_args = apply_filters( 'widget_posts_args', array(
			'post_type' => $post_type,
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) );

		if ( 'pht_event' === $post_type && class_exists( 'PeHaa_Themes_Events_Public' ) ) {
			$r_args = wp_parse_args( $r_args, PeHaa_Themes_Events_Public::pht_se_modify_events_query( 'upcoming' ) );
		}

		$r = new WP_Query( $r_args );

		if ( $r->have_posts() ) :
			$this->pehaathemes_theme_tools_before_widget( $args );
			$this->pehaathemes_theme_tools_widget_title( $title, $args ); ?>
			<ul>
				<?php 
				while ( $r->have_posts() ) : $r->the_post(); ?>
					<li class="media o-media media--small o-media--small pht-widget_recent_entries__entry">
						<?php 
						if ( has_post_thumbnail( get_the_ID() ) ) { 
							if ( function_exists( 'pehaathemes_get_post_thumb' ) ) { ?>
								<a class="media__img o-media__img" href="<?php the_permalink(); ?>" rel="bookmark"><?php echo pehaathemes_get_post_thumb( get_the_ID(), array( 144, 96 ), false, array( 'class' => 'pht-widget_recent_entries__img pht-mb0' ) ); ?></a>
							<?php } else { ?>
								<a class="media__img o-media__img" href="<?php the_permalink(); ?>" rel="bookmark"><?php echo get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'class' => 'pht-widget_recent_entries__img pht-mb0' ) ); ?></a>
							<?php } ?>
							
						<?php } ?>
						<div class="media__body o-media__body">
							<?php if ( $show_date ) { 
								if ( 'pht_event' === $post_type && class_exists( 'PeHaa_Themes_Events_Public' ) ) { ?>
									<div class="post-date <?php echo esc_attr( apply_filters( 'pht_theme_tools_recent_posts_widget_post_date_class', 'pht-micro pht-italic')); ?>" rel="bookmark"><?php echo get_post_meta( get_the_ID(), 'pht_events_startdate', true ); ?></div>
								<?php } else { ?>
									<div class="post-date <?php echo esc_attr( apply_filters( 'pht_theme_tools_widget_post_date_class', 'pht-micro pht-italic')); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo get_the_date(); ?></a></div>
								<?php } 
							} ?>
							<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( apply_filters( 'pht_theme_tools__recent_posts_widget_post_link_class', 'pht-secondfont pht-truncate u-truncate' ) ); ?>" rel="bookmark"><?php get_the_title() ? the_title() : the_ID(); ?></a>	
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php $this->pehaathemes_theme_tools_after_widget( $args );

			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

		endif;

		ob_end_flush();
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_type']	= isset( $new_instance['post_type'] ) ? esc_attr( $new_instance['post_type'] ) : 'post';
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;

		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$post_type	= isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : 'post';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false; ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'pehaathemes-theme-tools' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php if ( class_exists( 'PeHaaThemes_Theme_Start' ) ) { ?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php esc_html_e( 'Choose the Post Type to display:', 'pehaathemes-theme-tools' ); ?></label> 
				<select name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" class="widefat">
					<?php foreach ( PeHaaThemes_Theme_Start::$single_items as $post_slug ) {
					printf ( '<option id="%1$s" value="%2$s" %3$s>%4$s</option>',
						esc_attr( $post_slug ),
						esc_attr( $post_slug ),
						$post_type === $post_slug ? ' selected="selected"' : '',
						esc_html( $post_slug )
					); } ?>
				</select>
				<?php if ( class_exists( 'PeHaa_Themes_Events_Public' ) ) {
					echo '<small>' . esc_html__( 'If you chose the pht_event post types, the upcoming events will be listed, the post date will be replaced by the event start date.', 'pehaathemes-theme-tools' ) . '</small>';
				} ?>
			</p>
		<?php } ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'pehaathemes-theme-tools' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Display post date?', 'pehaathemes-theme-tools' ); ?></label>
		</p>
	<?php
	}
}