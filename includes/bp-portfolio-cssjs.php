<?php

/**
 * Add required CSS and JS files
 */
function bp_portfolio_add_css() {
	global $bp;

        wp_register_style( 'bp-portfolio-css', BP_PORTFOLIO_PLUGIN_URL . '/templates/' . BP_PORTFOLIO_TEMPLATE . '/css/general.css' );
        
	if ( ($bp->current_component == $bp->portfolio->slug) OR ($bp->current_component == $bp->activity->slug) ) {
            wp_enqueue_style( 'bp-portfolio-css' );
        }
}
add_action( 'wp_print_styles', 'bp_portfolio_add_css');

?>