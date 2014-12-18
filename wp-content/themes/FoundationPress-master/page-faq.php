<?php
/*
Template Name: FAQ Page
*/
?>
<style>

	.hero_banner_text h1, .entry-content h1	{
		color: #ffffff !important;
		text-align: center !important;
	}
	ol	{
		margin-left: 0px !important;
	}
	.faq_scroll	{
		padding: 0 0 0 0 !important;
	}
	.image-background, .page-background	{
		max-height: 400px !important;
	}
	.entry-content {
		margin-top: 0px !important;
	}
	.entry-content h1	{
		margin: 220px auto !important;
	}
	@media (max-width: 768px) and (min-width: 481px)	{
		.image-background, .page-background	{
			max-height: 200px !important;
		}
		.entry-content h1	{
			margin: 123px auto !important;
		}	
		.row_container	{
			width: auto !important;
		}
	}
	@media (max-width: 568px) and (min-width: 481px)	{
		.entry-content h1	{
			margin: 75px auto !important;
		}		
	}
	
	@media (max-width: 480px) and (min-width: 320px)	{
		.image-background, .page-background	{
			max-height: 200px !important;
		}
		.entry-content h1	{
			margin: 80px auto !important;
		}		
	}	
</style>
<?php get_header(); ?>
<?php error_reporting(E_ALL); ?>

<?php if (has_post_thumbnail()) { ?>
	
<div class="page-background">
	<?php
		
		$bg = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
	
	?>
	<div class="image-background" style="background:url(<?php echo $bg[0]; ?>) top center no-repeat">
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
