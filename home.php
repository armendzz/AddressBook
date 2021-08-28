<?php
include('./includes/header.php');

// check if user is logged in
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
}
require_once('./classes/Contacts.php');
$contacts = new Contacts();

$sortAvaibility = ['firstname', 'lastname', 'phone', 'email', 'city', 'birthday', 'addedon'];

if (isset($_GET['sort']) && in_array($_GET['sort'], $sortAvaibility) && !isset($_GET['search'])) {
    $allContacts = $contacts->mySortedContacts($_SESSION['user_id'], $_GET['sort']);
    $pagination = ceil(count($allContacts)/5);
    $pagenr = $_GET['page'];
    $start = $_GET['page'] * 5 - 5;
    $result = $contacts->mySortedContactsWithLimit($_SESSION['user_id'], $_GET['sort'], $start);
} elseif (isset($_GET['search']) && !isset($_GET['sort'])) {
    if(!isset($_GET['page'])){
        header('Location: home.php?search='.$_GET['search'].'&page=1');
    }
    $allContacts = $contacts->searchContacts($_SESSION['user_id'], htmlspecialchars($_GET['search']));
    $pagination = ceil(count($allContacts)/5);
    
    $pagenr = $_GET['page'];
    $start = $_GET['page'] * 5 - 5;
    $result = $contacts->searchContactsWithLimit($_SESSION['user_id'], htmlspecialchars($_GET['search']), $start);
} elseif (isset($_GET['sort']) && in_array($_GET['sort'], $sortAvaibility) && isset($_GET['search'])){
    
    $allContacts = $contacts->searchContacts($_SESSION['user_id'], htmlspecialchars($_GET['search']));
    $pagination = ceil(count($allContacts)/5);
    $pagenr = $_GET['page'];
    $start = $_GET['page'] * 5 - 5;
    $result = $contacts->searchContactsWithLimitAndSort($_SESSION['user_id'], htmlspecialchars($_GET['search']), $_GET['sort'], $start);
} else {
    $allContacts = $contacts->myContacts($_SESSION['user_id']);
    $pagination = ceil(count($allContacts)/5);
    if(isset($_GET['page'])){
        $pagenr = $_GET['page'];
        $start = $_GET['page'] * 5 - 5;
        $result = $contacts->myContactsWithLimit($_SESSION['user_id'], $start);
    } else {
        $result = $contacts->myContactsWithLimit($_SESSION['user_id'], '0');
    }
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
                <th>FirstName <a href="home.php?sort=firstname<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; } ?>"><img height="15px" src="icons/sort_icon.png"></a></th>  
                <th>LastName <a href="home.php?sort=lastname<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>Phone <a href="home.php?sort=phone<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>City <a href="home.php?sort=city<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>Birthday <a href="home.php?sort=birthday<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>E-mail <a href="home.php?sort=email<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th>Added on <a href="home.php?sort=addedon<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
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
                            <a href="update.php?id=<?php echo $person['id']; ?>"> <button class="btn-delete-contact" name="btn-delete-contact">EDIT</button> </a>
                            <form action="delete.php" method="post">
                                <input type="hidden" name="contactid" value="<?php echo $person['id'] ?>">
                                <button class="btn-delete-contact" name="btn-delete-contact">Delete</button>
                            </form>
                        </div>

                    </td>
                </tr>
            </tbody>
        <?php } ?>


    </table>
            <div class="pagination">
                <a href="<?php if(isset($_GET['sort'])) { echo 'home.php?sort=' . $_GET['sort'] . '&page=1';} else { echo 'home.php?page=1'; } if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } ?>">First</a> 
                <a href="home.php?page=<?php if($_GET['page'] <= 1){ echo '1';} else { echo $_GET['page'] - 1; } if(isset($_GET['sort'])){ echo '&sort=' . $_GET['sort']; } if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } ?>"> << Previous</a>
                <ul class="pagi-list">
                    <?php for($i = 1; $i <= $pagination; $i++){ ?>
                    <li class="pagi-item <?php if($_GET['page'] == $i){ echo 'pagi-item-active'; } ?>"><a href="<?php if(isset($_GET['sort'])){ echo 'home.php?sort='.$_GET['sort'].'&page='.$i; } else {echo 'home.php?page='.$i;} if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } ?>"><?php echo $i; ?></a></li>
                    <?php } ?>
                </ul>
                <a href="<?php if($_GET['page'] >= $pagination){ echo 'home.php?page=' . $pagination; } else { $nextpage = $_GET['page'] + 1;  echo "home.php?page=$nextpage"; } if(isset($_GET['sort'])){ echo '&sort=' . $_GET['sort']; } if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } ?>">Next >></a>
                <a href="<?php if(isset($_GET['sort'])) { echo 'home.php?sort=' . $_GET['sort'] . '&page=' . $pagination;} else { echo 'home.php?page='. $pagination; } if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } ?>">Last</a>
            </div>
</div>



<?php
include('./includes/footer.php'); ?>