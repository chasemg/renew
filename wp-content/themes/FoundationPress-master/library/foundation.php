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


	echo "<script type='text/javascript' src='".get_template_directory_uri() ."/js/modernizr/modernizr.min.js'></script>";
	echo "<script type='text/javascript' src='".get_template_directory_uri() ."/js/jquery/dist/jquery.min.js'></script>";
	echo "<script type='text/javascript' src='".get_template_directory_uri()."/js/dashboard.js'></script>";
	echo "<input type='hidden' value='".$user_id."' id='user_id'><input type='hidden' value='' id='patient_id'>";
	echo "<div class='dashboard_container'>";
	echo "<div class='dashboard'>";
	
	// Left Widget
	
	echo "<div class='left_widget'>";
	if(get_user_role() == 'doctor' || get_user_role() == 'administrator')	{
	
	} 
	elseif(get_user_role() == 'subscriber')	{
		echo '<div class="dashboard_icons" id="user_dashboard"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/comm_icon.png"></div>';
		echo '<div class="dashboard_icons" id="communications"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/comm_icon.png"></div>';
		echo '<div class="dashboard_icons" id="medical_history"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/hist_icon.png"></div>';
		echo '<div class="dashboard_icons" id="labs"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/lab_icon.png"></div>';
		echo '<div class="dashboard_icons" id="meds"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/med_icon.png"></div>';
		echo '<div class="dashboard_icons" id="schedule"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/sched_icon.png"></div>';
		echo '<div class="dashboard_bottom_icons">';
		echo '<div class="dashboard_icons" id="settings"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/settings_icon.png"></div>';
		echo '<div class="dashboard_icons"><a href="'. wp_logout_url('index.php') .'"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/logout_icon.png"></a></div>';
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
	if(get_user_role() == 'doctor' || get_user_role() == 'administrator')	{
		echo '<div class="dashboard_icons" id="soap_notes">Soap Notes</div>';
		echo '<div class="dashboard_icons" id="meds"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/med_icon.png"></div>';
		echo '<div class="dashboard_icons" id="communications"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/comm_icon.png"></div>';
		echo '<div class="dashboard_icons" id="referrals">Referrals</div>';
		echo '<div class="dashboard_icons" id="schedule"><img src="' . get_template_directory_uri() . '/assets/img/dashboard/sched_icon.png"></div>';
		echo "test";
	}
	echo "</div>";
	echo "</div>";
	echo "</div>";
}
/*******************************************************************************/
?>