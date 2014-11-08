<?php
/*
Template Name: Pricing
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
	.calculate_costs h1	{
		color: #00953a;
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
<div class="header_image_title"><h1 style="color: #ffffff;"><?php echo get_the_title(); ?></h1></div>
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
				<div class="enroll_container" style="padding-bottom: 60px;">
					<div class="calculate_costs" style="display: inline-block; padding-top: 0px;">
						<div>
							<h1 style="border-bottom: none; padding: 20px 0;">Pricing Chart</h1>
							<div class="pricing_table">

								<table>
								<tr>
									<td></td><td><div class='left-border-grey'>Price</div></td>
								</tr>
								<?php $pricing = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "patient_pricing");
									foreach($pricing as $p)	{
										if($p->id == 5)	{
											echo "<tr><td>".$p->name."</td><td><div class='left-border-grey'>$".$p->annually." / yr</div></td></tr>";
										}
									}

									foreach($pricing as $p)	{											
										if($p->id == 2)	{
											echo "<tr><td>".$p->name."</td><td><div class='left-border-grey'>$".$p->annually." / yr</div></td></tr>";
										}
									}
									foreach($pricing as $p)	{											
										if($p->id == 3)	{
											echo "<tr><td>".$p->name."</td><td><div class='left-border-grey'>$".$p->annually." / yr</div></td></tr>";
										}
									}
									foreach($pricing as $p)	{											
										if($p->id == 1)	{
											echo "<tr><td>".$p->name."</td><td><div class='left-border-grey'>$".$p->annually." / yr</div></td></tr>";
										}
									}
									foreach($pricing as $p)	{											
										if($p->id == 6)	{
											echo "<tr><td>".$p->name."</td><td><div class='left-border-grey'>$".$p->annually." / yr</div></td></tr>";
										}
									}
									foreach($pricing as $p)	{	
										if($p->id == 4)	{
											echo "<tr><td style='border-bottom: none;'>".$p->name."</td><td style='border-bottom: none;'><div class='left-border-grey'>$".$p->annually." / yr</div></td></tr>";
										}		
									}
								
								?>
								</table>
							</div>						
							<div style="padding: 30px 0; line-height: 26px; text-align: center;"><font style="font-size: 18px; font-weight: bold;">To add additional individuals:</font><br>Fill out the information below and click "add".<br>When you are done, click "calculate" to get your personalized quote.</div>
							<h1 style="text-align: left; margin: 20px 0;">Your Plan</h1>
							<table class="more_patients" style="background: transparent;">
								<tr>
									<td><font style='color: #ccc;'>M/F</font><br>--</td><td><font style='color: #ccc;'>D.O.B.</font><br>--</td><td><font style='color: #ccc;'>First Name</font><br><font style="font-weight: bold; font-size: 18px;">You</font></td><td><font style='color: #ccc;'>Last Name</font><br>--</td>
								</tr>
								<tr>
									<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;">M/F<select id="new_patient_sex"><option value="M">Male</option><option value="F">Female</option></select></td>
									<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;">D.O.B<input type="date" id="new_dob"></td>
									<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;">First Name<input type="text" id="new_fname"></td>
									<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;">Last Name<input type="text" id="new_lname"></td>
								</tr>

								<tr>
									<td colspan="4"><div class="add_cost" id="add_cost">+ add</div></td>
								</tr>
							</table>
							<div style="text-align: left;"><button class="button" id="calculate_price">calculate</button></div>
						</div>
						<div class="calculated_price" id="calculated"></div>
						<div id="enroll_now"><button id="enroll_now_button">enroll now!</button></div>
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
<script>
	var v = 0;
			$("#add_cost").click(function()	{
					$('#new_dob').removeClass('error_hightlight');
					$('#new_fname').removeClass('error_hightlight');
					$('#new_lname').removeClass('error_hightlight');
					var sex = $("#new_patient_sex").val();
					if(sex == 'M')	{
						var patientSex = "Male";
					} else {
						var patientSex = "Female";
					}
					var dob = $("#new_dob").val();
					if(dob == '')	{
						$('#new_dob').addClass('error_hightlight');
						return false;
					}
					var new_fname = $("#new_fname").val();
					if(new_fname == '')	{
						$('#new_fname').addClass('error_hightlight');
						return false;
					}
					var new_lname = $("#new_lname").val();
					if(new_lname == '')	{
						$('#new_lname').addClass('error_hightlight');
						return false;
					}					

					
					$(".more_patients tr:first").before("<tr><td style='padding-top: 15px;'><font style='color: #ccc;'>M/F</font><br>"+patientSex+"<input type='hidden' id='sex["+ v +"]' value='"+sex+"'></td><td style='padding-top: 15px;'><font style='color: #ccc;'>D.O.B</font><br>"+dob+"<input type='hidden' id='dob["+ v +"]' value='"+dob+"'></td><td style='padding-top: 15px;'><font style='color: #ccc;'>First Name</font><br>"+new_fname+"<input type='hidden' id='new_fname["+ v +"]' value='"+new_fname+"'></td><td style='padding-top: 15px;'><font style='color: #ccc;'>Last Name</font><br>"+new_lname+"<input type='hidden' id='new_lname["+ v +"]' value='"+new_lname+"'></td></tr>");
					$('#new_dob').val('');
					$('#new_fname').val('');
					$('#new_lname').val('');
					$("#new_patient_sex").val('M');
					v++;
				});
				$("#calculate_price").click(function()	{
					var dataSet = '';
					var count = 0;				
					$(".more_patients input[type='hidden']").each(function()	{
						var fieldName = $(this).attr('id');
						var fieldValue = $(this).val();
						if(count == 0)	{
							dataSet += fieldName+"="+fieldValue;
						} else {
							dataSet += "&"+fieldName+"="+fieldValue;
						}
						count++;
					});
					$.ajax({
						type: 'POST',
						data: dataSet,
						url: '<?php echo get_template_directory_uri(); ?>/parts/calculate_cost.php',
						success: function(success)	{
							$("#calculated").html(success);
							$("#go_to_payment").show();
							$("#enroll_now").show();
						},
						error: function(error)	{
							console.log(error);
						}
					});
				});	
				$("#enroll_now_button").click(function()	{
					window.location = 'Enroll';
				});
</script>
<?php get_footer(); ?>