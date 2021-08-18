<?php
include('./includes/header.php');
require_once('./classes/User.php');

if(isset($_SESSION['is_logged_in'])){
    if($_SESSION['is_logged_in'] === true){
        header("Location: home.php");
    }
} 

$errors = [];

if (isset($_POST['btn-login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($username) && !empty($username) && isset($password) && !empty($password)) {
        $user = new User();
        $user->login($username, $password);
    } else {
        $errors[] = "All fields are required!";
    }
}

?>


<div class="login-form">
    <h1>Login</h1>
    <hr>
    <?php if (count($errors) > 0) echo $errors[0]; ?>
    <?php if (isset($user) && count($user->errors) > 0) echo $user->errors[0]; ?>
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
            <button class="btn-login" name="btn-login" type="submit">Login</button>
            <hr>
            Don't have a account? <a href="register.php">Create Account</a>
        </div>
    </form>

</div>


<?php
include('./includes/footer.php'); ?>