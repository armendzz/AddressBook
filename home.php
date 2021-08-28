<?php
include('./includes/header.php');

// check if user is logged in
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

if (isset($_GET['search'])) {
    $result = $contacts->searchContacts($_SESSION['user_id'], htmlspecialchars($_GET['search']));
}

?>

<div class="home">
    <div class="add-more">
    <form action="home.php">
       <div class="search-box">
           <input type='text' id="searchb" placeholder="Search by: First Name or Last Name or City etc.." name='search'><button class="btn-search" type="submit">search</button>
       </div>
       </form>
        <h2 class="add-link"> <a href="add-contact.php"> + Add Contact</a></h2>
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
                <th>Added on <a href="home.php?sort=addedon"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php

        foreach ($result as $person) { ?>
            <tbody>
                <tr>
                    <td><span class="info"><?php echo $person['firstname'] ?></span></td>
                    <td><span class="info"><?php echo $person['lastname'] ?></span></td>
                    <td><span class="info"><?php echo $person['phone'] ?></span></td>
                    <td><span class="info"><?php echo $person['city'] ?></span></td>
                    <td><span class="info"><?php echo date("d-m-Y", strtotime($person['birthday'])); ?></span></td>
                    <td><span class="info"><?php echo $person['email'] ?></span></td>
                    <td><span class="info"><?php echo date("d-m-Y", strtotime($person['addedon'])); ?></span></td>
                    <td>
                        <div class="actions-button">
                            <a href="update.php?id=<?php echo $person['id']; ?>"> <button name="btn-delete-contact">EDIT</button> </a>
                            <form action="delete.php" method="post">
                                <input type="hidden" name="contactid" value="<?php echo $person['id'] ?>">
                                <button name="btn-delete-contact">Delete</button>
                            </form>
                        </div>

                    </td>
                </tr>
            </tbody>
        <?php } ?>


    </table>

</div>



<?php
include('./includes/footer.php'); ?>