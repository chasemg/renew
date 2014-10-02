<?php

$user = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix. "users WHERE ID=" . $id);

?>

<div class="dashboard_goals">
	<div class="goal_container">
		<div class="user_image">
			<img src='<?php echo get_template_directory_uri(); ?>/dashboard/profile_photos/avatar.png'>
			
		</div>
		
        <div class='goal_text'>Welcome <font style='color:#00af41'><?php echo $user->display_name; ?></font></div>

	</div>
    
    <hr />
    
    <h1>Patient List</h1>

</div>