<?php

$user = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix. "users WHERE ID=" . $id);

$patients = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "labs WHERE labdoctor = " . $id);

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
    
    <table width="99%" cellpadding="0" cellspacing="0" style="margin:0 auto;">
    	<thead>
        	<tr>
            	<th>Patient</th>
                <th>Doctor</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($patients) { ?>
        <?php } else { ?>
        	<tr>
            	<td colspan="3" style="text-align:center;"> - no patient record found -</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>