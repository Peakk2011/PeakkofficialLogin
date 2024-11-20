<?php
session_start();
require_once('../LineLogin/LineLogin.php');

$line = new LineLogin();
$get = $_GET;

$code = $get['code'];
$state = $get['state'];
$token = $line->token($code, $state);

if (property_exists($token, 'error'))
    header('location: index.php');

if ($token->id_token) {
    $profile = $line->profileFormIdToken($token);
    $_SESSION['profile'] = $profile;
    header('location: http://localhost/PeakkofficialLogin/public/LineLoginMain.php');
    // or create html file for redirect line login for unique
    // if unsuccess to do that username is not like username on line fix it
    // or create if else for redirect to home page with line login
}

?>