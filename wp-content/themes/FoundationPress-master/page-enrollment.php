<?php
/*
Template Name: Enrollment
*/
?>
<style>
	.header_image	{
		max-height: 550px !important;
		height: 550px;
		position: relative !important;
	}
	.row_container	{
		width: 100% !important;
		background: #fff;	
		margin-top: 550px;
	}
</style>
<?php get_header(); ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<?php error_reporting(E_ALL); ?>

<?php if ( has_post_thumbnail() ) { ?>
<div class="header_image">
	<div id="featured"><?php the_post_thumbnail(); ?></div>
</div>
<div class="header_image_title"><h1><?php echo get_the_title(); ?></h1></div>
<div class="header_map" onload="initialize()">
	<div id="map_canvas"></div>
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
				<div class="enroll_container">
				<div class="enroll" id="form_one">
					<h1>Basic Information</h1>
					<table class="left">
						<tr>
							<td colspan="3">First Name<input type="text" id="fname" value=""></td>
							<td colspan="3">Last Name<input type="text" id="lname" value=""></td>
						</tr>
						<tr>
							<td colspan="6">Address<input type="text" id="street" value="609 E Thatcher Way"></td>
						</tr>
						<tr>
							<td colspan="6"><input type="text" id="street_two" value=""></td>
						</tr>
						<tr>
							<td colspan="2">City<input type="text" id="city" value="Midvale"></td>
							<td colspan="2">State<input type="text" id="state" value="UT"></td>
							<td colspan="2">Zip<input type="text" id="zip" value="84047"></td>
						</tr>						
					</table>
					<table class="right">
						<tr>
							<td>Primary Phone<input type="text" id="primary_phone" maxlength="10"></td>
						</tr>
						<tr>
							<td>Mobile Phone<input type="text" id="primary_phone" maxlength="10"></td>
						</tr>						
						<tr>
							<td>Social Security<input type="text" id="primary_phone" maxlength="9"></td>
						</tr>
						<tr>
							<td>D.O.B<input type="text" id="primary_phone" placeholder="mm/dd/YYYY"></td>
						</tr>						
					</table>

					  
					<div style="width: 100%; text-align: right; display: inline-block;"><button id="validate_address">Next</button></div>
				</div>
				<div class="enroll" id="form_two">
					
					
				</div>
				<div class="enroll" id="form_three">
				
				</div>	
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
