<?php
global $bp_portfolio_widget_last_user_projects_max;
global $bp_portfolio_widget_last_user_projects_user;

$projects = new BP_Portfolio_Item();
$projects->get(array('posts_per_page' => $bp_portfolio_widget_last_user_projects_max, 'author_id' => $bp_portfolio_widget_last_user_projects_user));

$user_diplayname = ($bp_portfolio_widget_last_user_projects_user != 0) ? bp_core_get_user_displayname($bp_portfolio_widget_last_user_projects_user) : bp_core_get_user_displayname(bp_displayed_user_id());
$user_domain = ($bp_portfolio_widget_last_user_projects_user != 0) ? bp_core_get_user_domain($bp_portfolio_widget_last_user_projects_user) : bp_core_get_user_domain(bp_displayed_user_id());
?>

<?php
foreach($projects->query->posts as $project) :
    
    $attachment = wp_get_attachment_image_src($project->post_parent, 'portfolio-widget-thumb');        
    if($attachment != 0)
        $thumbnail = apply_filters( 'bp_portfolio_get_item_thumbnail', $attachment[0]);
    else
        $thumbnail = apply_filters( 'bp_portfolio_get_item_thumbnail', BP_PORTFOLIO_PLUGIN_URL . '/templates/' . BP_PORTFOLIO_TEMPLATE . '/img/default.png');
?>

    <div class="widget-item-project">
        <div class="widget-item-project-pictures">
            <img src="<?php echo $thumbnail; ?>" width="36px" height="36px" />
        </div>
        <div class="widget-item-project-content">
            <p>
                <a href="<?php echo bp_core_get_user_domain( $project->post_author ) . BP_PORTFOLIO_SLUG; ?>" title="<?php echo sprintf(__('from %s', 'bp-portfolio'), bp_core_get_user_displayname( $project->post_author )); ?>"><?php echo $project->post_title; ?></a>
            </p>
        </div>
    </div>

<?php
endforeach;
?>

<span class="widget-all-projects"><a href="<?php echo trailingslashit($user_domain) . BP_PORTFOLIO_SLUG; ?>"><?php echo sprintf(__('See all projects of %s', 'bp-portfolio'), $user_diplayname); ?></a></span>
