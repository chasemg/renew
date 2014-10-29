<?php get_header(); ?>
<?php error_reporting(E_ALL); ?>

<?php if (has_post_thumbnail()) { ?>
	
<div class="page-background">
	<?php
		
		$bg = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
	
	?>
	<div class="image-background" style="background:url(<?php echo $bg[0]; ?>) center no-repeat">
	</div>
</div>
	
<?php } ?>



<div class="row_container">
	<div class="row">
		<div class="small-12 columns" role="main">

		<?php do_action('foundationPress_before_content'); ?>
		<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

				<?php do_action('foundationPress_page_before_entry_content'); ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			
				<footer>
					<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'FoundationPress'), 'after' => '</p></nav>' )); ?>
					<p><?php the_tags(); ?></p>
				</footer>

			</article>
		<?php endwhile;?>

		<?php do_action('foundationPress_after_content'); ?>

		</div>
		<?php get_sidebar(); ?>
		
	</div>
</div>


<?php get_footer(); ?>
