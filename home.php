<?php
include('./includes/header.php');

// check if user is logged in
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
}
require_once('./classes/Contacts.php');
$contacts = new Contacts();

$sortAvaibility = ['firstname', 'lastname', 'phone', 'email', 'city', 'birthday', 'addedon'];

/* 
    check if user clicked on sort without searched anything
*/
if (isset($_GET['sort']) && in_array($_GET['sort'], $sortAvaibility) && !isset($_GET['search'])) {
/* 
    Get all contacts that belongs to logged in user
    sorted by clicked parameter
    and calculate pagination 
*/
    $allContacts = $contacts->mySortedContacts($_SESSION['user_id'], $_GET['sort']);
    $pagination = ceil(count($allContacts)/5);
    $pagenr = $_GET['page'];
    $start = $_GET['page'] * 5 - 5;
/*
    Get 5 contacts per page for logged in user, sorted by clicked parameter. 
*/
    $result = $contacts->mySortedContactsWithLimit($_SESSION['user_id'], $_GET['sort'], $start);

/* 
    check if user searched something and have not clicked on sort
*/
} elseif (isset($_GET['search']) && !isset($_GET['sort'])) {

    // send user to page 1, after user clicked on search button
    if(!isset($_GET['page'])){
        header('Location: home.php?search='.$_GET['search'].'&page=1');
    }

/*
    Get all contacts with given search term
    and calculate pagination
*/
    $allContacts = $contacts->searchContacts($_SESSION['user_id'], htmlspecialchars($_GET['search']));
    $pagination = ceil(count($allContacts)/5);
    
    $pagenr = $_GET['page'];
    $start = $_GET['page'] * 5 - 5;
/*    
    Get 5 contacts per page for logged in user, for given search term. 
*/
    $result = $contacts->searchContactsWithLimit($_SESSION['user_id'], htmlspecialchars($_GET['search']), $start);

/*
    check if user clicked on sort, on searched result
*/
} elseif (isset($_GET['sort']) && in_array($_GET['sort'], $sortAvaibility) && isset($_GET['search'])){
/*
    Get all contacts for logged in user with given search term
    and order by clicked sort parameter
    and calculate pagination
*/    
    $allContacts = $contacts->searchContacts($_SESSION['user_id'], htmlspecialchars($_GET['search']));
    $pagination = ceil(count($allContacts)/5);
    $pagenr = $_GET['page'];
    $start = $_GET['page'] * 5 - 5;

    // Get  contacts per page for logged in user for given search term and order by clicked parameter 
    $result = $contacts->searchContactsWithLimitAndSort($_SESSION['user_id'], htmlspecialchars($_GET['search']), $_GET['sort'], $start);
} else {

/*
    Get all contacts for logged in user
    and calculate paginations
*/    
    $allContacts = $contacts->myContacts($_SESSION['user_id']);
    $pagination = ceil(count($allContacts)/5);
    // check if user is on first page, then get contacts from 0
    if(!isset($_GET['page'])){
        $result = $contacts->myContactsWithLimit($_SESSION['user_id'], '0');
    } 
    else {
    // Get 5 contacts per page for logged in user 
        $pagenr = $_GET['page'];
        $start = $_GET['page'] * 5 - 5;
        $result = $contacts->myContactsWithLimit($_SESSION['user_id'], $start);
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
    <?php if(count($result) > 0): ?>
    <table class="contacts">
        <thead>
            <tr>
                <th><span class="th-title <?php if(isset($_GET['sort']) && $_GET['sort'] == 'firstname'){ echo 'th-title-active'; } ?>">FirstName</span><a href="home.php?sort=firstname<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; } ?>"><img height="15px" src="icons/sort_icon.png"></a></th>  
                <th><span class="th-title <?php if(isset($_GET['sort']) && $_GET['sort'] == 'lastname'){ echo 'th-title-active'; } ?>">LastName</span><a href="home.php?sort=lastname<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th><span class="th-title <?php if(isset($_GET['sort']) && $_GET['sort'] == 'phone'){ echo 'th-title-active'; } ?>">Phone</span><a href="home.php?sort=phone<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th><span class="th-title <?php if(isset($_GET['sort']) && $_GET['sort'] == 'city'){ echo 'th-title-active'; } ?>">City</span><a href="home.php?sort=city<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th><span class="th-title <?php if(isset($_GET['sort']) && $_GET['sort'] == 'birthday'){ echo 'th-title-active'; } ?>">Birthday</span><a href="home.php?sort=birthday<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th><span class="th-title <?php if(isset($_GET['sort']) && $_GET['sort'] == 'email'){ echo 'th-title-active'; } ?>">E-mail</span><a href="home.php?sort=email<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th><span class="th-title <?php if(isset($_GET['sort']) && $_GET['sort'] == 'addedon'){ echo 'th-title-active'; } ?>">Added on</span><a href="home.php?sort=addedon<?php if(isset($_GET['search'])){ echo '&search=' . $_GET['search']; } if(!isset($_GET['page'])){ echo '&page=1';} else { echo '&page='.$_GET['page']; }  ?>"><img height="15px" src="icons/sort_icon.png"></a></th>
                <th><span class="th-title">Action</span></th>
            </tr>
        </thead>
        <?php
        // list records on table
        foreach ($result as $contact) { ?>
            <tbody>
                <tr>
                    <td><span class="info"><?php echo $contact['firstname'] ?></span></td>
                    <td><span class="info"><?php echo $contact['lastname'] ?></span></td>
                    <td><span class="info"><?php echo $contact['phone'] ?></span></td>
                    <td><span class="info"><?php echo $contact['city'] ?></span></td>
                    <td><span class="info"><?php echo date("d-m-Y", strtotime($contact['birthday'])); ?></span></td>
                    <td><span class="info"><?php echo $contact['email'] ?></span></td>
                    <td><span class="info"><?php echo date("d-m-Y", strtotime($contact['addedon'])); ?></span></td>
                    <td>
                        <div class="actions-button">
                            <a href="update.php?id=<?php echo $contact['id']; ?>"> <button class="btn-delete-contact" name="btn-delete-contact">EDIT</button> </a>
                            <form action="delete.php" method="post">
                                <input type="hidden" name="contactid" value="<?php echo $contact['id'] ?>">
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

    <?php else : ?>

        <?php if(isset($_GET['search'])) : ?>
            <div class="no-result">
            No result for searched term: <strong><?php echo $_GET['search']; ?> </strong> <br><br> 
            Click <a href="add-contact.php">HERE</a> to add contacs.
        </div>
        <?php else : ?>

        <div class="no-result">
            You dont have any contats <br> <br>
            Click <a href="add-contact.php">HERE</a> to add contacs.
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>



<?php
include('./includes/footer.php'); ?>