<?php 

session_start();

//only logged in user can access this page
if(!isset($_SESSION['is_logged_in'])){
    header("Location: login.php");
} 

require_once('./classes/Contacts.php');

// check if user clicked delete button
if (isset($_POST['btn-delete-contact'])) {

    $contactId = $_POST['contactid'];
    $userId = $_SESSION['user_id'];
    if (isset($contactId) && !empty($contactId)) {
       $contact = new Contacts();
       $contact->deleteContact($contactId, $userId);
    } else {
        if(isset($_SESSION['is_logged_in'])){
            if($_SESSION['is_logged_in'] === true){
                header("Location: home.php");
            }
        } else {
            header("Location: login.php");
        }
    }
}