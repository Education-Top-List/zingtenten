
  <li class="list_post_item pw">
      <div class="wrap_thumb">
                        <?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  ?>
                        <figure class="thumbnail" style="background:url('<?php echo $image[0]; ?>');"> 
                           <a href="<?php the_permalink();?>"></a>
                        </figure>
                     </div>
    <div class="post_wrapper_content">
      <h2 class="post_title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="post_meta">
        <p><?php the_time('d/m/y');?><span>  <?php the_time('g:i a') ?></span> <!-- | by <a href="<?php //echo get_author_posts_url(get_the_author_meta('ID')) ?>"><?php //the_author(); ?></a> -->
 
          
        </p>
      </div>


      <?php if(is_search() OR is_archive()){?>
           <div class="excerpt">
                <p><?php echo excerpt(30); ?></p>
              </div>
      <?php } 
      else {
        if($post->post_excerpt){ ?>
          <div class="excerpt"><p><?php echo excerpt(35); ?></p></div>
        <?php } else{
          the_content();
        } 
      } ?>

    </div>


  </li>


