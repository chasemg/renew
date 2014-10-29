<?php
/*
Template Name: Enrollment
*/
?>
<style>
	.entry-content	{
		margin-top: 15px !important;
	}
	.header_image	{
		max-height: 550px !important;
		height: 550px;
		position: relative !important;
	}
	.row_container	{
		width: 100% !important;
		background: url('<?php echo get_template_directory_uri(); ?>/css/images/cream_pixels.png');	
		margin-top: 550px;
	}
	@media only screen and (min-width: 40.063em)	{
		.top-bar-section .has-dropdown.hover>.dropdown, .top-bar-section .has-dropdown.not-click:hover>.dropdown	{
			padding-top: 11px !important;
		}
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
							<td colspan="6"><br><input type="text" id="street_two" value=""></td>
						</tr>
						<tr>
							<td colspan="2">City<input type="text" id="city" value="Midvale"></td>
							<td colspan="2">State<input type="text" id="state" value="UT"></td>
							<td colspan="2">Zip<input type="text" id="zip" value="84047"></td>
						</tr>						
					</table>
					<table class="right">
						<tr>
							<td>Primary Phone<input type="tel" id="primary_phone" maxlength="10"></td>
						</tr>
						<tr>
							<td>Mobile Phone<input type="tel" id="mobil_phone" maxlength="10"></td>
						</tr>						
						<tr>
							<td>Social Security<input type="text" id="ssn" maxlength="9"></td>
						</tr>
						<tr>
							<td>D.O.B<input type="date" id="dob"></td>
						</tr>						
					</table>
					<div class="mobile_alerts">
						<input type="checkbox" class="css-checkbox" id="alerts" checked="checked">
						<label for="alerts" class="css-label">Recieve message alerts from Renew My Healthcare (requires mobile phone number)</label>
					</div>
					
					<div class="create_profile">
						<h1>Profile Information</h1>
						<form>
						<table>
							<tr>
								<td>
									Email Address(this will be your username)<br>
									<input type="email" name="email_address" />
								</td>
							</tr>
							<tr>
								<td>
									Verify Email Address<br>
									<input type="email" name="email_verified" />
								</td>
							</tr>
							<tr>
								<td>
									Password
									<input type="password" name="password" id="pass1"/>
								</td>
							</tr>
							<tr>
								<td>
									Verify Password
									<input type="password" name="password_retyped" id="pass2"/>
								</td>
							</tr>
							<tr>
								<td style="height: 40px;">
									<span id="pass-strength-result"></span><br>
								</td>
							</tr>													
						</table>
						</form>
					</div>
					
<<<<<<< HEAD
					<div style="width: 100%; text-align: right; display: inline-block;"><button id="validate_address">Next</button></div>
=======
					<div style="width: 100%; text-align: right; display: inline-block;"><div class="next" id="validate_address" style="margin-top: 35px;"></div></div>
>>>>>>> 52fd76ab2d1cd29dbe7e97d624a6d32322cf12c3
				</div>
				<div class="enroll" id="form_two"></div>
				<div class="enroll" id="form_three"></div>	
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
