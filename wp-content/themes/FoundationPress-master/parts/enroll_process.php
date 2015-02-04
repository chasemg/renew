<?php
include '../dashboard/db_include.php';
include 'protect.php';
$html = '';

$ssn = $_POST['ssn'];
$encrypted_ssn = encrypt_decrypt('encrypt', $ssn);

echo $html;

?>