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
							<td colspan="6">Address<input type="text" id="street" value=""></td>
						</tr>
						<tr>
							<td colspan="6"><br><input type="text" id="street_two" value=""></td>
						</tr>
						<tr>
							<td colspan="2">City<input type="text" id="city" value=""></td>
							<td colspan="2">State<input type="text" id="state" value=""></td>
							<td colspan="2">Zip<input type="text" id="zip" value=""></td>
						</tr>						
					</table>
					<table class="right">
						<tr>
							<td>Primary Phone<input type="tel" id="primary_phone" maxlength="10" value=""></td>
						</tr>
						<tr>
							<td>Mobile Phone<input type="tel" id="mobil_phone" maxlength="10" value=""></td>
						</tr>						
						<tr>
							<td>Social Security<input type="text" id="ssn" maxlength="9" value=""></td>
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
						<div style="height: 30px; text-align: left; padding: 3px 0;"><div id="email_error" style="color: #ff0000; text-align: left;"></div></div>
						<table>
							<tr>
								<td>
									Username<br>
									<input type="email" name="username" id="username" value="" />
								</td>
							</tr>						
							<tr>
								<td>
									Email Address<br>
									<input type="email" name="email_address" id="email_address" value="" />
								</td>
							</tr>
							<tr>
								<td>
									Verify Email Address<br>
									<input type="email" name="email_verified" id="email_verified" value="" />
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
					
					<div style="width: 100%; text-align: right; display: inline-block;"><div class="next" id="validate_address" style="margin-top: 35px;"></div></div>
				</div>
				<div class="enroll" id="form_two"></div>
				<div class="enroll" id="form_three">
					<h1 style="padding: 40px 0 0px 0; font-size: 35px; font-weight: 500;">Submit Your Payment</h1>
					<div style="width: 100%; display: inline-block;">
						<div class="payment_options"><input type="radio" id="annual_option" name="fee_option"><label for="annual_option">I wish to pay the annual fee.</label></div>
						<div class="payment_options"><input type="radio" id="monthly_option" name="fee_option"><label for="monthly_option">I wish to pay the monthly fee.</label></div>
					</div>
					<div class="payment_screen_left">
						<table>
							<th colspan="4">Card Information</th>
							<tr>
								<td colspan="4">Name on Card<input type="text" size="50" id="card_name"></td>
							</tr>
							<tr>
								<td colspan="4">Card Number<input type="text" size="50" id="card_number"></td>
							</tr>
							<tr>
								<td colspan="4">
									<table style="margin: 0px;">
										<tr>
											<td>CCV<input type="text" maxlength="3" style="width: 90px;" id="ccv"></td>
											<td>Exp<input type="text" maxlength="7" style="width: 90px;" id="exp" placeholder="mm/yyyy"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4"><img src="<?php echo get_template_directory_uri(); ?>/parts/images/cc_images.png"></td>
							</tr>							
						</table>
					</div>
					<div class="payment_screen_right">
						<table>
							<th colspan="4">Billing Information</th>
							<tr>
								<td>First Name<input type="text" id="billing_fname"></td>
								<td>Last Name<input type="text" id="billing_lname"></td>
							</tr>
							<tr>
								<td>Street Address<input type="text" size="50" id="billing_street"></td>
								<td>Address 2<input type="text" size="50" id="billing_street_two"></td>
							</tr>
							<tr>
								<td colspan="2">
									<table style="margin: 0px;">
										<tr>
											<td>City<input type="text" id="billing_city"></td>
											<td>State<input type="text" maxlength="2" style="width: 90px;" id="billing_state"></td>
											<td>Zip<input type="text" maxlength="5" style="width: 90px;" id="billing_zip"></td>
										</tr>
										<tr>
											<td>Phone<input type="text" id="billing_phone"></td>
											<td colspan="2">Email<input type="text" id="billing_email"></td>
										</tr>										
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2"><input type="checkbox" id="same_info"><label for="same_info">Same as residential address.</label></td>
							</tr>
						</table>
					</div>
					<div style="width: 100%; display: inline-block; text-align: left;"><button class="button" id="enroll_patient">submit</button></div>
					<div id="enroll_result" style="margin: 50px 0; display: inline-block; width: 100%;"></div>
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
