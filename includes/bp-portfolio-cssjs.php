<?php

/**
 * Add required CSS and JS files
 */
function bp_portfolio_add_css() {
	global $bp;

	if ( $bp->current_component == $bp->portfolio->slug ) {
            wp_register_style( 'bp-portfolio-css', BP_PORTFOLIO_PLUGIN_URL . '/templates/default/css/general.css' );
            wp_enqueue_style( 'bp-portfolio-css' );
        }
}
add_action( 'wp_print_styles', 'bp_portfolio_add_css');

?>