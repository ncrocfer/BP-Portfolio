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
                
                            
                                <h4><?php _e( 'Add a new project', 'bp-portfolio' ) ?></h4>
                                
                                <form action="<?php bp_portfolio_form_action( 'add' ) ?>" enctype="multipart/form-data" method="post" id="send_portfolio_form" class="standard-form" role="main">

                                    <?php do_action( 'bp_before_portfolio_add_item' ) ?>

                                    <label for="title-input"><?php _e("Title", 'bp-portfolio') ?></label>
                                    <input type="text" name="title-input" id="title-input" />
                                    
                                    <label for="url-input"><?php _e("Url", 'bp-portfolio') ?></label>
                                    <input type="text" name="url-input" id="url-input" />

                                    <label for="description-input"><?php _e("Description", 'bp-portfolio') ?></label>
                                    <textarea name="description" id="description" rows="15" cols="40"></textarea>
                                    
                                    <label for="screenshot-input"><?php _e("Screenshot", 'bp-portfolio') ?></label>
                                    <input type="file" name="screenshot-input" id="screenshot-input" />

                                    

                                    <?php do_action( 'bp_before_portfolio_add_item' ) ?>

                                    <div class="submit">
                                            <input type="submit" value="<?php _e( "Add new item", 'bp-portfolio' ) ?>" name="add" id="add" />
                                    </div>

                                    <?php wp_nonce_field( 'portfolio_add_item' ) ?>
                                </form>

                                <script type="text/javascript">
                                        document.getElementById("title-input").focus();
                                </script>
                            
                            
                        </div><!-- #item-body -->

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>