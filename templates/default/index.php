<?php get_header( 'buddypress' ); ?>

	<?php do_action( 'bp_before_directory_portfolio_page' ); ?>

	<div id="content">
		<div class="padder">

                <?php do_action( 'bp_before_directory_portfolio' ); ?>

                    <h3><?php _e('Projects directory', 'bp-portfolio'); ?></h3>
                    
                    <?php do_action( 'template_notices' ); ?>

			<div class="item-list-tabs no-ajax" role="navigation">
                                <ul>
                                        <li class="selected" id="groups-all"><a href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_portfolio_root_slug() ); ?>"><?php printf( __( 'All projects <span>%s</span>', 'bp-portfolio' ), bp_portfolio_get_total_projects_count() ); ?></a></li>

                                        <?php do_action( 'bp_portfolio_directory_portfolio_filter' ); ?>

                                </ul>
                        </div><!-- .item-list-tabs -->
                    
                    
                    <?php if(bp_portfolio_has_items()) :?>
                        <div id="pag-top" class="pagination">

                                <div class="pag-count" id="portfolio-dir-count-top">

                                        <?php bp_portfolio_pagination_count(); ?>

                                </div>

                                <div class="pagination-links" id="portfolio-dir-pag-top">

                                        <?php bp_portfolio_item_pagination(); ?>

                                </div>

                        </div>
                    <?php endif; ?>
                    
                    <?php while ( bp_portfolio_has_items() ) : bp_portfolio_the_item(); ?>
                    
                        <?php bp_portfolio_item_title() ?> : <?php bp_portfolio_item_description() ?>
                        <br />
                    
                    <?php endwhile; ?>
                
                <?php do_action( 'bp_after_directory_portfolio' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php do_action( 'bp_after_directory_portfolio_page' ); ?>

<?php get_sidebar( 'buddypress' ); ?>
<?php get_footer( 'buddypress' ); ?>