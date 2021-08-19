<?php 

if (isset($_POST['btn-install'])) {
    require_once('../db/pdo.php');
    $db = new Database();
    $db->install();
    
}