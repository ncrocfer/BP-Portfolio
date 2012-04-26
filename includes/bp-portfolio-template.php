<?php


function bp_portfolio_has_items( $args = '' ) {
	global $bp, $items_template;

	// This keeps us from firing the query more than once
	if ( empty( $items_template ) ) {
            
		$default = array(
                    'id' => 0,
                    'author_id' => 0,
                    'title' => null,
                    'description' => null,
                    'url' => null,
                    'created_at' => date( 'Y-m-d H:i:s' ),
                    'updated_at' => date( 'Y-m-d H:i:s' ),
                    'tags' => array(),
                    'per_page'	=> 10,
                    'paged'	=> 1
                );
                
		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );

		$items_template = new BP_Portfolio_Item();
		$items_template->get( $r );
	}

	return $items_template->have_posts();
}

function bp_portfolio_the_item() {
	global $items_template;
	return $items_template->query->the_post();
}

/**
 * Get the title of the project 
 */
function bp_portfolio_item_title() {
	echo bp_portfolio_get_item_title();
}

	function bp_portfolio_get_item_title() {
		global $items_template;
		echo apply_filters( 'bp_portfolio_get_item_title', $items_template->query->post->post_title );
	}
        
        
/**
 * Get the permalink of the project 
 */
function bp_portfolio_item_permalink() {
	echo bp_portfolio_get_item_permalink();
}

	function bp_portfolio_get_item_permalink() {
		global $items_template;
		echo apply_filters( 'bp_portfolio_get_item_permalink', get_permalink( get_the_ID() ) );
	}

/**
 * Get the title of the project 
 */
function bp_portfolio_item_description() {
	echo bp_portfolio_get_item_description();
}

	function bp_portfolio_get_item_description() {
		global $items_template;
		echo apply_filters( 'bp_portfolio_get_item_description', $items_template->query->post->post_content );
	}

        
/**
 * Get the url of the project 
 */
function bp_portfolio_item_url() {
	echo bp_portfolio_get_item_url();
}

        /**
        * Return the url of the project 
        */
	function bp_portfolio_get_item_url() {
		return apply_filters( 'bp_portfolio_get_item_url', get_post_meta(get_the_ID(), 'bp_portfolio_url', true) );
	}


/**
 * Get the thumbnail of the project 
 */
function bp_portfolio_item_thumbnail() {
    echo bp_portfolio_get_item_thumbnail();
}

        /**
        * Return the thumbnail of the project 
        */
        function bp_portfolio_get_item_thumbnail() {
            global $items_template;
            $thumbnail = wp_get_attachment_image_src($items_template->query->post->post_parent, 'portfolio-thumb');
            
            if($thumbnail != 0)
                return apply_filters( 'bp_portfolio_get_item_thumbnail', $thumbnail[0]);
            else
                return apply_filters( 'bp_portfolio_get_item_thumbnail', BP_PORTFOLIO_PLUGIN_URL . '/templates/default/img/default.png');
        }



/**
 * Is this page part of the Portfolio component?
 */
function bp_is_portfolio_component() {
	$is_portfolio_component = bp_is_current_component( 'portfolio' );

	return apply_filters( 'bp_is_portfolio_component', $is_portfolio_component );
}


/**
 * Echo the component's slug
 */
function bp_portfolio_slug() {
	echo bp_get_portfolio_slug();
}
	/**
	 * Return the component's slug	 
	 */
	function bp_get_portfolio_slug() {
		global $bp;
                
		$portfolio_slug = isset( $bp->portfolio->slug ) ? $bp->portfolio->slug : '';

		return apply_filters( 'bp_get_portfolio_slug', $portfolio_slug );
	}

        
        
/**
 * Echo the component's root slug
 */
function bp_portfolio_root_slug() {
	echo bp_get_portfolio_root_slug();
}
	/**
	 * Return the component's root slug
	 */
	function bp_get_portfolio_root_slug() {
		global $bp;

		$portfolio_root_slug = isset( $bp->portfolio->root_slug ) ? $bp->portfolio->root_slug : '';

		return apply_filters( 'bp_get_portfolio_root_slug', $portfolio_root_slug );
	}

        

/**
 * Echoes the form action for Portfolio HTML forms
 */
function bp_portfolio_form_action( $action ) {
	echo bp_get_portfolio_form_action( $action );
}
	/**
	 * Returns the form action for Portfolio HTML forms
	 */
	function bp_get_portfolio_form_action( $action ) {
		return apply_filters( 'bp_get_portfolio_form_action', trailingslashit( bp_loggedin_user_domain() . bp_get_portfolio_slug() . '/' . $action . '/' . bp_action_variable( 0 ) ) );
	}
    

        
/**
 * Echo "Viewing x of y pages"
 */
function bp_portfolio_pagination_count() {
	echo bp_portfolio_get_pagination_count();
}
	/**
	 * Return "Viewing x of y pages"
	 */
	function bp_portfolio_get_pagination_count() {
		global $items_template;
		$pagination_count = sprintf( __( 'Viewing page %1$s of %2$s', 'bp-portfolio' ), $items_template->query->query_vars['paged'], $items_template->query->max_num_pages );

		return apply_filters( 'bp_portfolio_get_pagination_count', $pagination_count );
	}
        
        
/**
 * Echo pagination links
 */
function bp_portfolio_item_pagination() {
	echo bp_portfolio_get_item_pagination();
}
	/**
	 * return pagination links
	 */
	function bp_portfolio_get_item_pagination() {
		global $items_template;
		return apply_filters( 'bp_portfolio_get_item_pagination', $items_template->pag_links );
	}
        
        
/**
 * Echo the total of all projects
 */
function bp_portfolio_total_projects_count() {
	echo bp_portfolio_get_total_projects_count();
}
	/**
	 * Return the total of all projects
	 */
	function bp_portfolio_get_total_projects_count() {
		$projects = new BP_Portfolio_Item();
		$projects->get();

		return apply_filters( 'bp_portfolio_get_total_projects_count', $projects->query->found_posts, $projects );
	}
    
        
/**
 *Echo the total of projects for a particular user
 */
function bp_portfolio_user_projects_count( $user_id ) {
    echo bp_portfolio_user_projects_count( $user_id );
}
        /**
        * Return the total of projects for a particular user
        */
        function bp_portfolio_get_user_projects_count( $user_id ) {
            
            if(isset($user_id) && is_int($user_id)) {
                $projects = new BP_Portfolio_Item();
                $projects->get(array('author_id' => $user_id));

                return apply_filters('bp_portfolio_get_user_projects_count', $projects->query->found_posts, $projects);
            } else {
                return 0;
            }
        }


?>
