<?php
// Pagination
function FoundationPress_pagination() {
	global $wp_query;
 
	$big = 999999999; // This needs to be an unlikely integer
 
	// For more options and info view the docs for paginate_links()
	// http://codex.wordpress.org/Function_Reference/paginate_links
	$paginate_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5,
		'prev_next' => True,
	    'prev_text' => __('&laquo;'),
	    'next_text' => __('&raquo;'),
		'type' => 'list'
	) );
 
	$paginate_links = str_replace( "<ul class='page-numbers'>", "<ul class='pagination'>", $paginate_links );
	$paginate_links = str_replace( "<li><span class='page-numbers current'>", "<li class='current'><a href='#'>", $paginate_links );
	$paginate_links = str_replace( "</span>", "</a>", $paginate_links );
	$paginate_links = preg_replace( "/\s*page-numbers/", "", $paginate_links );

	// Display the pagination if more than one page is found
	if ( $paginate_links ) {
		echo '<div class="pagination-centered">';
		echo $paginate_links;
		echo '</div><!--// end .pagination -->';
	}
}

/**
 * A fallback when no navigation is selected by default.
 */
function FoundationPress_menu_fallback() {
	echo '<div class="alert-box secondary">';
	// Translators 1: Link to Menus, 2: Link to Customize
  	printf( __( 'Please assign a menu to the primary menu location under %1$s or %2$s the design.', 'FoundationPress' ),
  		sprintf(  __( '<a href="%s">Menus</a>', 'FoundationPress' ),
  			get_admin_url( get_current_blog_id(), 'nav-menus.php' )
  		),
  		sprintf(  __( '<a href="%s">Customize</a>', 'FoundationPress' ),
  			get_admin_url( get_current_blog_id(), 'customize.php' )
  		)
  	);
  	echo '</div>';
}

// Add Foundation 'active' class for the current menu item
function FoundationPress_active_nav_class( $classes, $item ) {
    if ( $item->current == 1 || $item->current_item_ancestor == true ) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'FoundationPress_active_nav_class', 10, 2 );

/**
 * Use the active class of ZURB Foundation on wp_list_pages output.
 * From required+ Foundation http://themes.required.ch
 */
function FoundationPress_active_list_pages_class( $input ) {

	$pattern = '/current_page_item/';
    $replace = 'current_page_item active';

    $output = preg_replace( $pattern, $replace, $input );

    return $output;
}
add_filter( 'wp_list_pages', 'FoundationPress_active_list_pages_class', 10, 2 );


/**************************************** Dashboard **************************************************************/



function get_user_role() {
	global $current_user;

	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);

	return $user_role;
}

function dashboard($user_id) {
	
	echo "<head>";
	echo "<script type='text/javascript' src='".get_template_directory_uri() ."/js/modernizr/modernizr.min.js'></script>";
	echo "<script type='text/javascript' src='".get_template_directory_uri() ."/js/jquery/dist/jquery.min.js'></script>";
	echo "<script type='text/javascript' src='".get_template_directory_uri() ."/js/foundation/js/foundation.js'></script>";
	echo "<script type='text/javascript' src='".get_template_directory_uri() ."/js/foundation/js/foundation/foundation.offcanvas.js'></script>";
	echo "<script type='text/javascript' src='".get_template_directory_uri()."/js/jquery.fastLiveFilter.js'></script>";
	echo "<script type='text/javascript' src='".get_template_directory_uri()."/js/dashboard.js'></script>";
	echo "<script type='text/javascript' src='".get_template_directory_uri()."/js/jquery-ui-1.11.1.custom/jquery-ui.js'></script>";
	echo "<script type='text/javascript' src='".get_template_directory_uri()."/js/jquery.timepicker/jquery.timepicker.js'></script>";
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri() .'/js/jquery-ui-1.11.1.custom/jquery-ui.css" />';
	echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />';
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri() .'/js/jquery.timepicker/jquery.timepicker.css" />';	
	echo '<meta class="foundation-mq-topbar">';
	echo "</head>";
	
	if(get_user_role() == 'doctor' || get_user_role() == 'administrator' || get_user_role() == 'lab_doctor')	{
		echo "<input type='hidden' value='".$user_id."' id='user_id'><input type='hidden' value='' id='patient_id'>";
	} else {
		echo "<input type='hidden' value='".$user_id."' id='user_id'><input type='hidden' value='".$user_id."' id='patient_id'>";
	}
	
	echo "<div class='off-canvas-wrap' data-offcanvas=''>";
	echo "<div class='inner-wrap'>";
	echo "<nav class='tab-bar dashboard-mobile-menu'>";
		echo "<section class='right-small'>";
			echo "<a class='right-off-canvas-toggle menu-icon'><span></span></a>";
		echo "</section>";
	echo "</nav>";
	
	echo "<aside class='right-off-canvas-menu'>";
		echo "<ul id='menu-mobile' class='off-canvas-list'>";
		
			if(get_user_role() == 'doctor')	{
				echo '<li><div class="dashboard_icons_disabled" id="soap_notes">SOAP Note</div></li>';
				echo '<li><div class="dashboard_icons_disabled" id="meds">Medications</div></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="communications">Communications<div id="push"></div></div></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="referrals">Referrals</div></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="schedule">Scheduling</div></li>';
				echo '<li><div class="doctor_dash mobile-link" id="user_dashboard">Dashboard</div></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="labs">Lab Results</div></li>';
				echo '<li><label></label></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="settings">Settings</div></li>';
				echo '<li><a href="'. wp_logout_url('index.php') .'">Logout</a></li>';				
			}
		
			if(get_user_role() == 'subscriber')	{
				echo '<li><div class="dashboard_icons mobile-link" id="user_dashboard">User Dashboard</div></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="communications">Communications<div id="push"></div></div></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="medical_history">Medical History</div></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="labs">Lab Results</div></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="meds">Medications</div></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="schedule">Scheduling</div></li>';
				echo '<li><label></label></li>';
				echo '<li><div class="dashboard_icons mobile-link" id="settings">Settings</div></li>';
				echo '<li><a href="'. wp_logout_url('index.php') .'">Logout</a></li>';
			}
			
			
		echo "</ul>";
	echo "</aside>";
	
	echo "<div class='dashboard_container'>";
	echo "<div class='dashboard'>";
	
	// Left Widget
	
	echo "<div class='left_widget'>";
	if(get_user_role() == 'doctor' || get_user_role() == 'administrator')	{
		echo '<div class="search_patients"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/search_icon.png"></div>';
		echo '<div class="close_search"><-</div>';
		echo '<div class="search_box">';
		echo '<div class="search_results">';
		echo '<input type="text" id="patient_input" placeholder="Enter patient name">';
		echo '<button id="clear_search">Clear</button>';
		echo '<div class="patient_results"></div>';
		echo '</div>';		
		echo '</div>'; // End .search_box
		
		echo '<div class="dashboard_icons_inactive" id="soap_inactive"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/soap_inactive_icon.png"></div>';
		echo '<div class="dashboard_icons_inactive"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/lab_inactive_icon.png"></div>';
		echo '<div class="dashboard_icons_inactive"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/med_inactive_icon.png"></div>';
		echo '<div class="dashboard_icons" id="schedule"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/sched_icon.png"></div>';
		echo '<div class="dashboard_icons" id="settings"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/settings_icon.png"></div>';
		echo '<div class="dashboard_icons" id="logout"><a href="'. wp_logout_url('index.php') .'"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/logout_icon.png"></a></div>';
		
		
	} 
	elseif(get_user_role() == 'subscriber')	{
		echo '<div class="dashboard_icons" id="user_dashboard"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/comm_icon.png"></div>';
		echo '<div class="dashboard_icons" id="communications"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/comm_icon.png"><div id="push"></div></div>';
		echo '<div class="dashboard_icons" id="medical_history"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/hist_icon.png"></div>';
		echo '<div class="dashboard_icons" id="labs"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/lab_icon.png"></div>';
		echo '<div class="dashboard_icons" id="meds"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/med_icon.png"></div>';
		echo '<div class="dashboard_icons" id="schedule"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/sched_icon.png"></div>';
		echo '<div class="dashboard_bottom_icons">';
		echo '<div class="dashboard_icons" id="settings"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/settings_icon.png"></div>';
		echo '<div class="dashboard_icons" id="logout"><a href="'. wp_logout_url('index.php') .'"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/logout_icon.png"></a></div>';
		echo '</div>';
	} 

	echo "</div>";
	
	// Center Dashboard
	?>
	
	<div class="center-dashboard">
		<div id="dashboard">
			
		</div>
	<div class="dashboard-logo"><a href="<?php echo get_site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png"></a></div>
	</div>
	
	
	
	<?php
	// Right Widget
	
	echo "<div class='right_widget'>";
	if(get_user_role() == 'doctor')	{
		//echo '<div class="doctor_dash" id="user_dashboard">Dashboard</div>';
		//echo '<div class="dashboard_icons_disabled" id="soap_notes">SOAP Note</div>';
		//echo '<div class="dashboard_icons" id="labs"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/lab_icon.png"></div>';
		echo '<div class="dashboard_icons_inactive"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/backdash_inactive_icon.png"></div>';		
		echo '<div class="dashboard_icons" id="communications"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/messages_icon.png"><div id="push"></div></div>';
		echo '<div class="dashboard_icons_disabled" id="meds"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/med_icon.png"></div>';
		echo '<div class="dashboard_icons" id="referrals"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/referrals_icon.png"></div>';				
		echo '<div class="dashboard_bottom_icons">';
		
	}
	else if (get_user_role() == 'lab_doctor') {
	?>
   		<div class="dashboard_icons"><a href="<?php echo wp_logout_url('index.php'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/dashboard/logout_icon.png"></a></div>
    <?php	
	}
	elseif(get_user_role() == 'administrator')	{
		echo '<div class="dashboard_icons_disabled" id="soap_notes">SOAP Note</div>';
		echo '<div class="dashboard_icons_disabled" id="meds"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/med_icon.png"></div>';
		echo '<div class="dashboard_icons" id="communications"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/comm_icon.png"><div id="push"></div></div>';
		echo '<div class="dashboard_icons" id="referrals">Referrals</div>';
		echo '<div class="dashboard_icons" id="schedule"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/sched_icon.png"></div>';
		echo '<div class="doctor_dash" id="user_dashboard"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/comm_icon.png"></div>';
		echo '<div class="dashboard_bottom_icons">';
		echo '<div class="dashboard_icons" id="settings"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/settings_icon.png"></div>';
		echo '<div class="dashboard_icons"><a href="'. wp_logout_url('index.php') .'"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/logout_icon.png"></a></div>';
		echo '</div>';
		
	}
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "<a class='exit-off-canvas'></a>";
	echo "</div>"; // END of .inner-wrap
	echo "</div>"; // END of .off-canvas-wrap
	
  echo "<script> jQuery(document).foundation(); </script>";
  echo '<script> jQuery(".mobile-link").on("click", function() { jQuery(".exit-off-canvas").trigger("click"); }); </script>';
}

function get_patient_list()
{
	$list = get_users(array('role' => 'subscriber'));	
	
	return $list;
}

function get_labdoctor_list()
{
	$list = get_users(array('role' => 'lab_doctor'));
	
	return $list;
}

function get_doctors_list()
{
	$list = get_users(array('role' => 'doctor'));
	
	return $list;
}

function form_dropdown($name, $array, $value)
{
	$html = '<select name="'.$name.'">';	
	
	foreach($array as $a)
	{
		$selected = "";
		
		if ($value == $a->id)
		{
			$selected = "selected";
		}
		
		$html .= '<option value="'.$a->id.'" '.$selected.'>'.$a->text.'</option>';
	}
	
	$html .= '</select>';
	
	return $html;
}


function get_states()
{
	global $wpdb;
	
	return $wpdb->get_results("SELECT name as text, abbreviation as id FROM ".$wpdb->prefix."state WHERE country = 'USA' ORDER BY name");
}


add_filter( 'avatar_defaults', 'doctor_avatar' );

function doctor_avatar ($avatar_defaults) 
{
    $myavatar = get_bloginfo('url') . '/images/doctor-icons.png';
	$avatar_defaults[$myavatar] = "Doctor Avatar";
    return $avatar_defaults;
}

function get_doctor_titles()
{
	global $wpdb;
	
	$results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."titles ORDER BY title_definition", OBJECT);
	
	return $results;
}

/*******************************************************************************/
?>