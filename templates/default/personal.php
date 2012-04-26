<?php get_header() ?>

	<div id="content">
		<div class="padder">

			<div id="item-header">
				<?php locate_template( array( 'members/single/member-header.php' ), true ) ?>
			</div>

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav">
					<ul>
						<?php bp_get_displayed_user_nav() ?>
					</ul>
				</div>
			</div>

			<div id="item-body">

				<div class="item-list-tabs no-ajax" id="subnav">
					<ul>
						<?php bp_get_options_nav() ?>
					</ul>
				</div>
                            
                                <div class="item-list-projects">
                                
                                    <h4><?php _e( 'My projects', 'bp-portfolio' ) ?></h4>
                                    
                                    <?php while ( bp_portfolio_has_items(array('author_id' => bp_displayed_user_id())) ) : bp_portfolio_the_item(); ?>

                                        <div class="item-project">
                                            <div class="item-project-pictures">
                                                <img src="<?php bp_portfolio_item_thumbnail() ?>" width="250px" height="170px" />
                                            </div>
                                            <div class="item-project-content">
                                                <h3>
                                                    <a href=<?php bp_portfolio_item_permalink() ?>><?php bp_portfolio_item_title() ?></a>
                                                    <?php if(bp_is_my_profile()) :?>
                                                    <span class="item-project-content-meta"><a href="<?php echo wp_nonce_url(bp_core_get_user_domain(bp_loggedin_user_id()) . bp_get_portfolio_slug() . '/delete/' .  get_the_ID(), 'delete_project'); ?>"><?php _e('Delete', 'bp-portfolio'); ?></a</span>
                                                    <?php endif; ?>
                                                </h3>
                                                <span><a href="http://www.google.fr"><?php bp_portfolio_item_url() ?></a></span>
                                                <p><?php bp_portfolio_item_description() ?></p>
                                            </div>
                                            <br />
                                        </div>
                                    
                                        <div class="item-project-separator"></div>
                                    

                                    <?php endwhile; ?>
                                    
                                </div>
                            
                            
                        </div><!-- #item-body -->

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>