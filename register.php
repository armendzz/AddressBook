<?php
include('./includes/header.php');
require_once('./classes/User.php');
if (isset($_SESSION['is_logged_in'])) {
    if ($_SESSION['is_logged_in'] === true) {
        header("Location: home.php");
    }
}

$errors = [];

if (isset($_POST['btn-register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    if (isset($username) && !empty($username) && isset($password) && !empty($password) && isset($password_confirmation) && !empty($password_confirmation)) {
        if ($password === $password_confirmation) {
            $user = new User();
            $user->register($username, $password);
        } else {
            $errors[] = "Password and Confirm password doesn't match!";
        }
    } else {
        $errors[] = "All fields are required!";
    }
}
?>

<div class="login-form">
    <h1>Register</h1>
    <hr>
    <?php if (count($errors) > 0) echo $errors[0]; ?>
    <?php

    if (isset($_GET['error'])) {
        if ($_GET['error'] == 1062) echo "Username is alerdy in use, please try another";
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-group">
                <label id="repeat-pass" for="password_confirmation">Password Confirm</label>
                <input type="password" name="password_confirmation" id="password">
            </div>
            <button type="submit" name="btn-register" class="btn-register">Register</button>
            <hr>
            Alerdy registered <a href="login.php">Login</a>
        </div>
    </form>
</div>

<?php
include('./includes/footer.php'); ?>