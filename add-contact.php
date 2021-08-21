<?php
include('./includes/header.php');
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
}
require_once('./classes/Contacts.php');

$errors = [];

if (isset($_POST['btn-add-contact'])) {

    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $userId = $_SESSION['user_id'];


    if (isset($firstName) && !empty($firstName) && isset($lastName) && !empty($lastName) && isset($phone) && !empty($phone) && isset($city) && !empty($city) && isset($birthday) && !empty($birthday) && isset($email) && !empty($email)) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $contact = new Contacts();
            $contact->addContact($firstName, $lastName, $phone, $city, $birthday, $email, $userId);
        } else {
            $errors[] = "Please give a valid email address";
        }
    } else {
        $errors[] = "All fields are required!";
    }
}
?>

<div class="create-form">
    <h1>ADD Contact</h1>
    <hr>
    <?php if (count($errors) > 0) echo $errors[0]; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="create-form-group">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname" required>
        </div>
        <div class="create-form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" required>
        </div>
        <div class="create-form-group">
            <label for="phone">Phone</label>
            <input type="number" name="phone" id="phone" required>
        </div>
        <div class="create-form-group">
            <label for="city">City</label>
            <input type="text" name="city" id="city" required>
        </div>
        <div class="create-form-group">
            <label for="birthday">Birthday</label>
            <input type="date" name="birthday" id="birthday" required>
        </div>
        <div class="create-form-group">
            <label for="email">E-mail</label>
            <input type="text" name="email" id="email" required>
        </div>
        <button class="btn-add-contact" name="btn-add-contact" type="submit">Add Contact</button>
    </form>
</div>


<?php
include('./includes/footer.php'); ?>