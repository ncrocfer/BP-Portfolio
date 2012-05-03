<?php get_header( 'buddypress' ); ?>

	<?php do_action( 'bp_before_directory_portfolio_page' ); ?>

	<div id="content">
		<div class="padder">

                <?php do_action( 'bp_before_directory_portfolio' ); ?>

                    <h3><?php _e('Projects directory', 'bp-portfolio'); ?></h3>
                    
                    <?php do_action( 'bp_before_directory_groups_content' ); ?>

                    <div id="projects-dir-search" class="dir-search" role="search">

                            <?php bp_portfolio_projects_search_form() ?>

                    </div>

                    
                    <?php do_action( 'template_notices' ); ?>

			<div class="item-list-tabs" role="navigation">
                                <ul>
                                        <li class="selected" id="projects-all"><a href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_portfolio_root_slug() ); ?>"><?php printf( __( 'All projects <span>%s</span>', 'bp-portfolio' ), bp_portfolio_get_total_projects_count() ); ?></a></li>

                                        <?php do_action( 'bp_portfolio_directory_portfolio_filter' ); ?>

                                </ul>
                        </div><!-- .item-list-tabs -->
                    
                    
                    <div id="projects-dir-list" class="projects dir-list">

                        <?php load_sub_template( array( BP_PORTFOLIO_TEMPLATE . '/projects-loop.php' ) ); ?>
                        
                    </div>
                
                <?php do_action( 'bp_after_directory_portfolio' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php do_action( 'bp_after_directory_portfolio_page' ); ?>

<?php get_sidebar( 'buddypress' ); ?>
<?php get_footer( 'buddypress' ); ?>