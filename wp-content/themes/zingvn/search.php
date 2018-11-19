<?php 
get_header(); 
?>	



<div id="content">
	<div class="container">
		<div class="list_post">
			<?php 
			if(have_posts()): ?>
				<h2 class="title_header">Search result for : <strong><?php the_search_query(); ?></strong></h2>
				<?php	while(have_posts()): the_post(); 
					
				get_template_part('content');
				
				 endwhile;
			else:
				echo '<p> No found content</p>';
			endif;
			wp_reset_postdata();
			?>
		</div>

	</div>
</div>


<?php get_footer(); ?>


