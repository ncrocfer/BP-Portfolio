<?php

/**
 * Intercepts the ajax request and returns projects
 */
function bp_portfolio_ajax_index_pagination() {    
    bp_core_load_template( apply_filters( 'portfolio_directory_template', 'default/projects-loop' ) );
}
add_action( 'wp_ajax_projects_filter', 'bp_portfolio_ajax_index_pagination' );

?>