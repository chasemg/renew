<?php
/*
Template Name: Enrollment
*/
?>

<?php get_header(); ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<?php error_reporting(E_ALL); ?>

<?php if ( has_post_thumbnail() ) { ?>
<div class="header_image">
	<div id="featured"><?php the_post_thumbnail(); ?></div>
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
				<div onload="initialize()">
				<div class="enroll" id="form_one">
					  <div>Address</div>
					  <input type="text" id="street" value="609 E Thatcher Way">
					   <div>City</div>
					  <input type="text" id="city" value="Midvale">
					  <div>State</div>
					  <input type="text" id="state" value="UT">
					  <div>Zip</div>
					  <input type="text" id="zip" value="84047">
					<button id="validate_address">Validate</button>
				</div>
				<div class="enroll" id="form_two">
					<div id="address_validated"></div>
				
				  <div id="results">
					<table>
					  <tr><td align="right">Valid:</td><td><input type="text" id="valid" size="60"/></td></tr>
					  <tr><td align="right">Matched:</td><td><input type="text" id="type" size="60"/></td></tr>
					  <tr><td align="right">Result:</td><td><input type="text" id="result" size="60"/></td></tr>
					  <tr><td align="right">Lat/Long:</td><td><input type="text" id="latlong" size="60"/></td></tr>
					</table>
				  </div>
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
