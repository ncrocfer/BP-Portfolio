<?php

/**
 * Delte an item 
 */
function bp_portfolio_item_delete() {
    
    if(bp_is_portfolio_component() AND bp_is_current_action( 'delete' ) AND (bp_displayed_user_id() == bp_loggedin_user_id()) ) {
        if($project_id = bp_action_variable() AND wp_verify_nonce($_REQUEST['_wpnonce'], 'delete_project')) {
            
                if(bp_portfolio_delete_item( $project_id ) )
                    bp_core_add_message( __( 'Project deleted !', 'bp-portfolio' ) );
                else
                    bp_core_add_message( __( 'An error occured, please try again.', 'bp-portfolio' ), 'error' );
                
        } else {
            bp_core_add_message( __( 'An error occured, please try again.', 'bp-portfolio' ), 'error' );
        }
        bp_core_redirect( bp_core_get_user_domain(bp_loggedin_user_id()) . bp_get_portfolio_slug() );
    }
    
}
add_action( 'bp_actions', 'bp_portfolio_item_delete' );

?>
