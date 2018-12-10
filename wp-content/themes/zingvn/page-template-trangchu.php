<?php 
   /*
   Template Name: page-template-trangchu
   */
   get_header(); 
   ?> 
   <div id="wrap">
     <div class="g_content">
      <div class="content_top">
       <div class="container">
        <div class="content_post_admin">
         <?php 
                  $my_postid = 9;//This is page id or post id
                  $content_post = get_post($my_postid);
                  $content = $content_post->post_content;
                  $content = apply_filters('the_content', $content);
                  $content = str_replace(']]>', ']]&gt;', $content);
                  echo $content;
                  ?>
                </div>
                <div class="row">
                 <div class="col-sm-9">
                  <?php 
                  $arg_big_post_query = array(
                    'posts_per_page' => 1,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'post_status' => 'publish'
                  );
                  $big_post_query = new WP_Query();
                  $big_post_query->query($arg_big_post_query);
                  ?>
                  <div class="hot_big_post_area">
                   <div class="row">
                    <div class="col-md-9">
                     <?php if(have_posts()) : 
                      while($big_post_query->have_posts()) : $big_post_query->the_post();
                       ?>
                       <div class="hot_big_post pw">
                        <?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  ?>
                        <figure class="thumbnail" style="background:url('<?php echo $image[0]; ?>');"> 
                         <a href="<?php the_permalink();?>"></a>
                       </figure>
                       <h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                       <div class="excerpt">
                         <p><?php echo excerpt(25); ?></p>
                       </div>
                     </div>
                     <?php  
                   endwhile;
                 else:
                 endif;
                 ?>
                 <div class="list_hot_post_others">
                  <?php 
                  $arg_fpost_query = array(
                    'order' => 'DESC',
                    'offset'=>1
                  );
                  $exclude_fpost_query = new WP_Query();
                  $exclude_fpost_query->query($arg_fpost_query);
                  ?>
                  <?php 
                  if(have_posts()) : 
                    while($exclude_fpost_query->have_posts()) : $exclude_fpost_query->the_post();
                     ?>
                     <div class="item_list_hot pw">
                       <?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  ?>
                       <figure class="thumbnail" style="background:url('<?php echo $image[0]; ?>');"> 
                        <a href="<?php the_permalink();?>"></a>
                      </figure>
                      <h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    </div>
                    <?php  
                  endwhile;
                else:
                endif;
                ?>
              </div>
            </div>
            <!-- hot_big_post_area -->  
            <div class="col-sm-3 ">
             <div class="news_scroll">
              <span>Xem nhiều</span>

              <?php 
              $arg_cmt_post_q = array(
                'posts_per_page' => 10,
                'orderby' => 'post_date',
                'order' => 'DESC',
                'post_type' => 'post',
                'post_status' => 'publish',
                'offset' => 1
              );
              $cmt_post_q = new WP_Query();
              $cmt_post_q->query($arg_cmt_post_q);
              ?>
              <?php if(have_posts()) : ?>
                <ul class="most-commented">
                  <?php
                  while ($cmt_post_q->have_posts()) : $cmt_post_q->the_post(); ?>
                    <li>
                      <div class="post_cmt_wrapper pw">
                        <div class="wrap_thumb">
                          <?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  ?>
                          <figure class="thumbnail" style="background:url('<?php echo $image[0]; ?>');"> 
                            <a href="<?php the_permalink();?>"></a>
                          </figure> 
                        </div>

                        <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> </h3>

                      </div>

                    </li>
                  <?php endwhile; ?>
                <?php endif; ?> 
              </ul>

            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-3">
      <?php dynamic_sidebar('Sidebar_Index_Top'); ?> 
    </div>
  </div>
</div>
</div>
<!--  content_top -->
<div class="multimedia">
      <?php 
            $args = array(
              'parent' => 22,
            ); 
            $terms = get_terms( 'category', $args );

            $term_ids = wp_list_pluck( $terms, 'term_id' );

            $categories = get_categories( $args );
            ?>
            <ul class="list_categories">  
              <?php 
              if($cat || is_wp_error($cat)){
                echo '<li class="parent_cat">' . get_category_parents( $cat, true, '' ) .  '</li>' ;
              }
              foreach($categories as $category) { 
                echo '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a></li> ';
              }
              ?>
            </ul>

</div>
<div class="content_bottom">
 <div class="container">
  <div class="row">
   <div class="col-sm-9 col-xs-12">
    <div class="list_post_content">
     <?php 
     $argsQuery = array(
       'posts_per_page'   => 10,
       'category__not_in' => 17
     );
     $wp_query = new WP_Query(); $wp_query->query($argsQuery);
     if(have_posts()): 
       while($wp_query->have_posts()) : $wp_query->the_post(); 
        get_template_part('content');   
      endwhile;
    else:
    endif;
    ?>
    <?php wp_reset_postdata();?>
  </div>
</div>
<div class="col-md-3 col-sm-3 sidebar">
  <?php dynamic_sidebar('sidebar1'); ?> 
</div>
</div>
</div>
</div>
</div>
</div>
<?php get_footer(); ?>