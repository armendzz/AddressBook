<?php
include('./includes/header.php');
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
}
require_once('./classes/Contacts.php');
include('./helpers/functions.php');

if (isset($_GET['id'])) {
    $contact = new Contacts();
    $person = $contact->getSingleContact($_GET['id'], $_SESSION['user_id']);
} elseif (strpos($_SERVER['HTTP_REFERER'], "update.php?id=") == true) {
    $id = explode("=", $_SERVER['HTTP_REFERER']);
    $contact = new Contacts();
    $person = $contact->getSingleContact($id['1'], $_SESSION['user_id']);
} else {
    header("Location: home.php?action=update&status=0");
}


$errors = [];

if (isset($_POST['btn-edit-contact'])) {

    $contactId = htmlspecialchars($_POST['contactid']);
    $firstName = htmlspecialchars($_POST['firstname']);
    $lastName = htmlspecialchars($_POST['lastname']);
    $phone = htmlspecialchars($_POST['phone']);
    $city = htmlspecialchars($_POST['city']);
    $birthday = htmlspecialchars($_POST['birthday']);
    $email = htmlspecialchars($_POST['email']);
    $notes = htmlspecialchars($_POST['notes']);
    $userId = $_SESSION['user_id'];

    if (isset($contactId) && !empty($contactId) && isset($firstName) && !empty($firstName) && isset($lastName) && !empty($lastName) && isset($phone) && !empty($phone) && isset($city) && !empty($city) && isset($birthday) && !empty($birthday) && isset($email) && !empty($email)) {
        if (strlen($firstName) < 255) {
            if (strlen($lastName) < 255) {
                if (isDigits($phone)) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if (strlen($city) < 500) {
                            if (checkIsAValidDate($birthday)) {
                                $contact->updateContact($firstName, $lastName, $phone, $city, $birthday, $email, $contactId, $userId, $notes);
                                
                            } else {
                                $errors[] = "Please give a valid date.";
                            }
                        } else {
                            $errors[] = "City should be max 500 characters.";
                        }
                    } else {
                        $errors[] = "Please give a valid email address";
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

    <h1>EDIT Contact</h1>
    <hr>
    <?php if (count($errors) > 0) : ?>
        <div class="alert">
            <div class="al-danger">
                <?php echo $errors[0]; ?>
            </div>
        </div>
    <?php endif; ?>

    <form action="update.php" method="post">
    <p><center>Fileds with * are required.</center></p>
        <input type="hidden" name="contactid" value="<?php echo $person['id']; ?>">
        <div class="create-form-group">
            <label for="firstname">First Name*</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo $person['firstname']; ?>" required>
        </div>
        <div class="create-form-group">
            <label for="lastname">Last Name*</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo $person['lastname']; ?>" required>
        </div>
        <div class="create-form-group">
            <label for="phone">Phone (only numbers)*</label>
            <input type="tel" name="phone" id="phone" value="<?php echo $person['phone']; ?>" required>
        </div>
        <div class="create-form-group">
            <label for="city">City*</label>
            <input type="text" name="city" id="city" value="<?php echo $person['city']; ?>" required>
        </div>
        <div class="create-form-group">
            <label for="birthday">Birthday*</label>
            <input type="date" name="birthday" id="birthday" value="<?php echo $person['birthday']; ?>" required>
        </div>
        <div class="create-form-group">
            <label for="email">E-mail*</label>
            <input type="text" name="email" id="email" value="<?php echo $person['email']; ?>" required>
        </div>
        <div class="create-form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" cols="30" rows="10"><?php echo $person['notes']; ?></textarea>
        </div>
        <div class="btn">
            <button class="btn-add-contact" name="btn-edit-contact" type="submit">Update Contact</button>
        </div>

    </form>
</div>


<?php
include('./includes/footer.php'); ?>