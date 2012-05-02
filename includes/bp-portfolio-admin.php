<?php

/**
 * Add the BP-Portfolio submenu under the BuddyPress menu
 */
function bp_portfolio_add_admin_menu() {
	global $bp;

	if ( !is_super_admin() )
		return false;

	$hook = add_submenu_page( 'bp-general-settings', __( 'BP-Portfolio', 'bp-portfolio' ), __( 'BP-Portfolio', 'bp-portfolio' ), 'manage_options', 'bp-portfolio-settings', 'bp_portfolio_admin_screen' );
        
        add_action( "admin_print_styles-$hook", 'bp_core_add_admin_menu_styles' );
}
add_action( bp_core_admin_hook(), 'bp_portfolio_add_admin_menu' );



/*
 * Checks for form submission, saves component settings and outputs admin screen HTML.
 */
function bp_portfolio_admin_screen() {

    /* If the form has been submitted and the admin referrer checks out, save the settings */
    if ( isset( $_POST['submit'] ) && check_admin_referer('portfolio-settings') ) {
            update_option( 'bp_portfolio_template', $_POST['active-template'] );
            update_option( 'bp_portfolio_desc_max_size', $_POST['description-max-size'] );

            $updated = true;
    }
    
    $description_max_size = get_option( 'bp_portfolio_desc_max_size' );
    $active_template = get_option( 'bp_portfolio_template' );
    
?>    
    <div class="wrap">
        
        <?php screen_icon( 'buddypress' ); ?>
        
	<h2><?php _e( 'BP-Portfolio Settings', 'bp-portfolio' ) ?></h2>
	<br />
        
        <?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bp-portfolio' ) . "</p></div>" ?><?php endif; ?>
        
        <form action="<?php echo site_url() . '/wp-admin/admin.php?page=bp-portfolio-settings' ?>" name="portfolio-settings-form" id="portfolio-settings-form" method="post">

                <table class="form-table">
                        <tr valign="top">
                                <th scope="row"><label for="target_uri"><?php _e( 'Active template', 'bp-portfolio' ) ?></label></th>
                                <td>
                                    <select name="active-template" id="active-template">
                                        <?php
                                            $templates_folder_dir = BP_PORTFOLIO_PLUGIN_DIR . '/templates';
                                            if ( $templates_dir = opendir( $templates_folder_dir ) ) {
                                                    while ( false !== ( $template = readdir($templates_dir) ) ) {
                                                            if('.' != $template && '..' != $template) {
                                                                $selected = ($template == $active_template) ? 'selected="selected"' : '';
                                                                echo '<option value="' . esc_attr($template) . '"'. $selected .'>' . esc_attr($template) . '</option>';
                                                            }
                                                    }
                                            }
                                            closedir($templates_dir);
                                        ?>
                                    </select>
                                </td>
                        </tr>
                                <th scope="row"><label for="target_uri"><?php _e( 'Description max size', 'bp-portfolio' ) ?></label></th>
                                <td>
                                        <input name="description-max-size" type="text" id="description-max-size" value="<?php echo esc_attr( $description_max_size ); ?>" size="10" />
                                </td>
                        </tr>
                </table>
                <p class="submit">
                        <input type="submit" name="submit" value="<?php _e( 'Save Settings', 'bp-portfolio' ) ?>"/>
                </p>

                <?php
                /* This is very important, don't leave it out. */
                wp_nonce_field( 'portfolio-settings' );
                ?>
        </form>
        
    </div>


<?php
}

?>
