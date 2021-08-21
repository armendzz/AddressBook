<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>AddressBook</title>
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <h1 class="title"><a href="index.php">AddressBook</a></h1>

            <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) : ?>
                <ul class="nav-items">
                    <li class="nav-item"><a href="home.php">Home</a></li>
                    <li class="nav-item"><a href="logout.php">Logout</a></li>
                </ul>
            <?php else : ?>
                <ul class="nav-items">
                    <li class="nav-item"><a href="login.php">Login</a></li>
                    <li class="nav-item"><a href="register.php">Register</a></li>
                </ul>
            <?php endif; ?>
        </nav>
        <hr>
        <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) : ?>
            <div class="welcome">You are loggedin as: <span class="username"><?php echo $_SESSION['username']; ?></span></div>
        <?php endif; ?>
        <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['action'])) : ?>
            <div class="alert">
                <?php

                if (isset($_GET['action']) && $_GET['action'] == "add" && $_GET['status'] == 1) {
                    echo "<div class='al-success'>Contact added succsesfully</div>";
                } elseif (isset($_GET['action']) && $_GET['action'] == "add" && $_GET['status'] == 0) {
                    echo "<div class='al-danger'>Something went wrong, please contact administrator.</div>";
                } elseif (isset($_GET['action']) && isset($_GET['status']) && $_GET['action'] == "update" && $_GET['status'] == 1) {
                    echo "<div class='al-success'>Contact updated succsesfully</div>";
                } elseif (isset($_GET['action']) && isset($_GET['status']) && $_GET['action'] == "update" && $_GET['status'] == 0) {
                    echo "<div class='al-danger'>Something went wrong, please contact administrator.</div>";
                } elseif (isset($_GET['action'])  && $_GET['action'] == "update" && $_GET['auth'] == 0) {
                    echo "<div class='al-danger'>You are not authorized for this action.</div>";
                } elseif (isset($_GET['action']) && $_GET['action'] == "register" && $_GET['status'] == 1) {
                    echo "<div class='al-success'>You are succsesfully registered.</div>";
                } elseif (isset($_GET['action']) && $_GET['action'] == "register" && $_GET['status'] == 0) {
                    echo "<div class='al-danger'>Something went wrong, please contact administrator.</div>";
                } elseif (isset($_GET['action']) && $_GET['action'] == "deleted" && $_GET['status'] == 1) {
                    echo "<div class='al-success'>Contact deleted succsesfully.</div>";
                } elseif (isset($_GET['action']) && $_GET['action'] == "deleted" && $_GET['status'] == 0) {
                    echo "<div class='al-danger'>Something went wrong, please contact administrator.</div>";
                } elseif (isset($_GET['action'])  && $_GET['action'] == "deleted" && $_GET['auth'] == 0) {
                    echo "<div class='al-danger'>You are not authorized for this action.</div>";
                }

                ?>
            </div>
        <?php endif; ?>