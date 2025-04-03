<?php
function encrypt_url($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt_url($encrypted_data, $key) {
    list($encrypted, $iv) = explode('::', base64_decode($encrypted_data), 2);
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}
?>
$encryption_key = 'e800e034873832410b9b4c7427f97a23d97a9c9c25dc5214a6562dca084bd95b'; // Replace with a secure key
