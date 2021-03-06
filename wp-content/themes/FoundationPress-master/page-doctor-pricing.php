<?php
/*
Template Name: Doctor Pricing
*/
?>
<style>
	.entry-content {
		margin-top: 440px !important;
	}
	.hook	{
		background: url(<?php echo get_template_directory_uri(); ?>/assets/img/secondary_ribbon.png) right center no-repeat !important;
		height: 477px !important;
		top: -17px !important;
	}
	.hook span	{
		bottom: 220px !important;
		font-size: 13px !important;
		left: -235px !important;
	}
	.about-benefits p	{
		margin: 0 0 20px 0 !important;
		font-size: 15px !important;
	}
	.about-benefits, .empower	{
		padding: 18px;
		position:relative;
		min-height: 400px !important;
		padding: 50px 170px 0px 139px !important;
		clear:both;
	}	
	.about_us_title	{
		margin-top: 245px;
		position: absolute;
		width: 100%;
		font-family: 'adellesemibold';
		font-size: 30px;
		color: #fff;
		text-shadow: 0 2px 2px rgba(0,0,0,0.75);
	}
	.image-background	{
		max-height: 468px !important;
	}
	@media (min-width: 481px) and (max-width: 768px)	{
		.about_us_title	{
			margin-top: 188px !important;
		}
		.row_container	{
			width: auto !important;
		}
		.entry-content {
			margin-top: 352px !important;
		}
		.image-background	{
			max-height: 468px !important;
		}	
		.about-benefits {
			min-height: 400px !important;
			padding: 5px 20px 0px 100px !important;
			clear: both;
		}	
		.about-benefits p	{
			line-height: 1.6 !important;
			font-size: 15px !important;
		}
		.hook	{
			background: url(<?php echo get_template_directory_uri(); ?>/assets/img/secondary_ribbon.png) right top no-repeat !important;
			height: 477px !important;
			width: 60px !important;
			top: -23px !important;
			
		}
		.hook span	{
			bottom: 250px !important;
			font-size: 20px !important;
			width: 596px !important;
			left: -264px !important;
		}	
		.page-background
		{
			position:absolute;
			top:0px;
			left:0px;
			width:100%;
			height:348px !important;
			overflow:hidden;
			text-align:center;
		}
		.small-12	{
			width: 95% !important;
			
		}
	}
	@media (min-width: 480px) and (max-width: 568px)	{
		.entry-content {
			margin-top: 288px !important;
			padding: 0 0 0 15px;
		}
		.additional-info p	{
			font-size: 15px !important;
		}
	}
	@media (min-width: 280px) and (max-width: 480px)	{
		.about_us_title	{
			margin-top: 133px !important;
			font-size: 19px !important;
		}
		.row_container	{
			width: auto !important;
		}
		.entry-content {
			margin-top: 214px !important;
		}
		.image-background	{
			max-height: 255px !important;
		}	
		.about-benefits {
			min-height: 400px !important;
			padding: 5px 20px 0px 70px !important;
			clear: both;
		}	
		.about-benefits p	{
			line-height: 1.6 !important;
			font-size: 12px !important;
		}
		.hook	{
			background: url(<?php echo get_template_directory_uri(); ?>/assets/img/secondary_ribbon.png) right top no-repeat !important;
			height: 477px !important;
			width: 60px !important;
			top: -23px !important;
			
		}
		.hook span	{
			bottom: 250px !important;
			font-size: 20px !important;
			width: 596px !important;
			left: -264px !important;
		}	
		.page-background
		{
			position:absolute;
			top:0px;
			left:0px;
			width:100%;
			height:348px !important;
			overflow:hidden;
			text-align:center;
		}
		.small-12	{
			width: 97% !important;
			padding: 0 5px !important;
		}
		.accordion .accordion-navigation>a:after, .accordion dd>a:after	{
			line-height: 14px !important;
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
		<div class="about_us_title"><?php echo get_the_title(); ?></div>
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
