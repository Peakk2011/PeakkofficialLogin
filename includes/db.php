<?php

    require_once '../config/config.php';

    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) {
        die('Connect Error: ' . $mysqli->connect_error);
    }
    
?>
