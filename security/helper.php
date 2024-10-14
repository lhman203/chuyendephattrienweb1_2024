<?php
function encryptUserId($user_id) {
    $encoded_id = base64_encode($user_id);
    $random_string = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 3);
    return $encoded_id . $random_string;
}
function decryptUserId($user_id) {
    $encoded_id = substr($user_id, 0, -3); 
    return base64_decode($encoded_id);
}
?>
