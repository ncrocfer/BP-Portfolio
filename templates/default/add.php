<?php
    // Adding or editing page ?
    global $project;
    $edit_template = false;
    if(isset($project)) $edit_template = true;
?>

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
                
                                <?php if($edit_template) : ?>
                                    <h4><?php printf(__( 'Edit "%s" project', 'bp-portfolio' ), $project->query->post->post_title) ?></h4>
                                <?php else : ?>
                                    <h4><?php _e( 'Add a new project', 'bp-portfolio' ) ?></h4>
                                <?php endif; ?>
                                    
                                <form action="<?php ($edit_template) ? bp_portfolio_form_action( 'edit' ) : bp_portfolio_form_action( 'add' ) ?>" enctype="multipart/form-data" method="post" id="send_portfolio_form" class="standard-form" role="main">

                                    <?php do_action( 'bp_before_portfolio_add_item' ) ?>

                                    <label for="title-input"><?php _e("Title", 'bp-portfolio') ?></label>
                                    <input type="text" name="title-input" id="title-input" value="<?php echo ($edit_template) ? $project->query->post->post_title : ''; ?>" />
                                    
                                    <label for="url-input"><?php _e("Url", 'bp-portfolio') ?></label>
                                    <input type="text" name="url-input" id="url-input" value="<?php echo ($edit_template) ? get_post_meta($project->query->post->ID, 'bp_portfolio_url', true): ''; ?>"/>
                                    <span class="error"><?php _e('Must be a valid URL !', 'bp-portfolio'); ?></span>

                                    <label for="description-input"><?php _e("Description", 'bp-portfolio') ?></label>
                                    <textarea name="description" id="description" rows="15" cols="40"><?php echo ($edit_template) ? $project->query->post->post_content : ''; ?></textarea>
                                    <p class="item-characters-left"><span id="charLeft"><?php echo BP_PORTFOLIO_DESC_MAX_SIZE; ?></span> <?php _e('characters left', 'bp-portfolio'); ?></p>
                                    
                                    <label for="screenshot-input"><?php _e("Screenshot", 'bp-portfolio') ?><?php if($edit_template) : ?><span style="font-weight: normal; font-style: italic; margin-left: 15px;"><?php _e('(Overwrite the previous one if it exists)', 'bp-portfolio'); ?></span><?php endif; ?></label>
                                    <input type="file" name="screenshot-input" id="screenshot-input" />

                                    

                                    <?php do_action( 'bp_before_portfolio_add_item' ) ?>

                                    <?php wp_nonce_field('project_form_nonce'); ?>
                                    
                                    <div class="submit">
                                            <input type="submit" value="<?php echo ($edit_template) ? __( "Edit this project", 'bp-portfolio' ) : __( "Add new project", 'bp-portfolio' ) ?>" name="<?php echo ($edit_template) ? 'edit' : 'add' ?>" id="<?php echo ($edit_template) ? 'edit' : 'add' ?>" />
                                    </div>

                                </form>

                        </div><!-- #item-body -->

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

        <script type="text/javascript">
                document.getElementById("title-input").focus();

                jq(document).ready(function() {
                    
                    var contentLen = jq('#description').val().length;
                    jq('#charLeft').text(<?php echo BP_PORTFOLIO_DESC_MAX_SIZE; ?> - contentLen);
                    
                    jq('#description').keyup(function() {
                        var len = this.value.length;
                        if (len >= <?php echo BP_PORTFOLIO_DESC_MAX_SIZE; ?>) {
                            this.value = this.value.substring(0, <?php echo BP_PORTFOLIO_DESC_MAX_SIZE; ?>);
                        }
                        jq('#charLeft').text(<?php echo BP_PORTFOLIO_DESC_MAX_SIZE; ?> - len);
                    });
                    
                    jq('#url-input').blur(function() {
                        if(!checkUrl(jq('#url-input').val())) {
                            jq('.error').show();
                        } else {
                            jq('.error').hide();
                        }
                    });
                    
                });
                
                function checkUrl(s) {
                    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
                    return regexp.test(s);
                }

        </script>
        
<?php get_footer() ?>