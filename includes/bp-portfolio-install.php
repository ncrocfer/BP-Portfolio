<?php

/**
 * Setup the default options in the wp_options table
 */
function bp_portfolio_default_options() {
    
    
    // The default max size for the description of a project
    add_option('bp_portfolio_desc_max_size', '720');
    
    // The default template
    add_option('bp_portfolio_template', 'default');
    
}

?>
