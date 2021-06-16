<?php
/*
Template Name: Overview Page
*/
?>
<?php get_header() ?>


  <?php
    // This hook is used to render the following elements(ordered by priorities) :
    // slider
    // singular thumbnail
    do_action('__before_main_wrapper')
  ?>

    <div id="main-wrapper" class="section">

            <?php
              //this was the previous implementation of the big heading.
              //The next one will be implemented with the slider module
            ?>
          <?php  if ( apply_filters( 'big_heading_enabled', false && ! czr_fn_is_real_home() && ! is_404() ) ): ?>
            <div class="container-fluid">
              <?php
                if ( czr_fn_is_registered_or_possible( 'archive_heading' ) )
                  $_heading_template = 'content/post-lists/headings/archive_heading';
                elseif ( czr_fn_is_registered_or_possible( 'search_heading' ) )
                  $_heading_template = 'content/post-lists/headings/search_heading';
                elseif ( czr_fn_is_registered_or_possible('post_heading') )
                  $_heading_template = 'content/singular/headings/post_heading';
                else //pages and fallback
                  $_heading_template = 'content/singular/headings/page_heading';

                czr_fn_render_template( $_heading_template );
              ?>
            </div>
          <?php endif ?>

          <?php
            /*
            * Featured Pages | 10
            * Breadcrumbs | 20
            */
            do_action('__before_main_container')
            
          ?>
          <div class="container"><h1 class="entry-title"><?php the_title();?></h1></div>
		  <?php 
	            if ( has_post_thumbnail() ) {
					echo '<div class="header-image" style="background-image:url('.get_the_post_thumbnail_url().')"></div>';
				}  
            ?>
          <div class="<?php czr_fn_main_container_class() ?>" role="main">

            <?php do_action('__before_content_wrapper'); ?>
            
            

            
                <div class="topmenu">
			        <ul>
						<?php
							echo wpse_get_ancestor_tree();
						?>
			        </ul>
		        </div>
	             
               

            <?php
						  echo do_shortcode(get_the_content());
                 ?> 
            <?php do_action('__after_content_wrapper'); ?>


          </div><!-- .container -->

          <?php do_action('__after_main_container'); ?>

    </div><!-- #main-wrapper -->

    <?php do_action('__after_main_wrapper'); ?>

    <?php
      if ( czr_fn_is_registered_or_possible('posts_navigation') ) :
    ?>
      <div class="container-fluid">
        <?php
          if ( !is_singular() )
            czr_fn_render_template( "content/post-lists/navigation/post_list_posts_navigation" );
          else
            czr_fn_render_template( "content/singular/navigation/singular_posts_navigation" );
        ?>
      </div>
    <?php endif ?>

<?php get_footer() ?>
