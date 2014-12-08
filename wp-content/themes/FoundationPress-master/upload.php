<?php

	$json = array();

	if (!empty($_FILES['file']['name'])) 
	{
		$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($_FILES['file']['name'], ENT_QUOTES, 'UTF-8')));

		// Allowed file extension types
		$allowed = array('JPG','jpe','png', 'jpg','gif');

		if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) 
		{
			$json['error'] = 'File type is not allowed';
		}
		
	} 
	else 
	{
		$json['error'] = 'Upload error';
	}
	

	if (!$json && is_uploaded_file($_FILES['file']['tmp_name']) && file_exists($_FILES['file']['tmp_name'])) 
	{
		$dir = '../../../wp-content/uploads/photo/';
		
		$file = $dir . $filename;		
		
		move_uploaded_file($_FILES['file']['tmp_name'], $file);

		$json['success'] = 'Upload success';
	}
	
	//print_r($json);

	echo json_encode($json);
		
?>