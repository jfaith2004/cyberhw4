<?php
session_start();

// Generate a random 6-character code
$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$code  = substr(str_shuffle($chars), 0, 6);
$_SESSION['captcha_code'] = $code;

header('Content-Type: text/plain');
echo $code;
