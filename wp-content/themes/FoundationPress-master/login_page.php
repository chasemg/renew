<?php
/*
Template Name: Login Page
*/

if(!is_user_logged_in())	{ 
	if (has_post_thumbnail( $post->ID ) ): 
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
	<div id="custom-bg" style="background-image: url('<?php echo $image[0]; ?>')"></div>
	<?php endif;
	get_header();
	?>
		<style>
			#sticky-nav	{
				display: none !important;
			}
			.off-canvas-wrap 	{
				min-height: 100%;
			}
			.top-bar-container, .tab-bar	{
				display: none !important;
			}
			.footer_container	{
				position: fixed;
				bottom: 0;
				left: 0;
			}
			.login-username label, .login-password label	{
				color: #00953a;
			}
			@media (min-width: 220px) and (max-width: 640px)	{
				.nav_logo_footer	{
					display: none;
				}
				.footer_container	{
					height: 30px;
				}
				.off-canvas-wrap 	{
					min-height: 120%;
				}				
			}
		</style>
		<div class="login-container">
		<div style="margin-bottom: 40px; text-align: center;"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png"></div>
		<?php wp_login_form(); ?>
		</div>
	<script>
		/* use as handler for resize*/
		$(window).resize(adjustLayout);
		/* call function in ready handler*/
		$(document).ready(function(){
			adjustLayout();
			/* your other page load code here*/
		})

		function adjustLayout(){
			$('.login-container').css({
				left: ($(window).width() - $('.login-container').outerWidth())/2,
				top: ($(window).height() - $('.login-container').outerHeight())/2 - 100
			});

		}	
	</script>
	<?php
	get_footer();	
} else { 
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri() .'/css/app.css" />';
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri() .'/css/fonts/stylesheet.css" />';	
	
	$user_ID = get_current_user_id();
	dashboard($user_ID);
} 









?>