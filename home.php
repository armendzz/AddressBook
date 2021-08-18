<?php
include('./includes/header.php');

if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
}
require_once('./classes/Contacts.php');
$contacts = new Contacts();

$sortAvaibility = ['firstname', 'lastname', 'phone', 'email', 'city', 'birthday', 'addedon'];

if (isset($_GET['sort']) && in_array($_GET['sort'], $sortAvaibility)) {
    $result = $contacts->mySortedContacts($_SESSION['user_id'], $_GET['sort']);
} else {
    $result = $contacts->myContacts($_SESSION['user_id']);
}
?>

<div class="home">
    <div class="add-more">
        <h2> <a href="add-contact.php">Add Contact</a></h2>
    </div>
    <table class="contacts">
        <thead>
            <tr>
                <th>FirstName <a href="home.php?sort=firstname"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>LastName <a href="home.php?sort=lastname"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>Phone <a href="home.php?sort=phone"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>City <a href="home.php?sort=city"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>Birthday <a href="home.php?sort=birthday"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>E-mail <a href="home.php?sort=email"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>Added <a href="home.php?sort=addedon"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php

        foreach ($result as $person) { ?>
            <tbody>
                <tr>
                    <td><?php echo $person['firstname'] ?></td>
                    <td><?php echo $person['lastname'] ?></td>
                    <td><?php echo $person['phone'] ?></td>
                    <td><?php echo $person['city'] ?></td>
                    <td><?php echo $person['birthday'] ?></td>
                    <td><?php echo $person['email'] ?></td>
                    <td><?php echo $person['addedon'] ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $person['id']; ?>"> <button name="btn-delete-contact">EDIT</button> </a>
                        <form action="delete.php" method="post">
                            <input type="hidden" name="contactid" value="<?php echo $person['id'] ?>">
                            <button name="btn-delete-contact">Delete</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        <?php } ?>


    </table>

</div>



<?php
include('./includes/footer.php'); ?>