<?php

$practice = 1;

include '../dashboard/db_include.php';

$pdb1 = new wpdb(DB_USER,DB_PASSWORD,'renew_1', DB_HOST);

$wpdb->query("INSERT INTO ".$wpdb->prefix."practice 
			  SET name = '".$_POST['practice_name']."', 
			  	  address = '".$_POST['practice_address']."', 
				  address2 = '".$_POST['practice_address2']."', 
				  city = '".$_POST['practice_city']."', 
				  state = '".$_POST['practice_state']."', 
				  zip = '".$_POST['practice_zip']."', 
				  phone = '".$_POST['practice_phone']."', 
				  routing_number = '".$_POST['practice_routing_number']."', 
				  email = '".$_POST['practice_email']."', 
				  bank_account = '".$_POST['practice_bank_account']."', 
				  join_date = NOW(), 
				  staff = '".$_POST['practice_doctors']."'");

$practice_id = $wpdb->insert_id;

$json = array();

if ($practice_id > 0)
{
	$json['practice_id'] = $practice_id;
	
	$wpdb->show_errors();

	$wpdb->query("CREATE DATABASE IF NOT EXISTS renew_" . $practice_id);

	$results = $pdb1->get_results("SHOW TABLES FROM renew_1");

	$pdb = new wpdb(DB_USER,DB_PASSWORD,'renew_' . $practice_id,DB_HOST);
	
	foreach($results as $result)
	{
		//echo "CREATE TABLE renew_".$practice_id.".".$result->Tables_in_renew_1." LIKE renew_1.".$result->Tables_in_renew_1;
		$pdb->query("CREATE TABLE renew_".$practice_id.".".$result->Tables_in_renew_1." LIKE renew_1.".$result->Tables_in_renew_1);
	}


	$user_name = $_POST['user_email'];
	$password = $_POST['user_password'];

	$user_id = username_exists( $user_name );

	//create doctor account;
	

	if ( !$user_id and email_exists($user_name) == false ) 
	{
		$user_id = wp_create_user( $user_name, $password, $user_name );
	
		$json['user_id'] = $user_id;
		
		ob_start();
		
		include('doctor_enroll_success.php');
		
		$html = ob_get_contents();
		
		ob_end_clean();
		
		$json['html'] = $html;
	
		$pdb->query("INSERT INTO renew_".$practice_id.".".$wpdb->prefix."doctors 
					  SET practice_id = '".$practice_id."', 
					  	  user_id = '".$user_id."', 
						  fname = '".$_POST['firstname']."', 
						  lname = '".$_POST['lastname']."', 
						  dea = '".$_POST['dea_number']."', 
						  license = '".$_POST['license_number']."', 
						  specialty = '".$_POST['residency_type']."', 
						  email = '".$_POST['email']."', 
						  undergrad_degree = '".$_POST['undegrad_degree']."', 
						  undergrad_school = '".$_POST['undergrad_school']."', 
						  undergrad_date = '".$_POST['undergrad_date']."', 
						  med_degree = '".$_POST['medical_degree']."', 
						  med_school = '".$_POST['medical_school']."', 
						  med_date = '".$_POST['medical_date']."', 
						  state_issued = '".$_POST['state_issued']."', 
						  certification = '".$_POST['board_certification']."', 
						  entity = '".$_POST['board_entity']."', 
						  expiration = '".$_POST['board_expiration']."', 
						  biography = '".$_POST['biography']."', 
						  subspecialty = '".$_POST['sub_specialty']."',
						  cellphone = '".$_POST['cellphone']."',
						  title = '".$_POST['practice_doctor_title']."'");
						  
						  
					  
		if (isset($_POST['staff']))
		{
			foreach($_POST['staff'] as $staff)
			{
				$staff_id = username_exists( $staff['email'] );
			
				if ( !$staff_id and email_exists($staff['email']) == false ) 
				{
					$user_name = $staff['email'];
					$staff_id = wp_create_user( $user_name, $password, $user_name );
				
					$pdb->query("INSERT INTO ".$wpdb->prefix."staff 
				  				  SET practice_id = '".$practice_id."', 
				  	  			  user_id = '".$staff_id."', 
					  			  fname = '".$staff['firstname']."', 
					  			  lname = '".$staff['lastname']."', 
					  			  state_license = '".$staff['state_license']."', 
					  			  email = '".$staff['email']."', 
					  			  undergrad_degree = '".$staff['undegrad_degree']."', 
					  			  undergrad_school = '".$staff['undergrad_school']."', 
					  			  undergrad_date = '".$staff['undergrad_date']."', 
					  			  prof_degree = '".$staff['professional_degree']."', 
					  			  certification = '".$staff['board_certification']."', 
					  			  phone = '".$staff['phone']."',
								  access = '".$staff['access']."',
								  type = '".$staff['type']."'");
				}
			}
		}
	} 
	else 
	{
		$json['user_id'] = 0;	
	}
}
else
{
	$json['practice_id'] = 0;
}
echo json_encode($json);



?>