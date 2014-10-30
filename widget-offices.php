<?php
/*
 * This code block uses an Advanced Custom Fields Pro Options page ( not included ) to created a quick WordPress widget. 
 * The widget displays what I deem to be typical Office Location information.
**/

class tlf_locations_widget extends WP_Widget {

	function tlf_locations_widget() {
		// Instantiate the parent object
		parent::WP_WIDGET( false, $name = 'Locations' );
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		
		
		
		if( have_rows( 'offices', 'options' ) ) : ?>
			<div class="offices-widget">
				<?php 
					if( $title ) {
						echo $before_title . $title . $after_title;
					}
				?>
				<ul>
					<?php while( have_rows( 'offices', 'options' ) ) : the_row(); ?>
						<li>
							<h5><?php the_sub_field( 'office_name' ); ?></h5>
							<div class="address">
								<?php the_sub_field( 'address_1' ); ?>
								<?php if( get_sub_field( 'address_2' ) ) the_sub_field( 'address_2' ); ?>
								<?php the_sub_field( 'city' ); ?>, <?php the_sub_field( 'state' ); ?> <?php the_sub_field( 'zip' ); ?>
							</div><!-- .address -->
							
							<div class="numbers">
								<?php
									$phone = get_sub_field( 'phone' );
									$phone_clean = preg_replace("/[^0-9,.]/", "", $phone);
								?>
								<a href="tel:+1<?php echo $phone_clean; ?>" class="phone"><?php echo $phone; ?></a>
								<?php the_sub_field( 'fax' ); ?>
							</div><!-- .numbers -->
						</li>
					<?php endwhile; ?>
				</ul>
			</div><!-- /.offices-widget -->
		<?php endif;		
		echo $after_widget; 
		
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}


	function form( $instance ) {
		$title = esc_attr( $instance['title'] );
		
		?>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		
		<?php
	}
}

add_action( 'widgets_init', create_function('', 'return register_widget("tlf_locations_widget");' ) );
