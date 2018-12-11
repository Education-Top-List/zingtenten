
  <li class="list_post_item pw">
    <figure class="thumbnail"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?></a> </figure>
    <div class="post_wrapper_content">
      <h2 class="post_title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="post_meta">
        <p><?php the_time('d/m/y');?><span>  <?php the_time('g:i a') ?></span> <!-- | by <a href="<?php //echo get_author_posts_url(get_the_author_meta('ID')) ?>"><?php //the_author(); ?></a> -->
          | Posted in
          <?php 
          $categories = get_the_category();
          $seperator = ", ";
          $output = '';
          if($categories){
            foreach ($categories as $category){
              $output .= '<a href="' . get_category_link($category->term_id) . '"> '. $category-> cat_name . ' </a>' .  $seperator;

            }
            echo trim($output , $seperator);
          }
          ?>
        </p>
      </div>


      <?php if(is_search() OR is_archive()){?>
        <p><?php echo excerpt(25); ?></p>
        <a class="readmore" href="<?php echo the_permalink(); ?>">Read more <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
      <?php } 
      else {
        if($post->post_excerpt){ ?>
          <div class="excerpt"><p><?php echo excerpt(35); ?></p></div>
          <a class="readmore" href="<?php echo the_permalink(); ?>">Read more <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
        <?php } else{
          the_content();
        } 
      } ?>

    </div>


  </li>


