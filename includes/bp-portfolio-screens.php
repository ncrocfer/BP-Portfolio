<?php

/**
 * Load the index page 
 */
function bp_portfolio_directory_setup() {
	if ( bp_is_portfolio_component() && !bp_current_action() && !bp_current_item() ) {
		bp_update_is_directory( true, 'portfolio' );

		do_action( 'bp_portfolio_directory_setup' );

		bp_core_load_template( apply_filters( 'portfolio_directory_template', BP_PORTFOLIO_TEMPLATE . '/index' ) );
	}
}
add_action( 'bp_screens', 'bp_portfolio_directory_setup' );



/**
 * Sets up and displays the screen output for the sub nav item "portfolio/personal"
 */
function bp_portfolio_screen_personal() {
	global $bp;

	do_action( 'bp_portfolio_personal_screen' );

	// Displaying Content
	bp_core_load_template( apply_filters( 'bp_portfolio_template_screen_one', BP_PORTFOLIO_TEMPLATE . '/personal' ) );
}


/**
 * Sets up and displays the screen output for the sub nav item "portfolio/add"
 */
function bp_portfolio_screen_add() {
    global $bp;
    
    if(bp_action_variables()) {
        bp_do_404();
        return;
    }
    
    messages_remove_callback_values();
    
    if( isset($_POST['add']) ) {
        
        // Check the nonce
        if(!wp_verify_nonce($_POST['_wpnonce'], 'project_form_nonce')) {
            bp_core_add_message( __( 'There was an error recording the project, please try again', 'bp-portfolio' ), 'error' );
            bp_core_load_template( apply_filters( 'bp_portfolio_template_personal', BP_PORTFOLIO_TEMPLATE . '/personal' ) );
        }
        
        if(empty($_POST['title-input']) OR empty($_POST['url-input']) OR empty($_POST['description'])) {
            bp_core_add_message(__('All fields are required', 'bp-portfolio'), 'error');
        } else  {
            
            // Check the url
            if (!preg_match("/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/", $_POST['url-input'])) {
                bp_core_add_message(__('Url must be a valid URL.', 'bp-portfolio'), 'error');
                bp_core_load_template( apply_filters( 'bp_portfolio_template_add', BP_PORTFOLIO_TEMPLATE . '/add' ) );
            }
            
            // Check description size
            if(strlen($_POST['description']) > BP_PORTFOLIO_DESC_MAX_SIZE) {
                $_POST['description'] = substr($_POST['description'], 0, BP_PORTFOLIO_DESC_MAX_SIZE);
            }
                
            // Save the item
            $posts = array( 'author_id' => bp_loggedin_user_id(), 'title' => $_POST['title-input'], 'description' => $_POST['description'], 'url' => $_POST['url-input'] );
            
            // Is that a capture has been sent ?
            if(isset($_FILES['screenshot-input']) AND $_FILES['screenshot-input']['error'] == 0) {
                $posts['screenshot'] = $_FILES['screenshot-input'];
            }
            
            if ( $item = bp_portfolio_save_item( $posts ) ) {
                    bp_core_add_message( __( 'Project has been saved', 'bp-portfolio' ) );
                    bp_core_redirect(bp_core_get_user_domain(bp_loggedin_user_id()) . bp_get_portfolio_slug());
                   
            } else {
                    bp_core_add_message( __( 'There was an error recording the project, please try again', 'bp-portfolio' ), 'error' );
            }
        }
        
    }

    do_action( 'bp_portfolio_add_screen' );

    // Displaying Content
    bp_core_load_template( apply_filters( 'bp_portfolio_template_add', BP_PORTFOLIO_TEMPLATE . '/add' ) );

}




/**
 * Sets up and displays the screen output for the sub nav item "portfolio/edit/%d"
 */
function bp_portfolio_screen_edit() {
	
    if(bp_is_portfolio_component() AND bp_is_current_action( 'edit' ) AND (bp_displayed_user_id() == bp_loggedin_user_id()) ) {
        
        if(isset($_POST['edit'])) {
            
            // Check to see if the project belong to the logged_in user
            global $project;
            $project_id = bp_action_variable();
            $project = new BP_Portfolio_Item();
            $project->get(array('id' => $project_id));
            if($project->query->post->post_author != bp_loggedin_user_id()) {
                bp_core_add_message( __( 'There was an error recording the project, please try again', 'bp-portfolio' ), 'error' );
                bp_core_load_template( apply_filters( 'bp_portfolio_template_screen_add', BP_PORTFOLIO_TEMPLATE . '/personal' ) );
            }
            
            // Check the nonce
            if(!wp_verify_nonce($_POST['_wpnonce'], 'project_form_nonce')) {
                bp_core_add_message( __( 'There was an error recording the project, please try again', 'bp-portfolio' ), 'error' );
                bp_core_load_template( apply_filters( 'bp_portfolio_template_screen_add', BP_PORTFOLIO_TEMPLATE . '/personal' ) );
            }
            
            if(empty($_POST['title-input']) OR empty($_POST['url-input']) OR empty($_POST['description'])) {
                
                bp_core_add_message(__('All fields are required', 'bp-portfolio'), 'error');
                $project_id = bp_action_variable();
                global $project;
                $project = new BP_Portfolio_Item();
                $project->get(array('id' => $project_id));
                
            } else  {
                // Edit the post
                $posts = array( 'id' => bp_action_variable(), 'author_id' => bp_loggedin_user_id(), 'title' => $_POST['title-input'], 'description' => $_POST['description'], 'url' => $_POST['url-input'] );
                
                // Is that a capture has been sent ?
                if(isset($_FILES['screenshot-input']) AND $_FILES['screenshot-input']['error'] == 0) {
                    $posts['screenshot'] = $_FILES['screenshot-input'];
                }
                
                if ( $item = bp_portfolio_save_item( $posts ) ) {
                    bp_core_add_message( __( 'Project has been edited', 'bp-portfolio' ) );
                    bp_core_redirect(bp_core_get_user_domain(bp_loggedin_user_id()) . bp_get_portfolio_slug());
                } else {
                        bp_core_add_message( __( 'There was an error recording the item, please try again', 'bp-portfolio' ), 'error' );
                }
                
            }
            
        } else {
            // Create a global $project, so template will know that this is the edit page
            if($project_id = bp_action_variable()) {
                global $project;
                $project_id = bp_action_variable();
                $project = new BP_Portfolio_Item();
                $project->get(array('id' => $project_id));
                
                if($project->query->post->post_author == bp_loggedin_user_id()) {
                    bp_core_load_template( apply_filters( 'bp_portfolio_template_screen_one', BP_PORTFOLIO_TEMPLATE . '/add' ) );
                }
                    
            }
        }
        
    }

}
add_action( 'bp_screens', 'bp_portfolio_screen_edit' );

?>
