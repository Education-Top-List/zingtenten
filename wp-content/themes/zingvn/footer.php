
<div class="scrolltop">
	<i class="fa fa-angle-up" aria-hidden="true"></i>	
</div>
<footer class="footer">
	<div class="container">
		<div class="row">
			<?php if(is_active_sidebar('footer1')) :?>
				<div class="footer-widget-area col-sm-4">
					<?php dynamic_sidebar('footer1'); ?>
				</div>
			<?php endif ?>
			<?php if(is_active_sidebar('footer2')) :?>
				<div class="footer-widget-area  col-sm-4">
					<?php dynamic_sidebar('footer2'); ?>
				</div>
			<?php endif ?>
			<?php if(is_active_sidebar('footer3')) :?>
				<div class="footer-widget-area  col-sm-4">
					<?php dynamic_sidebar('footer3'); ?>
				</div>
			<?php endif ?>
		</div>
		<div class="copyright">
			<p>Thiết kế bởi Yang</p>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>


<script src="<?php echo BASE_URL; ?>/js/wow.min.js"></script>
<script src="<?php echo BASE_URL; ?>/js/slick.js"></script>
<script src="<?php echo BASE_URL; ?>/js/custom.js"></script>


</body>
</html>