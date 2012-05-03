<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;




class BP_Portfolio_Component extends BP_Component {
    
    /**
     * Initialize the component
     */
    public function __construct() {
        global $bp;
        
        parent::start(
                'portfolio', __('Portfolio', 'bp-portfolio'), BP_PORTFOLIO_PLUGIN_DIR
        );
        
        $this->includes();
        $bp->active_components[$this->id] = '1';
        // add_action('init', array(&$this, 'register_post_types'));
    }
    
    
    
    /**
     * Include component's files 
     */
    public function includes() {
        $includes = array(
            'includes/bp-portfolio-actions.php',
            'includes/bp-portfolio-screens.php',
            'includes/bp-portfolio-filters.php',
            'includes/bp-portfolio-classes.php',
            'includes/bp-portfolio-activity.php',
            'includes/bp-portfolio-functions.php',
            'includes/bp-portfolio-widgets.php',
            'includes/bp-portfolio-cssjs.php',
            'includes/bp-portfolio-ajax.php',
            'includes/bp-portfolio-template.php'
        );
        
        parent::includes($includes);
        
        // Load the admin required file
        if (is_admin() || is_network_admin()) {
            include( BP_PORTFOLIO_PLUGIN_DIR . '/includes/bp-portfolio-admin.php' );
        }
    }
    
    
    
    /**
     * Set up plugin's globals 
     */
    function setup_globals() {
        global $bp;
        
        if (!defined('BP_PORTFOLIO_SLUG'))
            define('BP_PORTFOLIO_SLUG', $this->id);
        
        if(!defined('BP_PORTFOLIO_DESC_MAX_SIZE'))
            define('BP_PORTFOLIO_DESC_MAX_SIZE', get_option('bp_portfolio_desc_max_size'));
        
        if(!defined('BP_PORTFOLIO_TEMPLATE'))
            define('BP_PORTFOLIO_TEMPLATE', get_option('bp_portfolio_template'));
        
        
        $global_tables = array(
            'table_items_name' => $bp->table_prefix . BP_PORTFOLIO_ITEMS_TABLE
        );
        
        $globals = array(
            'slug' => BP_PORTFOLIO_SLUG,
            'root_slug' => isset($bp->pages->{$this->id}->slug) ? $bp->pages->{$this->id}->slug : BP_PORTFOLIO_SLUG,
            'has_directory' => true,
            'notification_callback' => 'bp_portfolio_format_notifications',
            'search_string' => __('Search projects...', 'bp-portfolio'),
            'global_tables' => $global_tables
        );
        
        parent::setup_globals($globals);
    }
    
    
    /**
     * Set the component's navigation 
     */
    public function setup_nav() {
        
        // Main navigation
        $main_nav = array(
            'name' => sprintf( __( 'Projects <span>%s</span>', 'bp-portfolio' ), bp_portfolio_get_user_projects_count(bp_displayed_user_id() ) ),
            'slug' => bp_get_portfolio_slug(),
            'position' => 80,
            'screen_function' => 'bp_portfolio_screen_personal',
            'default_subnav_slug' => 'personal'
        );
        
        $portfolio_link = trailingslashit(bp_loggedin_user_domain() . bp_get_portfolio_slug());

        // Add a few subnav items under the main Portfolio tab
        $sub_nav[] = array(
            'name' => __('Personal', 'bp-portfolio'),
            'slug' => 'personal',
            'parent_url' => $portfolio_link,
            'parent_slug' => bp_get_portfolio_slug(),
            'screen_function' => 'bp_portfolio_screen_personal',
            'position' => 10
        );
        
        
        if(bp_displayed_user_id() == bp_loggedin_user_id() ) {
            // Add a few subnav items under the main Portfolio tab
            $sub_nav[] = array(
                'name' => __('Add', 'bp-portfolio'),
                'slug' => 'add',
                'parent_url' => $portfolio_link,
                'parent_slug' => bp_get_portfolio_slug(),
                'screen_function' => 'bp_portfolio_screen_add',
                'position' => 20
            );
        }
        
        parent::setup_nav($main_nav, $sub_nav);
    }
    
    
    /**
     * Register the new post type "portfolio"
     */
    function register_post_types() {
        $labels = array(
            'name' => __('Projects', 'bp-portfolio'),
            'singular' => __('Project', 'bp-portfolio')
        );

        // Set up the argument array for register_post_type()
        $args = array(
            'label' => __('Projects', 'bp-portfolio'),
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'supports' => array('title'),
            'rewrite' => TRUE,
            'rewrite' => array(
                'slug' => 'project',
                'with_front' => FALSE,
            ),
        );

        register_post_type('portfolio', $args);
        parent::register_post_types();
    }
    
}



/**
 * Load component into the $bp global
 */
function bp_portfolio_load_core_component() {
    global $bp;

    $bp->portfolio = new BP_Portfolio_Component;
}

add_action('bp_loaded', 'bp_portfolio_load_core_component');

?>