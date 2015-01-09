<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/

echo "soap notes";
include "db_include.php";
$id = $_POST['id'];
$immun = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "soap_notes WHERE user_id='$id' ORDER BY date DESC LIMIT 1");
foreach($immun as $i)	{
	

}
echo "<br>";
echo "<button id='drFirst'>Dr First</button>";
?>