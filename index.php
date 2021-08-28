<?php

require_once('./db/pdo.php');

$db = new Database();

/* 
   check if tables exist, if tables exist and
   and user is logged in then move user to home.php
   if tables doest exists then move user to install directory
   and if user is not logged-in move user to login.php
*/

if ($db->tableExists("contacts") && $db->tableExists("users")) {
    if (isset($_SESSION['is_logged_in'])) {
        if ($_SESSION['is_logged_in'] === true) {
            header("Location: home.php");
        }
    } else {
        header("Location: login.php");
    }
} else {
    header('Location: install');
}

?>


