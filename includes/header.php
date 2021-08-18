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
            <h1>AddressBook</h1>

            <? if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) : ?>
                <ul class="nav-items">
                    <li class="nav-item"><a href="home.php">Home</a></li>
                    <li class="nav-item">Hello: <?php echo $_SESSION['username']; ?> - <a href="logout.php">Logout</a></li>
                </ul>
            <? else : ?>
                <ul class="nav-items">
                    <li class="nav-item"><a href="login.php">Login</a></li>
                    <li class="nav-item"><a href="register.php">Register</a></li>
                </ul>
            <? endif; ?>
        </nav>
        <hr>