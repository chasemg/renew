<?php
/*
Plugin Name: Easy FAQs
Plugin URI: http://goldplugins.com/our-plugins/easy-faqs-details/
Description: Easy FAQs - Provides custom post type, shortcodes, widgets, and other functionality for Frequently Asked Questions (FAQs).
Author: Gold Plugins
Version: 1.4.3
Author URI: http://goldplugins.com

This file is part of Easy FAQs.

Easy FAQs is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Easy FAQs is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Easy FAQs .  If not, see <http://www.gnu.org/licenses/>.
*/

global $easy_faqs_footer_css_output;

include('include/lib/lib.php');

class easyFAQs
{
	function __construct(){		
		//create shortcodes
		add_shortcode('single_faq', array($this, 'outputSingleFAQ'));
		add_shortcode('faqs', array($this, 'outputFAQs'));
		add_shortcode('faqs-by-category', array($this, 'outputFAQsByCategory'));
		add_shortcode('submit_faq', array($this, 'submitFAQForm'));

		//add JS
		add_action( 'wp_enqueue_scripts', array($this, 'easy_faqs_setup_js' ));

		//add CSS
		add_action( 'wp_head', array($this, 'easy_faqs_setup_css' ));

		//add Custom CSS
		add_action( 'wp_head', array($this, 'easy_faqs_setup_custom_css'));

		//register sidebar widgets
		add_action( 'widgets_init', array($this, 'easy_faqs_register_widgets' ));

		//do stuff
		add_action( 'after_setup_theme', array($this, 'easy_faqs_setup_faqs' ));

		//add example shortcode to list of faqs
		add_filter('manage_faq_posts_columns', array($this, 'easy_faqs_column_head'), 10);  
		add_action('manage_faq_posts_custom_column', array($this, 'easy_faqs_columns_content'), 10, 2); 
		
		//add example shortcode to faq categories list
		add_filter('manage_edit-easy-faq-category_columns', array($this, 'easy_faqs_cat_column_head'), 10);  
		add_action('manage_easy-faq-category_custom_column', array($this, 'easy_faqs_cat_columns_content'), 10, 3); 
	}

	//setup JS
	function easy_faqs_setup_js() {
		if(isValidFAQKey()){
			wp_enqueue_script('jquery-ui-accordion');
			wp_enqueue_script(
				'easy-faqs',
				plugins_url('include/js/easy-faqs-init.js', __FILE__),
				array( 'jquery' )
			);
		}
	}

	//add FAQ CSS to header
	function easy_faqs_setup_css() {
		wp_register_style( 'easy_faqs_style', plugins_url('include/css/style.css', __FILE__) );
		
		switch(get_option('faqs_style')){
			case 'no_style':
				break;
			case 'default_style':
			default:
				wp_enqueue_style( 'easy_faqs_style' );
				break;
		}
	}	

	function easy_faqs_send_notification_email(){
		//get e-mail address from post meta field
		$email_address = get_option('easy_faqs_submit_notification_address', get_bloginfo('admin_email'));
	 
		$subject = "New Easy FAQ Submission on " . get_bloginfo('name');
		$body = "You have received a new submission with Easy FAQs on your site, " . get_bloginfo('name') . ".  Login and see what they had to say!";
	 
		//use this to set the From address of the e-mail
		$headers = 'From: ' . get_bloginfo('name') . ' <'.get_bloginfo('admin_email').'>' . "\r\n";
	 
		if(wp_mail($email_address, $subject, $body, $headers)){
			//mail sent!
		} else {
			//failure!
		}
	}
		
	function easy_faqs_check_captcha() {
		$captcha = new ReallySimpleCaptcha();
		// This variable holds the CAPTCHA image prefix, which corresponds to the correct answer
		$captcha_prefix = $_POST['captcha_prefix'];
		// This variable holds the CAPTCHA response, entered by the user
		$captcha_code = $_POST['captcha_code'];
		// This variable will hold the result of the CAPTCHA validation. Set to 'false' until CAPTCHA validation passes
		$captcha_correct = false;
		// Validate the CAPTCHA response
		$captcha_check = $captcha->check( $captcha_prefix, $captcha_code );
		// Set to 'true' if validation passes, and 'false' if validation fails
		$captcha_correct = $captcha_check;
		// clean up the tmp directory
		$captcha->remove($captcha_prefix);
		$captcha->cleanup();
		
		return $captcha_correct;
	}	
		
	function easy_faqs_outputCaptcha(){
		// Instantiate the ReallySimpleCaptcha class, which will handle all of the heavy lifting
		$captcha = new ReallySimpleCaptcha();
		 
		// ReallySimpleCaptcha class option defaults.
		// Changing these values will hav no impact. For now, these are here merely for reference.
		// If you want to configure these options, see "Set Really Simple CAPTCHA Options", below
		$captcha_defaults = array(
			'chars' => 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789',
			'char_length' => '4',
			'img_size' => array( '72', '24' ),
			'fg' => array( '0', '0', '0' ),
			'bg' => array( '255', '255', '255' ),
			'font_size' => '16',
			'font_char_width' => '15',
			'img_type' => 'png',
			'base' => array( '6', '18'),
		);
		 
		/**************************************
		* All configurable options are below  *
		***************************************/
		 
		//Set Really Simple CAPTCHA Options
		$captcha->chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
		$captcha->char_length = '4';
		$captcha->img_size = array( '100', '50' );
		$captcha->fg = array( '0', '0', '0' );
		$captcha->bg = array( '255', '255', '255' );
		$captcha->font_size = '16';
		$captcha->font_char_width = '15';
		$captcha->img_type = 'png';
		$captcha->base = array( '6', '18' );
		 
		/********************************************************************
		* Nothing else to edit.  No configurable options below this point.  *
		*********************************************************************/
		 
		// Generate random word and image prefix
		$captcha_word = $captcha->generate_random_word();
		$captcha_prefix = mt_rand();
		// Generate CAPTCHA image
		$captcha_image_name = $captcha->generate_image($captcha_prefix, $captcha_word);
		// Define values for CAPTCHA fields
		$captcha_image_url =  get_bloginfo('wpurl') . '/wp-content/plugins/really-simple-captcha/tmp/';
		$captcha_image_src = $captcha_image_url . $captcha_image_name;
		$captcha_image_width = $captcha->img_size[0];
		$captcha_image_height = $captcha->img_size[1];
		$captcha_field_size = $captcha->char_length;
		// Output the CAPTCHA fields
		?>
		<div class="easy_t_field_wrap">
			<img src="<?php echo $captcha_image_src; ?>"
			 alt="captcha"
			 width="<?php echo $captcha_image_width; ?>"
			 height="<?php echo $captcha_image_height; ?>" /><br/>
			<label for="captcha_code"><?php echo get_option('easy_faqs_captcha_field_label','Captcha'); ?></label><br/>
			<input id="captcha_code" name="captcha_code"
			 size="<?php echo $captcha_field_size; ?>" type="text" />
			<p class="easy_t_description"><?php echo get_option('easy_faqs_captcha_field_description','Enter the value in the image above into this field.'); ?></p>
			<input id="captcha_prefix" name="captcha_prefix" type="hidden"
			 value="<?php echo $captcha_prefix; ?>" />
		</div>
		<?php
	}

	//submit faq shortcode
	function submitFAQForm($atts){   
			ob_start();
			
			// process form submissions
			$inserted = false;
       
			if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {
				//only process submissions from logged in users
				if(isValidFAQKey()){  
					$do_not_insert = false;
					
					if (isset ($_POST['the-title']) && strlen($_POST['the-title']) > 0) {
							$title =  "Question from: " . $_POST['the-title'];
					} else {
							echo '<p class="easy_faqs_error">Please enter your name.</p>';
							$do_not_insert = true;
					}	
				   
					if (isset ($_POST['the-body']) && strlen($_POST['the-body']) > 0) {
							$body = $_POST['the-body'];
					} else {
							echo '<p class="easy_faqs_error">Please enter a question.</p>';
							$do_not_insert = true;
					}		
				
					if(class_exists('ReallySimpleCaptcha') && get_option('easy_faqs_use_captcha',0)){ 
						$correct = easy_t_check_captcha(); 
						if(!$correct){
							echo '<p class="easy_faqs_error">Captcha did not match.</p>';
							$do_not_insert = true;
						}
					}
				   
					if(!$do_not_insert){
						$post = array(
								'post_title'    => $title,
								'post_content'  => $body,
								'post_category' => array(1),  // custom taxonomies too, needs to be an array
								'post_status'   => 'pending',
								'post_type'     => 'faq'
						);
					   
						$new_id = wp_insert_post($post);
					   
						$inserted = true;
   
						// do the wp_insert_post action to insert it
						do_action('wp_insert_post', 'wp_insert_post');                 
					}
				} else {
					echo "You must have a valid key to perform this action.";
				}
			}       
		   
			$content = '';
		   
			if(isValidFAQKey()){     
			   
				if($inserted){
					echo '<p class="easy_faqs_submission_success_message">' . get_option('easy_faqs_submit_success_message','Thank You For Your Submission!') . '</p>';
					$this->easy_faqs_send_notification_email();
				} else { ?>
				<!-- New Post Form -->
				<div id="postbox">
					<form id="new_post" name="new_post" method="post">
						<div class="easy_faqs_field_wrap">
							<label for="the-title">Your Name</label><br />
							<input type="text" id="the-title" tabindex="1" name="the-title" />
							<p class="easy_faqs_description">Please let us know your name.</p>
						</div>
						<div class="easy_faqs_field_wrap">
							<label for="the-body">Question</label><br />
							<textarea id="the-body" tabindex="2" name="the-body" cols="50" rows="6"></textarea>
							<p class="easy_faqs_description">This is the question that you are asking.</p>
						</div>
		
						<?php if(class_exists('ReallySimpleCaptcha') && get_option('easy_t_use_captcha',0)){ easy_t_outputCaptcha(); } ?>
						
						<div class="easy_faqs_field_wrap"><input type="submit" value="Submit Your Question" tabindex="3" id="submit" name="submit" /></div>
						<input type="hidden" name="action" value="post" />
						<?php wp_nonce_field( 'new-post' ); ?>
					</form>
				</div>
				<!--// New Post Form -->
				<?php }
			   
				$content = ob_get_contents();
				ob_end_clean(); 
			}
		   
			return $content;
	}

	//add Custom CSS
	function easy_faqs_setup_custom_css() {
		//use this to track if css has been output
		global $easy_faqs_footer_css_output;
		
		if($easy_faqs_footer_css_output){
			return;
		} else {
			echo '<style type="text/css" media="screen">' . get_option('easy_faqs_custom_css') . "</style>";
			$easy_faqs_footer_css_output = true;
		}
	}

	
	function word_trim($string, $count, $ellipsis = FALSE)	{
		$words = explode(' ', $string);
		if (count($words) > $count)
		{
			array_splice($words, $count);
			$string = implode(' ', $words);
			// trim of punctionation
			$string = rtrim($string, ',;.');	

			// add ellipsis if needed
			if (is_string($ellipsis)) {
				$string .= $ellipsis;
			} elseif ($ellipsis) {
				$string .= '&hellip;';
			}			
		}
		return $string;
	}

	//setup custom post type for faqs
	function easy_faqs_setup_faqs(){
		//include custom post type code
		include('include/lib/ik-custom-post-type.php');
		//include options code
		include('include/easy_faq_options.php');	
		$easy_faqs_options = new easyFAQOptions();
				
		//setup post type for faqs
		$postType = array('name' => 'FAQ', 'plural' =>'faqs', 'slug' => 'faq' );
		$fields = array(); 
		$myCustomType = new ikFAQsCustomPostType($postType, $fields);
		register_taxonomy( 'easy-faq-category', 'faq', array( 'hierarchical' => true, 'label' => __('FAQ Category'), 'rewrite' => array('slug' => 'faq-category', 'with_front' => false) ) ); 
		
		//load list of current posts that have featured images	
		$supportedTypes = get_theme_support( 'post-thumbnails' );
		
		//none set, add them just to our type
		if( $supportedTypes === false ){
			add_theme_support( 'post-thumbnails', array( 'faq' ) );       
			//for the faq thumb images    
		}
		//specifics set, add our to the array
		elseif( is_array( $supportedTypes ) ){
			$supportedTypes[0][] = 'faq';
			add_theme_support( 'post-thumbnails', $supportedTypes[0] );
			//for the faq thumb images
		}
		//if neither of the above hit, the theme in general supports them for everything.  that includes us!
		
		add_image_size( 'easy_faqs_thumb', 50, 50, true );
	}
	 
	//this is the heading of the new column we're adding to the faq posts list
	function easy_faqs_column_head($defaults) {  
		$defaults = array_slice($defaults, 0, 2, true) +
		array("single_shortcode" => "Shortcode") +
		array_slice($defaults, 2, count($defaults)-2, true);
		return $defaults;  
	}  

	//this content is displayed in the faq post list
	function easy_faqs_columns_content($column_name, $post_ID) {  
		if ($column_name == 'single_shortcode') {  
			echo "<code>[single_faq id={$post_ID}]</code>";
		}  
	} 

	//this is the heading of the new column we're adding to the faq category list
	function easy_faqs_cat_column_head($defaults) {  
		$defaults = array_slice($defaults, 0, 2, true) +
		array("single_shortcode" => "Shortcode") +
		array_slice($defaults, 2, count($defaults)-2, true);
		return $defaults;  
	}  

	//this content is displayed in the faq category list
	function easy_faqs_cat_columns_content($value, $column_name, $tax_id) {  

		$category = get_term_by('id', $tax_id, 'easy-faq-category');
		
		return "<code>[faqs category='{$category->slug}']</code>"; 
	} 

	//return an array of random numbers within a given range
	//credit: http://stackoverflow.com/questions/5612656/generating-unique-random-numbers-within-a-range-php
	function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
		$numbers = range($min, $max);
		shuffle($numbers);
		return array_slice($numbers, 0, $quantity);
	}

	//output specific faq
	function outputSingleFAQ($atts){ 
		
		//load shortcode attributes into an array
		extract( shortcode_atts( array(
			'read_more_link' => get_option('faqs_link'),
			'id' => NULL,
			'category' => '',
			'show_thumbs' => get_option('faqs_image'),
			'read_more_link_text' =>  get_option('faqs_read_more_text', 'Read More')
		), $atts ) );
				
		ob_start();
		
		$i = 0;
		
		echo '<div class="easy-faqs-wrapper" data="single">';
		
		//load faqs into an array
		$loop = new WP_Query(array( 'post_type' => 'faq','p' => $id, 'easy-faq-category' => $category));
		while($loop->have_posts()) : $loop->the_post();
			$postid = get_the_ID();
			$faq['content'] = get_post_meta($postid, '_ikcf_short_content', true); 		

			//if nothing is set for the short content, use the long content
			if(strlen($faq['content']) < 2){
				$faq['content'] = get_the_content($postid); 
			}
			
			if ($show_thumbs) {
				$faq['image'] = get_the_post_thumbnail($postid, 'easy_faqs_thumb');
			}
		
			?><div class="easy-faq" id="easy-faq-<?php echo $postid; ?>">	
			
				<?php if ($show_thumbs) {
					echo $faq['image'];
				} ?>		
				
				<?php echo '<h3 class="easy-faq-title">' . get_the_title($postid) . '</h3>'; ?>
					
				<div class="easy-faq-body">
					<?php echo apply_filters('the_content', $faq['content']);?>
				
					<?php if(strlen($read_more_link)>2):?><a class="easy-faq-read-more-link" href="<?php echo $read_more_link; ?>"><?php echo $read_more_link_text; ?></a><?php endif; ?>
				</div>	

			</div><?php 	
				
		endwhile;	
		
		echo '</div>';
		
		$content = ob_get_contents();
		ob_end_clean();	
		
		wp_reset_query();
		
		return $content;
	}
	
	//passed the atts for the shortcode of faqs this is displayed above
	//loads faq data into a loop object
	//loops through that object and outputs quicklinks for those FAQs
	function outputQuickLinks($atts, $by_category = false){		
		//load shortcode attributes into an array
		extract( shortcode_atts( array(
			'count' => -1,
			'category' => '',
			'orderby' => 'date',//'none','ID','author','title','name','date','modified','parent','rand','menu_order'
			'order' => 'ASC',//'DESC'
			'colcount' => false
		), $atts ) );
		
		
		if($by_category){
			//load list of FAQ categories
			$categories = array();
			
			$categories = get_terms('easy-faq-category'); 
			
			echo "<h3 class='quick-links'>Quick Links</h3>";
			
			//loop through categories, outputting a heading for the category and the list of faqs in that category
			foreach($categories as $category){	
				//output title of category
				?><h4 class="easy-testimonial-category-heading"><?php echo $category->name; ?></h4><?php
			
				//load faqs into an array
				$loop = new WP_Query(array( 'post_type' => 'faq','posts_per_page' => $count, 'orderby' => $orderby, 'order' => $order, 'easy-faq-category' => $category->slug));
			
				$i = 0;
				$r = $loop->post_count;
				
				if(!$colcount){
					$divCount = intval($r/5);
					//if there are trailing testimonials, make sure we take into account the final div
					if($r%5!=0){
						$divCount ++;
					}		
				} else {
					$divCount = intval($colcount);
				}
				
				//trying CSS3 instead...
				echo "<div class='faq-questions'>";
				echo "<ol style=\"-webkit-column-count: {$divCount}; -moz-column-count: {$divCount}; column-count: {$divCount};\">";
				
				while($loop->have_posts()) : $loop->the_post();

					$postid = get_the_ID();
					
					echo '<li class="faq_scroll" id="'.$postid.'"><a href="#easy-faq-' . $postid . '">'.$i.'. ' . get_the_title($postid) . '</a></li>';

					$i ++;
					
				endwhile;
				
				
				echo "</ol>";
				echo "</div>";
			} 
		} else {
			//load faqs into an array
			$loop = new WP_Query(array( 'post_type' => 'faq','posts_per_page' => $count, 'orderby' => $orderby, 'order' => $order, 'easy-faq-category' => $category));
		
			$i = 1;
			$r = $loop->post_count;
			
			if(!$colcount){
				$divCount = intval($r/5);
				//if there are trailing testimonials, make sure we take into account the final div
				if($r%5!=0){
					$divCount ++;
				}		
			} else {
				$divCount = intval($colcount);
			}
			
			//trying CSS3 instead...
			echo "<h3 class='quick-links'>Quick Links</h3>";
			echo "<div class='faq-questions'>";
			echo "<ol style=\"-webkit-column-count: {$divCount}; -moz-column-count: {$divCount}; column-count: {$divCount};\">";
			
			while($loop->have_posts()) : $loop->the_post();

				$postid = get_the_ID();
				
				echo '<li class="faq_scroll" id="'.$postid.'"><a href="#easy-faq-' . $postid . '">'.$i.'. ' . str_replace('Q:', '', get_the_title($postid)) . '</a></li>';

				$i ++;
				
			endwhile;
			
			
			echo "</ol>";
			echo "</div>";
		}
	}

	//output all faqs
	function outputFAQs($atts){ 
		
		//load shortcode attributes into an array
		extract( shortcode_atts( array(
			'read_more_link' => get_option('faqs_link'),
			'count' => -1,
			'category' => '',
			'show_thumbs' => get_option('faqs_image'),
			'read_more_link_text' =>  get_option('faqs_read_more_text', 'Read More'),
			'style' => '',
			'quicklinks' => false,
			'orderby' => 'date',//'none','ID','author','title','name','date','modified','parent','rand','menu_order'
			'order' => 'ASC'//'DESC'
		), $atts ) );
				
		if(!is_numeric($count)){
			$count = -1;
		}
		
		ob_start();
		
		if($style == "accordion" && isValidFAQKey()){
			echo '<div class="easy-faqs-wrapper easy-faqs-accordion">';
		} else if($style == "accordion-collapsed" && isValidFAQKey()){
			//output the accordion, with everything collapsed
		} else {
			echo '<div class="easy-faqs-wrapper">';
		}
		
		//load faqs into an array
		$loop = new WP_Query(array( 'post_type' => 'faq','posts_per_page' => $count, 'orderby' => $orderby, 'order' => $order, 'easy-faq-category' => $category));
		
		//output QuickLinks, if available and pro
		/*if($quicklinks && isValidFAQKey()){
			$this->outputQuickLinks($atts);
		} */
		
		if($quicklinks){
			$this->outputQuickLinks($atts);
		}
		
		while($loop->have_posts()) : $loop->the_post();
			$postid = get_the_ID();
			$faq['content'] = get_post_meta($postid, '_ikcf_short_content', true); 		

			//if nothing is set for the short content, use the long content
			if(strlen($faq['content']) < 2){
				$faq['content'] = get_the_content($postid); 
			}
			
			if ($show_thumbs) {
				$faq['image'] = get_the_post_thumbnail($postid, 'easy_faqs_thumb');
			}
			
			?><div class="easy-faq" id="easy-faq-<?php echo $postid; ?>">	
			
				<?php if ($show_thumbs) {
					echo $faq['image'];
				} ?>		
				
				<?php echo '<h3 class="easy-faq-title">' . get_the_title($postid) . '</h3>'; ?>
					
				<div class="easy-faq-body">
					<?php echo apply_filters('the_content', $faq['content']);?>
				
					<?php if(strlen($read_more_link)>2):?><a class="easy-faq-read-more-link" href="<?php echo $read_more_link; ?>"><?php echo $read_more_link_text; ?></a><?php endif; ?>
				</div>	

			</div><?php 		
			
		endwhile;	

		echo '</div>'; //<!--.easy-faqs-wrapper-->
		
		$content = ob_get_contents();
		ob_end_clean();	
		
		wp_reset_query();
		
		return $content;
	}
	
	//output all faqs grouped by category
	function outputFAQsByCategory($atts){ 
		
		//load shortcode attributes into an array
		extract( shortcode_atts( array(
			'read_more_link' => get_option('faqs_link'),
			'count' => -1,
			//'category' => '',
			'show_thumbs' => get_option('faqs_image'),
			'read_more_link_text' =>  get_option('faqs_read_more_text', 'Read More'),
			'style' => '',
			'quicklinks' => false,
			'orderby' => 'date',//'none','ID','author','title','name','date','modified','parent','rand','menu_order'
			'order' => 'ASC'//'DESC'
		), $atts ) );
				
		if(!is_numeric($count)){
			$count = -1;
		}
		
		ob_start();
		
		//load list of FAQ categories
		$categories = array();
		
		$categories = get_terms('easy-faq-category'); 
		
		//output QuickLinks, if available and pro
		if($quicklinks && isValidFAQKey()){
			$this->outputQuickLinks($atts, true);
		} 
		
		//loop through categories, outputting a heading for the category and the list of faqs in that category
		foreach($categories as $category){				
			//output title of category
			?><h2 class="easy-testimonial-category-heading"><?php echo $category->name; ?></h2><?php
		
			if($style == "accordion" && isValidFAQKey()){
				echo '<div class="easy-faqs-wrapper easy-faqs-accordion">';
			} else if($style == "accordion-collapsed" && isValidFAQKey()){
				//output the accordion, with everything collapsed
				echo '<div class="easy-faqs-wrapper easy-faqs-accordion-collapsed">';
			} else {
				echo '<div class="easy-faqs-wrapper">';
			}	
			
			//load faqs into an array
			$loop = new WP_Query(array( 'post_type' => 'faq','posts_per_page' => $count, 'orderby' => $orderby, 'order' => $order, 'easy-faq-category' => $category->slug));
			while($loop->have_posts()) : $loop->the_post();
				$postid = get_the_ID();
				$faq['content'] = get_post_meta($postid, '_ikcf_short_content', true); 		

				//if nothing is set for the short content, use the long content
				if(strlen($faq['content']) < 2){
					$faq['content'] = get_the_content($postid); 
				}
				
				if ($show_thumbs) {
					$faq['image'] = get_the_post_thumbnail($postid, 'easy_faqs_thumb');
				}
				
				?><div class="easy-faq" id="easy-faq-<?php echo $postid; ?>">	
				
					<?php if ($show_thumbs) {
						echo $faq['image'];
					} ?>		
					
					<?php echo '<h3 class="easy-faq-title">' . get_the_title($postid) . '</h3>'; ?>
						
					<div class="easy-faq-body">
						<?php echo apply_filters('the_content', $faq['content']);?>
					
						<?php if(strlen($read_more_link)>2):?><a class="easy-faq-read-more-link" href="<?php echo $read_more_link; ?>"><?php echo $read_more_link_text; ?></a><?php endif; ?>
					</div>	

				</div><?php 						
			endwhile;	

			echo '</div>'; //<!--.easy-faqs-wrapper-->
			
		}//endforeach categories
		
		$content = ob_get_contents();
		ob_end_clean();	
		
		wp_reset_query();
		
		return $content;
	}


	//register any widgets here
	function easy_faqs_register_widgets() {
		include('include/widgets/single_faq_widget.php');

		register_widget( 'singleFAQWidget' );
	}
}//end easyFAQs

if (!isset($easy_faqs)){
	$easy_faqs = new easyFAQs();
}
?>