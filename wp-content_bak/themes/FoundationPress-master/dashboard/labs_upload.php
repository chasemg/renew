<?php

include "db_include.php";

$rand = rand();

$path = '../lab-result/' . $_POST['lab_id'] . '/';

if (!file_exists($path))
{
	mkdir($path);
}
			
$ext = substr($_FILES['document']['name'], -4, 4);
			
while (file_exists($path . $rand . $ext)) 
{
	$rand = rand();
}
	
$filename = $rand . $ext;
			
$target_path = $path . $filename;
			
if(@move_uploaded_file($_FILES['document']['tmp_name'], $target_path))
{
	$wpdb->query("INSERT INTO ".$wpdb->prefix."lab_files SET lab_id = '".addslashes($_POST['lab_id'])."', remarks = '".addslashes($_POST['remarks'])."', filename = '".addslashes($filename)."', date = NOW()");
}

?>
<script>
window.top.window.lab_document(<?php echo $_POST['lab_id']; ?>, <?php echo $_POST['labdoctor_id']; ?>)
</script>    
