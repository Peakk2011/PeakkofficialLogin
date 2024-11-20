<?php

session_start();
require_once('../LineLogin/LineLogin.php');

if (isset($_SESSION['profile'])) {
    $profile = $_SESSION['profile'];
    $line = new LineLogin();
    $line->revoke($profile->access_token);
}

// เก็บข้อมูลผู้ใช้ล่าสุดในคุกกี้
if (isset($_SESSION['username'])) {
    $recent_accounts = isset($_COOKIE['recent_accounts']) ? json_decode($_COOKIE['recent_accounts'], true) : [];
    array_unshift($recent_accounts, $_SESSION['username']);
    $recent_accounts = array_slice($recent_accounts, 0, 1); // เก็บเฉพาะ 1 รายการล่าสุด
    setcookie('recent_accounts', json_encode($recent_accounts), time() + (86400 * 30), "/");
}

// ลบคุกกี้และเซสชัน
if (isset($_COOKIE['logged_in'])) {
    setcookie("logged_in", "", time() - 3600, "/");
}
if (isset($_COOKIE['username'])) {
    setcookie("username", "", time() - 3600, "/");
}

session_unset();
session_destroy();

header('Location: login.php');
exit();

?>
