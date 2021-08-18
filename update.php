<?php
include('./includes/header.php');
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
}
require_once('./classes/Contacts.php');


if(isset($_GET['id'])){
    $contact = new Contacts();
    $person = $contact->getSingleContact($_GET['id'], $_SESSION['user_id']);
} else {
    header("Location: home.php?action=error");
}

$errors = [];

if (isset($_POST['btn-edit-contact'])) {
   
    $contactId = $_POST['contactid'];
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $userId = $_SESSION['user_id'];
    
    if (isset($contactId) && !empty($contactId) && isset($firstName) && !empty($firstName) && isset($lastName) && !empty($lastName) && isset($phone) && !empty($phone) && isset($city) && !empty($city) && isset($birthday) && !empty($birthday) && isset($email) && !empty($email)) {
       $contact = new Contacts();
       $contact->updateContact($firstName, $lastName, $phone, $city, $birthday, $email, $contactId, $userId);

    } else {
        $errors[] = "All fields are required!";
    }
}

?>


<div class="create-form">
    
    <h1>EDIT Contact</h1>
    <hr>
    <?php if(count($errors) > 0) echo $errors[0]; ?>
    <form action="update.php" method="post">
    <input type="hidden" name="contactid" value="<?php echo $person['id']; ?>">
        <div class="create-form-group">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo $person['firstname']; ?>">
        </div>
        <div class="create-form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo $person['lastname']; ?>">
        </div>
        <div class="create-form-group">
            <label for="phone">Phone</label>
            <input type="number" name="phone" id="phone" value="<?php echo $person['phone']; ?>">
        </div>
        <div class="create-form-group">
            <label for="city">City</label>
            <input type="text" name="city" id="city" value="<?php echo $person['city']; ?>">
        </div>
        <div class="create-form-group">
            <label for="birthday">Birthday</label>
            <input type="date" name="birthday" id="birthday" value="<?php echo $person['birthday']; ?>">
        </div>
        <div class="create-form-group">
            <label for="email">E-mail</label>
            <input type="text" name="email" id="email" value="<?php echo $person['email']; ?>">
        </div>
        <button class="btn-add-contact" name="btn-edit-contact" type="submit">Add Contact</button>
    </form>
</div>


<?php
include('./includes/footer.php'); ?>