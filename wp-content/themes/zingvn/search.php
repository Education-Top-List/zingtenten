<?php 
get_header(); 
?>	



<div id="content">
	<div class="container">
		<h2 class="title_header">Kết quả tìm kiếm : <strong><?php the_search_query(); ?></strong></h2>
		<div class="list_post row">
			<?php 
			if(have_posts()): ?>
				
				<?php	while(have_posts()): the_post(); 
				get_template_part('loop/loop_post_category');
				 endwhile;
				 	get_template_part('includes/pagination');
			else:
				echo '<p> No found content</p>';
			endif;
			wp_reset_postdata();
			?>
		</div>

	</div>
</div>


<?php get_footer(); ?>


