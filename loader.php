<?php
/*
Plugin Name: BuddyPress Portfolio
Plugin URI: http://www.shatter.fr/bp-portfolio/
Description: This plugin allows each user to create his portfolio on your website
Version: 1.0
Requires at least: WP 3.3.1, BuddyPress 1.5
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: Nicolas Crocfer (shatter)
Author URI: http://www.shatter.fr
*/


/**
 * Useful constants definitions
 */
define( 'BP_PORTFOLIO_IS_INSTALLED',        1 );
define( 'BP_PORTFOLIO_VERSION',             '1.0' );
define( 'BP_PORTFOLIO_PLUGIN_DIR',          dirname( __FILE__ ) );
define( 'BP_PORTFOLIO_PLUGIN_URL',          plugins_url() . '/bp-portfolio');


/* Only load the portfolio component if BuddyPress is loaded and initialized. */
function bp_portfolio_init() {
	if ( version_compare( BP_VERSION, '1.3', '>' ) )
		require( dirname( __FILE__ ) . '/includes/bp-portfolio-loader.php' );
}
add_action( 'bp_include', 'bp_portfolio_init' );


/* Install the tables on activation */
function bp_portfolio_activate() {
    require( dirname( __FILE__ ) . '/includes/bp-portfolio-install.php' );
    bp_portfolio_default_options();
}
register_activation_hook( __FILE__, 'bp_portfolio_activate' );


?>
