<?php

class BP_Portfolio_Last_User_Projects_Widget extends WP_Widget {
	function bp_portfolio_last_user_projects_widget() {
		parent::WP_Widget( false, $name = __( 'Last user projects', 'bp-portfolio' ) );
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
                bp_portfolio_show_last_user_projects($instance['max'], $instance['user']);
		echo $after_widget; 				
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['max'] = absint( $new_instance['max'] );
                $instance['example'] = strip_tags( $new_instance['example'] );
                if(isset($new_instance['user-displayname']))
                    $instance['user'] = 0;
                else
                    $instance['user'] = absint( $new_instance['user'] );
		
                return $instance;
	}
        
	function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array( 'title'=>__('Last user projects','bp-portfolio'),'max' => 5, 'user' => bp_loggedin_user_id() ) );
			$title = strip_tags( $instance['title'] );
                        $user = absint( $instance['user'] );
			$max = absint( $instance['max'] );
                        
			?>
			<p>
				<label for='bp-portfolio-last-user-projects-widget-title'><?php _e( 'Title:' , 'bp-portfolio'); ?>
					<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" class="widefat" value="<?php echo esc_attr( $title ); ?>" />
				</label>
			</p>
                        <p>
                            <label for='bp-portfolio-last-user-projects-widget-user'>
                                <?php _e( 'User:' , 'bp-portfolio'); ?>
                                <br />
                                <select id="<?php echo $this->get_field_id( 'user' ); ?>" class="bp-portfolio-last-user-projects-widget-select" name="<?php echo $this->get_field_name( 'user' ); ?>" <?php echo ($user == 0) ? 'disabled="disabled"' : ''; ?> >
                                    <?php
                                    $users = get_users();
                                    foreach($users as $u) :?>
                                        <option value="<?php echo $u->ID ?>" <?php echo ($u->ID == $user) ? 'selected="selected"' : ''; ?>><?php echo $u->display_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="checkbox" id="bp-portfolio-last-user-projects-widget-checkbox" name="<?php echo $this->get_field_name( 'user-displayname' ); ?>" <?php echo ($user == 0) ? 'checked="checked"' : ''; ?> value="0"> <?php _e('Display user', 'bp-portfolio'); ?>
                            </label>
                        </p>
			<p>
                            <label for='bp-portfolio-last-user-projects-widget-max'><?php _e( 'Number of projects to show:', 'bp-portfolio' ); ?>
                                    <input class="widefat" id="<?php echo $this->get_field_id( 'max' ); ?>" name="<?php echo $this->get_field_name( 'max' ); ?>" type="text" value="<?php echo esc_attr( $max ); ?>" style="width: 30%" />
                            </label>
                        </p>
			
	<?php
	}	
}


add_action( 'widgets_init', 'bp_portfolio_register_last_user_projects_widgets' );
function bp_portfolio_register_last_user_projects_widgets() {
	register_widget( 'BP_Portfolio_Last_User_Projects_Widget' );
}

?>