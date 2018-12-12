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
						<div class="col-md-9 col-sm-3  content_left">
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
									<div class="col-md-9">
										<?php $category_ar = get_categories() ?>
										<?php 
										$arg_big_post_query = array(
											'cat' => $category_ar->term_id,
											'posts_per_page' => 1,
											'orderby' => 'post_date',
											'order' => 'DESC',
											'post_type' => 'post',
											'post_status' => 'publish'
										);
										$big_post_query = new WP_Query();
										$big_post_query->query($arg_big_post_query);
										?>

										<div class="hot_big_post pw">
											<?php 
											while($big_post_query->have_posts()): $big_post_query->the_post();
												?>
												  <h3 class="entry-title">
                           <a href="<?php the_permalink(); ?>">
                           <?php the_title(); ?>
                           </a>
                        </h3>
												<?php
											endwhile;
											wp_reset_postdata();
											?>
										</div>

										<div class="list_hot_post_others">
											<?php 
											$arg_fpost_query = array(
												'cat' => $categories->term_id,
												'order' => 'DESC',
												'offset'=>1
											);
											$exclude_fpost_query = new WP_Query();
											$exclude_fpost_query->query($arg_fpost_query);
											?>
											<?php 
											if(have_posts()) : 
												while($exclude_fpost_query->have_posts()) : $exclude_fpost_query->the_post();
													get_template_part('loop/loop_post_category');
													?>
													<?php  
												endwhile;
											else:
											endif;
											?>
										</div>
									</div>
									<div class="col-sm-3 ">
										<div class="news_scroll">
											<span>Xem nhiều</span>
											<?php $category = get_queried_object();
													echo $category->term_id;
											?>
											<?php 

											$arg_cmt_post_q = array(
												'cat' => $category->term_id,
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
							<ul class="list_post_category">
								<?php 
								while(have_posts()): the_post();
									get_template_part('loop/loop_post_category');
								endwhile;

								wp_reset_postdata();
								?>
							</ul>
						</div>

						<?php  if(have_posts()) { ?>
							<div class="col-md-3 col-sm-3 sidebar">
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


