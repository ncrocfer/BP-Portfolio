<?php

/**
 * Save a new item
 */
function bp_portfolio_item_save() {

	if ( bp_is_portfolio_component() AND isset($_GET['new']) ) {

            if ( bp_portfolio_save_item() )
                    bp_core_add_message( __( 'Item added !', 'bp-portfolio' ) );
            else
                    bp_core_add_message( __( 'An error occured', 'bp-portfolio' ), 'error' );

            bp_core_redirect( bp_get_portfolio_root_slug() );
	}
}
add_action( 'bp_actions', 'bp_portfolio_item_save' );


?>
