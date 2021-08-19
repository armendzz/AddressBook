<?php

require_once('./db/pdo.php');

$db = new Database();

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


