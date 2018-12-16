<?php 
   get_header(); 
   $categories = get_the_category();
   if ( ! empty( $categories ) ) {
   	echo esc_html( $categories->name );   
   }
   
   if(have_posts()) {
   	?>	
<div id="wrap">
   <div class="g_content">
      <div class="container">
         <div class="row">
            <div class="col-sm-9  content_left">
               <?php 
                  if(is_category()){
                  	//echo '<h3 class="title_archives">' . single_cat_title() . '</h3>';
                  	echo '';
                  }
                  else if(is_tag()){
                  	echo '<h3 class="title_archives"><strong>' . single_tag_title() . '/<strong></h3>';
                  }
                  else if(is_author()){
                  	the_post();
                  	echo '<h3 class="title_archives">Author Archives : <strong> ' . get_the_author() . '</strong></h3>';
                  	rewind_posts();
                  }
                  else if(is_day()){
                  	echo '<h3 class="title_archives">Day Archives : <strong>' . get_the_date() . '</strong></h3>';
                  }
                  else if(is_month()){
                  	echo '<h3 class="title_archives">Monthly Archives : <strong>' . get_the_date('F Y') . '</strong></h3>';
                  }
                  else if(is_year()){
                  	echo '<h3 class="title_archives">Yearly Archives : <strong>' . get_the_date('Y') . '</strong></h3>';
                  }
                  else{
                  	echo 'archive';
                  }
                  ?>
               <?php 
                  $args = array(
                  	'parent' => get_queried_object_id(),
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
                     	?>
                  <li>
                     <?php
                        echo '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ';
                        ?>
                  </li>
                  <?php
                     }
                     ?>
               </ul>
               <div class="hot_big_post_area">
                  <div class="row">
                     <div class="col-sm-9">
                        <?php $category = get_queried_object();
                           //echo $category->term_id;
                           ?>
                        <div class="hot_big_post pw">
                           <?php
                              $args = array(
                              	'cat' => $category->term_id,
                              	'posts_per_page' => 1,
                              	'meta_key' => 'meta-checkbox',
                              	'meta_value' => 'yes'
                              );
                              $featured = new WP_Query($args);
                              if ($featured->have_posts()): while($featured->have_posts()): $featured->the_post(); ?>
                           <?php if (has_post_thumbnail()) { ?>
                           <?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  ?>
                           <figure class="thumbnail" style="background:url('<?php echo $image[0]; ?>');"> 
                              <a href="<?php the_permalink();?>"></a>
                           </figure>
                           <?php }?>
                           <h2><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
                           <div class="excerpt">
                              <p><?php echo excerpt(25); ?></p>
                           </div>
                           <?php
                              endwhile; else:
                              endif;
                              ?>
                        </div>
                        <div class="list_hot_post_others">
                           <?php
                              $args = array(
                              	'cat' => $category->term_id,
                              	'posts_per_page' => 5,
                              	'meta_key' => 'meta-checkbox',
                              	'meta_value' => 'yes'
                              );
                              $featured = new WP_Query($args);
                              
                              if ($featured->have_posts()): while($featured->have_posts()): $featured->the_post(); ?>
                           <li class="item_list_hot pw">
                              <div class="wrap_thumb">
                                 <?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  ?>
                                 <figure class="thumbnail" style="background:url('<?php echo $image[0]; ?>');"> 
                                    <a href="<?php the_permalink();?>"></a>
                                 </figure>
                              </div>
                              <div class="post_wrapper_content">
                                 <h2 class="post_title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h2>
                              </div>
                           </li>
                           <?php
                              endwhile; else:
                              endif;
                              ?>
                        </div>
                        <ul class="list_post_category_arc">
                           <?php 
                              while(have_posts()): the_post();
                              	get_template_part('loop/loop_post_category');
                              endwhile;  
                                get_template_part('includes/pagination'); 
                              wp_reset_postdata();
                              ?>
                        </ul>
                     </div>
                     <div class="col-sm-3 ">
                        <div class="news_scroll">
                           <span>Xem nhiều</span>
                           <?php 
                              $arg_cmt_post_q = array(
                              	'cat' => $category->term_id,
                              	'posts_per_page' => 10,
                              	'meta_key' => 'wpb_post_views_count',
                              	'orderby' => 'meta_value_num',
                              	'order' => 'DESC',
                              	'post_type' => 'post',
                              	'post_status' => 'publish'
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
            <?php  if(have_posts()) { ?>
            <div class="col-sm-3 col-sm-3 sidebar">
               <?php dynamic_sidebar('sidebar1'); ?> 
            </div>
            <?php } ?>
         </div>

      </div>
   </div>
</div>
</div>
<?php 
   }
   get_footer(); ?>