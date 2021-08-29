<?php

include('./includes/header.php');
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
}
require_once('./classes/Contacts.php');
include('./helpers/functions.php');
$errors = [];

if (isset($_POST['btn-add-contact'])) {

    $firstName = htmlspecialchars($_POST['firstname']);
    $lastName = htmlspecialchars($_POST['lastname']);
    $phone = htmlspecialchars($_POST['phone']);
    $city = htmlspecialchars($_POST['city']);
    $birthday = htmlspecialchars($_POST['birthday']);
    $email = htmlspecialchars($_POST['email']);
    $userId = $_SESSION['user_id'];


    if (isset($firstName) && !empty($firstName) && isset($lastName) && !empty($lastName) && isset($phone) && !empty($phone) && isset($city) && !empty($city) && isset($birthday) && !empty($birthday) && isset($email) && !empty($email)) {
        if (strlen($firstName) < 255) {
            if (strlen($lastName) < 255) {
                if (isDigits($phone)) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if (strlen($city) < 500) {
                            if (checkIsAValidDate($birthday)) {
                                $contact = new Contacts();
                                $contact->addContact($firstName, $lastName, $phone, $city, $birthday, $email, $userId);
                            } else {
                                $errors[] = "Please give a valid date.";
                            }
                        } else {
                            $errors[] = "City should be max 500 characters.";
                        }
                    } else {
                        $errors[] = "Please give a valid email address.";
                    }
                } else {
                    $errors[] = "Please give a valid phone number. (only digits)";
                }
            } else {
                $errors[] = "Last name should be max 255 characters.";
            }
        } else {
            $errors[] = "First name should be max 255 characters.";
        }
    } else {
        $errors[] = "All fields are required!";
    }
}
?>

<div class="create-form">
    <h1>ADD Contact</h1>
    <hr>
    <?php if (count($errors) > 0) : ?>
        <div class="alert">
            <div class="al-danger">
                <?php echo $errors[0]; ?>
            </div>
        </div>
    <?php endif; ?>
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
            <label for="phone">Phone (only numbers)</label>
            <input type="tel" name="phone" id="phone" required>
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
        <div class="btn">
            <button class="btn-add-contact" name="btn-add-contact" type="submit">Add Contact</button>
        </div>

    </form>
</div>


<?php
include('./includes/footer.php'); ?>