<?php

/**
 * Encode HTML tags for security reasons
 */
add_filter( 'bp_portfolio_data_title_before_save', 'esc_attr', 1 );
add_filter( 'bp_portfolio_data_description_before_save', 'esc_attr', 1 );
add_filter( 'bp_portfolio_data_url_before_save', 'esc_attr', 1 );


/**
 * Inserts newlines for the description field 
 */
add_filter( 'bp_portfolio_get_item_description', 'nl2br', 1 );

?>
