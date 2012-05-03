<?php

class BP_Portfolio_Last_Projects_Widget extends WP_Widget {
	function bp_portfolio_last_projects_widget() {
		parent::WP_Widget( false, $name = __( 'Last projects', 'bp-portfolio' ) );
	}

	function widget($args, $instance) {
		global $bp;
		if(!is_user_logged_in())
                    return;//do not show to non logged in user
		extract( $args );
                
                wp_enqueue_style( 'bp-portfolio-css' );
                
		echo $before_widget.
                        $before_title.
                        $instance['title'].
                        $after_title;
                bp_portfolio_show_last_projects($instance['max']);
		echo $after_widget; 				
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['max'] = absint( $new_instance['max'] );

		return $instance;
	}
        
	function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array( 'title'=>__('Last Projects','bp-portfolio'),'max' => 5 ) );
			$title = strip_tags( $instance['title'] );
			$max =absint( $instance['max'] );
			?>
			<p>
				<label for='bp-portfolio-last-projects-widget-title'><?php _e( 'Title:' , 'bp-portfolio'); ?>
					<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" class="widefat" value="<?php echo esc_attr( $title ); ?>" />
				</label>
			</p>
			<p>
                            <label for='bp-portfolio-last-projects-widget-max'><?php _e( 'Number of projects to show:', 'bp-portfolio' ); ?>
                                    <input class="widefat" id="<?php echo $this->get_field_id( 'max' ); ?>" name="<?php echo $this->get_field_name( 'max' ); ?>" type="text" value="<?php echo esc_attr( $max ); ?>" style="width: 30%" />
                            </label>
                        </p>
			
	<?php
	}	
}


add_action( 'widgets_init', 'bp_portfolio_register_last_projects_widgets' );
function bp_portfolio_register_last_projects_widgets() {
	register_widget( 'BP_Portfolio_Last_Projects_Widget' );
}

?>