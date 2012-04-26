<?php

/**
 * Load the appropriate template file
 */
function bp_portfolio_load_template_filter( $found_template, $templates ) {
	global $bp;

	/**
	 * Only filter the template location when we're on the portfolio component pages.
	 */
	if ( $bp->current_component != $bp->portfolio->slug )
		return $found_template;

	foreach ( (array) $templates as $template ) {
		if ( file_exists( STYLESHEETPATH . '/' . $template ) )
			$filtered_templates[] = STYLESHEETPATH . '/' . $template;
		else
			$filtered_templates[] = BP_PORTFOLIO_PLUGIN_DIR . '/templates/' . $template;
	}

	$found_template = $filtered_templates[0];

	return apply_filters( 'bp_portfolio_load_template_filter', $found_template );
}
add_filter( 'bp_located_template', 'bp_portfolio_load_template_filter', 10, 2 );



/**
 * 
 * Make this process :
 * - save a new item
 * - sends an notification to the user
 * - records an activity stream item
 * 
 */
function bp_portfolio_save_item( $args = array() ) {
	global $bp;

        $defaults = array (
                'id'            => null,
		'author_id'     => $bp->loggedin_user->id,
		'title'         => null,
		'description'   => null,
		'url'           => null,
                'screenshot'    => null
	);
        
        $db_args = wp_parse_args( $args, $defaults );
        
        $portfolio = new BP_Portfolio_Item( $db_args );
        
        // Records an activity
        if($portfolio->save()) {
            /* Now record the new 'new_high_five' activity item */
            $user_link = bp_core_get_userlink( $bp->loggedin_user->id );

            bp_portfolio_record_activity( array(
                    'type' => 'new-portfolio',
                    'action' => apply_filters( 'bp_new_portfolio_activity_action', sprintf( __( '%s created a new project in his portfolio', 'bp-portfolio' ), $user_link ), $user_link ),
                    'item_id' => $bp->loggedin_user->id,
            ) );
            return true;
        }
	
	return false;
}


/**
 * Delete a project
 */
function bp_portfolio_delete_item( $project_id ) {
	global $bp;
        
        $project = new BP_Portfolio_Item( array( 'id' => $project_id, 'author_id' => bp_loggedin_user_id() ) );
        $project->get();

        if(($project->query->post->post_author == bp_loggedin_user_id()) AND ($project->query->post->post_type == 'portfolio')) {
            
            // post_parent is the ID of thumbnail
            $thumbnail_id = $project->query->post->post_parent;
            
            // So delete this project
            if($project->delete()) {
                if($thumbnail_id != 0)
                    wp_delete_attachment( $thumbnail_id );
                return true;
            }
        }

        return false;
}


/**
 * Add support of post thumbnails
 */
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
}

/**
 * Register a new image size  
 */
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'portfolio-thumb', 250, 170, true );
}


/**
 * Handle file uploads
 * @see http://www.nicolaskuttler.com/code/simple-upload-field-for-wordpress-pluginsthemes/
 */
function fileupload_process( $file ) { 

  if (is_array($file)) {

      // look only for uploded files
      if ($file['error'] == 0) {

        $filetmp = $file['tmp_name'];

        //clean filename and extract extension
        $filename = $file['name'];

        // get file info
        // @fixme: wp checks the file extension....
        $filetype = wp_check_filetype( basename( $filename ), null );
        $filetitle = preg_replace('/\.[^.]+$/', '', basename( $filename ) );
        $filename = $filetitle . '.' . $filetype['ext'];
        $upload_dir = wp_upload_dir();

        /**
         * Check if the filename already exist in the directory and rename the
         * file if necessary
         */
        $i = 0;
        while ( file_exists( $upload_dir['path'] .'/' . $filename ) ) {
          $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
          $i++;
        }
        $filedest = $upload_dir['path'] . '/' . $filename;

        /**
         * Check write permissions
         */
        if ( !is_writeable( $upload_dir['path'] ) ) {
          $this->msg_e('Unable to write to directory %s. Is this directory writable by the server?');
          return;
        }

        /**
         * Save temporary file to uploads dir
         */
        if ( !@move_uploaded_file($filetmp, $filedest) ){
          $this->msg_e("Error, the file $filetmp could not moved to : $filedest ");
          continue;
        }

        $attachment = array(
          'post_mime_type' => $filetype['type'],
          'post_title' => $filetitle,
          'post_content' => '',
          'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $filedest );
        require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filedest );
        wp_update_attachment_metadata( $attach_id,  $attach_data );
        
        return $attach_id;
      }
    }
}


?>
