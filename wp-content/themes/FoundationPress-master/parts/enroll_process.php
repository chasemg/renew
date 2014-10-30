<?php
include '../dashboard/db_include.php';
$html = '';

$ssn = $_POST['ssn'];

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'pants on fireorhnaoingaoingoaing';
    $secret_iv = 'fgjmdghkdghkdghkdghkdk';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

$plain_txt = "This is my plain text";

$encrypted_txt = encrypt_decrypt('encrypt', $ssn);
$html .= "Encrypted Text = $encrypted_txt <br>";

$decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
$html .= "Decrypted Text = $decrypted_txt <br>";

if( $ssn === $decrypted_txt ) {
	$html .= "SUCCESS";
} else {
	$html .= "FAILED";
}

echo $html;

?>