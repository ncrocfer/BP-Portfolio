<?php

/**
 * Load the index page 
 */
function bp_portfolio_directory_setup() {
	if ( bp_is_portfolio_component() && !bp_current_action() && !bp_current_item() ) {
		bp_update_is_directory( true, 'portfolio' );

		do_action( 'bp_portfolio_directory_setup' );

		bp_core_load_template( apply_filters( 'portfolio_directory_template', 'default/index' ) );
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
	bp_core_load_template( apply_filters( 'bp_portfolio_template_screen_one', 'default/personal' ) );
}


/**
 * Sets up and displays the screen output for the sub nav item "portfolio/personal"
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
        check_admin_referer( 'portfolio_add_item' );
        
        if(empty($_POST['title-input']) OR empty($_POST['url-input']) OR empty($_POST['description'])) {
            bp_core_add_message(__('All fields are required', 'bp-portfolio'), 'error');
        } else  {
            // Save the item
            $posts = array( 'author_id' => bp_loggedin_user_id(), 'title' => $_POST['title-input'], 'description' => $_POST['description'], 'url' => $_POST['url-input'] );
            
            // Is that a capture has been sent ?
            if(isset($_FILES['screenshot-input']) AND $_FILES['screenshot-input']['error'] == 0) {
                $posts['screenshot'] = $_FILES['screenshot-input'];
            }
            
            if ( $item = bp_portfolio_save_item( $posts ) ) {
                    bp_core_add_message( __( 'Item has been saved', 'bp-portfolio' ) );
                    bp_core_redirect(bp_core_get_user_domain(bp_loggedin_user_id()) . bp_get_portfolio_slug());
                   
            } else {
                    bp_core_add_message( __( 'There was an error recording the item, please try again', 'bp-portfolio' ), 'error' );
            }
        }
        
    }

    do_action( 'bp_portfolio_add_screen' );

    // Displaying Content
    bp_core_load_template( apply_filters( 'bp_portfolio_template_screen_one', 'default/add' ) );

}
	

?>
