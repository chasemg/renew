
<?php if(is_page('Home'))	{ ?>
	<footer class="row" style='background: #f5f8f5; padding-bottom: 40px;'>
		<h1>Frequently Asked Questions</h1>
		<div class='large-4'><?php echo do_shortcode("[single_faq id=100]"); ?></div>
		<div class='large-4'><?php echo do_shortcode("[single_faq id=101]"); ?></div>
	</footer>
	<footer class="row">
		<div class='large-4'><?php echo do_shortcode("[testimonial_rotator id=71 shuffle='true']"); ?></div>
	</footer>	

<?php } ?>
<a class="exit-off-canvas"></a>
</section>
	<?php do_action('foundationPress_layout_end'); ?>
	</div>
</div>
<?php get_template_part('parts/footer_nav'); ?>
<?php wp_footer(); ?>
<?php do_action('foundationPress_before_closing_body'); ?>
</body>
</html>
