<?php
/*
Template Name: Secondary Pages
*/
?>
<style>

	.hook	{
		background: url(<?php echo get_template_directory_uri(); ?>/assets/img/secondary_ribbon.png) right center no-repeat !important;
		height: 425px !important;
		top: -21px !important;
		width: 70px !important;
	}
	.hook span	{
		bottom: 220px !important;
		font-size: 13px !important;
	}
	.about-benefits p	{
		margin: 0 0 20px 0 !important;
		font-size: 15px !important;
	}
	.about-benefits	{
		padding: 18px;
		position:relative;
		min-height: 400px !important;
		padding: 50px 170px 0px 103px !important;
		clear:both;
	}	
	.hero_banner_text h1	{
		font-family: 'adellesemibold' !important;
		text-shadow: 0px 2px 2px rgba(0,0,0,0.75);
	}
	.hero_banner_text p	{
		color: #fff !important;
		text-shadow: 0px 2px 2px rgba(0,0,0,0.75);
		font-size: 18px;
	}
	.image-background	{
		max-height: 807px !important;
	}
	.hero_banner_text	{
		width: 100% !important;
		padding-left: 17px !important;
		margin: 0px 0px 0px 0px !important;
		max-width: 442px;
		position: absolute !important;
		margin-top: -612px !important;
	}
	.hero_banner_text button	{
		margin-top: 0px !important;
	}
	.hero_banner_text h1	{
		font-family: 'adellesemibold' !important;
	}
	.green_slider_button, input[type="submit"]	{	
		text-transform: uppercase !important;
		letter-spacing: 2px !important;
		border-radius: 3px !important;
	}	
<?php	if(is_page(147))	{ ?>
		.hero_banner_text	{
			width: 100% !important;
			padding-left: 17px !important;
			margin: 0px 0px 0px 140px !important;
			max-width: 600px;
			position: absolute !important;
			margin-top: -420px !important;
		}
		.secondary_text	{
			line-height: 22px !important;
		}
		.large-9	{
			width: 80% !important;
		}
		@media (max-width: 1024px) and (min-width: 280px)	{
			.large-9	{
				width: 100% !important;
			}
		}
		.container	{
			background: url(<?php echo get_template_directory_uri(); ?>/css/images/cream_pixels.png) repeat !important;
		}
		.entry-content {
			margin-top: 775px !important;
		}		
<?php	} elseif(is_page(270))	{ ?>
		.hero_banner_text	{
			width: 100% !important;
			padding-left: 17px !important;
			margin: 0px 0px 0px 85px !important;
			max-width: 650px;
			position: absolute !important;
			margin-top: -466px !important;
		}
		.entry-content {
			margin-top: 750px !important;
		}		
<?php	} elseif(is_page(207))	{ ?>
		.hero_banner_text	{
			width: 100% !important;
			padding-left: 17px !important;
			margin: 0px 0px 0px 0px !important;
			max-width: 700px;
			position: absolute !important;
			margin-top: -546px !important;
		}
		.hero_banner_text p{
			color: #000 !important;
			text-shadow: none !important;
		}		
		.hero_banner_text h1	{
			text-shadow: none !important;
		}
		.entry-content {
			margin-top: 750px !important;
		}		
<?php	} elseif(is_page(224))	{ ?>
		.hero_banner_text p{
			color: #000 !important;
			text-shadow: none !important;
		}		
		.hero_banner_text h1	{
			text-shadow: none !important;
		}
		.hero_banner_text	{
			width: 100% !important;
			padding-left: 17px !important;
			margin: 0px 0px 0px 0px !important;
			max-width: 442px;
			position: absolute !important;
			margin-top: -612px !important;
		}
		.entry-content {
			margin-top: 750px !important;
		}			
<?php } else { ?>
		.hero_banner_text	{
			width: 100% !important;
			padding-left: 17px !important;
			margin: 0px 0px 0px 0px !important;
			max-width: 442px;
			position: absolute !important;
			margin-top: -612px !important;
		}
		.entry-content {
			margin-top: 750px !important;
		}		
<?php } ?>
	.empower.doctor-patient	{
		padding: 1px 40px 0px 103px !important;;
	}
	@media (max-width: 1024px) and (min-width: 769px)	{
		.empower	{
			margin-top: 0px !important;
			padding-top: 20px !important;
		}
	}
	@media (max-width: 768px) and (min-width: 481px)	{
		.image-background	{
			max-height: 290px !important;
		}
		.hero_banner_text	{
			width: 100% !important;
			text-align: center !important;
			padding: 0 !important;
			max-width: 100% !important;
			margin-bottom: 77px !important;
			margin-top: -230px !important;
			position: absolute !important;
			margin-left: 0px !important;
		}
		.hero_banner_text p:not(.buttons)	{
			display: none;
		}
		.hero_banner_text h1	{
			width: 80% !important;
		}
		.hero_banner_text .buttons, .hero_banner_text h1	{
			text-align: center;
		}
		.entry-content {
			margin-top: 292px !important;
		}	
		.hook span	{
			left: -244px !important;
		}
	}
	@media (max-width: 599px) and (min-width: 481px)	{
		.hook, .hook span	{
			display: none !important;
		}
		.row_container	{
			width: auto !important;
		}
		.small-12	{
			width: auto !important;
		}
		.small-12 .columns	{
			padding-left: 0px !important;
		}
		.empower.doctor-patient	{
			padding: 0 0 0 0 !important;
			margin-top: 0px !important;
		}
		.empower.doctor-patient	h1	{
			text-align: center !important;
			font-size: 18px !important;
			width: 80% !important;
		}
		.header_text .renew_small_black p, .hero_banner_text p, .page-id-270 .empower p, .page-id-270 p, .page-id-224 p, .page-id-207 p, .page-id-147 p, .page-id-147	{
			font-size: 11px !important;
		}	
		.hero_banner_text .buttons, .hero_banner_text h1	{
			margin: 0 !important;
		}
		.hero_banner_text button	{
			margin: 10px 0 !important;
		}	

		.hero_banner_text p.buttons, .hero_banner_text h1 {
			margin: 0 !important;
		}		
	}
	@media (max-width: 768px) and (min-width: 600px)	{
		.hero_banner_text	{
			width: 95% !important;
			text-align: center !important;
			padding: 0 !important;
			max-width: auto !important;
			margin-bottom: 0px !important;
			margin-top: -177px !important;
			position: absolute !important;
			margin-left: 0px !important;
		}
		.empower.doctor-patient h1	{
			margin-top: 20 !important;
		}
		.entry-content {
			margin-top: 292px !important;
		}	
		.hero_banner_text h1	{
			width: 80% !important;
			text-align: center !important;
			margin-left: auto !important;
			margin-right: auto !important;
		}		
	}
	@media (max-width: 599px) and (min-width: 569px)	{
		.row_container	{
			width: auto !important;
		}
		.small-12	{
			width: 95% !important;
		}
		.hero_banner_text .buttons, .hero_banner_text h1	{
			margin: 0 !important;
		}
		.hero_banner_text button	{
			margin: 10px 0 !important;
		}
		.entry-content {
			margin-top: 292px !important;
		}
		.post-270 .doctor-patient	{
			margin-top: 70px !important;
		}	

		.header_text .renew_small_black p, .hero_banner_text p, .page-id-270 .empower p, .page-id-270 p, .page-id-224 p, .page-id-207 p, .page-id-147 p, .page-id-147	{
			font-size: 11px !important;
		}
		.hero_banner_text	{
			width: 95% !important;
			text-align: center !important;
			padding: 0 !important;
			max-width: auto !important;
			margin-bottom: 0px !important;
			margin-top: -195px !important;
			position: absolute !important;
			margin-left: 0px !important;
		}
		.empower.doctor-patient h1	{
			margin: 0 !important;
			width: 80% !important;
		}
		.entry-content {
			margin-top: 320px !important;
		}	
		.small-12	{
			padding: 0 20px !important;
			margin-bottom: 40px !important;
		}		
	}	
	@media (max-width: 568px) and (min-width: 481px)	{
		.hero_banner_text	{
			width: 95% !important;
			text-align: center !important;
			padding: 0 !important;
			max-width: auto !important;
			margin-bottom: 0px !important;
			margin-top: -195px !important;
			position: absolute !important;
			margin-left: -10px !important;
		}
		.empower.doctor-patient h1	{
			margin: 0 !important;
			text-align: center !important;
			width: 80% !important;
		}
		.hero_banner_text h1	{
			width: 80% !important;
			text-align: center !important;
			margin-left: auto !important;
			margin-right: auto !important;
		}		
		.entry-content {
			margin-top: 250px !important;
		}	
		.small-12	{
			padding: 0 20px !important;
			margin-bottom: 40px !important;
		}
	}	
	@media (min-width: 281px) and (max-width: 480px)	{
		.image-background	{
			max-height: 290px !important;
		}
		.entry-content {
			margin-top: 255px !important;
		}	
		.hero_banner_text	{
			width: 100% !important;
			padding-left: 0px !important;
			margin: 0px 0px 0px 0px !important;
			max-width: 100% !important;
			position: absolute !important;
			margin-top: -200px !important;
			margin-left: -10px !important;
			text-align: center !important;
		}		
		.hero_banner_text .buttons, .hero_banner_text h1	{
			text-align: center;
		}	
		.hero_banner_text h1	{
			width: 80% !important;
			text-align: center !important;
			margin-left: auto !important;
			margin-right: auto !important;
		}
		.empower.doctor-patient	{
			padding: 10px 0px 0px 0px !important
		}
	}
	@media (min-width: 100px) and (max-width: 280px)	{
		.image-background	{
			max-height: 290px !important;
		}
		.entry-content {
			margin-top: 255px !important;
		}	
		.hero_banner_text	{
			width: 100% !important;
			padding-left: 0px !important;
			margin: 0px 0px 0px 0px !important;
			max-width: 100% !important;
			position: absolute !important;
			margin-top: -200px !important;
		}		
		.hero_banner_text .buttons, .hero_banner_text h1	{
			text-align: center;
		}	
		.empower.doctor-patient	{
			padding: 10px 0px 0px 0px !important
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
	<?php if(is_page(147) || is_page(224))	{ ?>
		<div class="image-background" style="background:url(<?php echo $bg[0]; ?>) top center no-repeat">
	<?php } elseif(is_page(207))	{ ?>
		<div class="image-background" style="background:url(<?php echo $bg[0]; ?>) center center no-repeat">
	<?php } else { ?>
		<div class="image-background" style="background:url(<?php echo $bg[0]; ?>) bottom center no-repeat">
	<?php } ?>
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
