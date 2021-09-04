<?php
include('./includes/header.php'); 

require_once('./classes/Contacts.php');
if (isset($_GET['id'])) {
    $contact = new Contacts();
    $person = $contact->getSingleContact($_GET['id'], $_SESSION['user_id']);
}
?>


<div class="card">
    <div class="card-header">
        All Info
    </div>
    <div class="card-body">
        <div class="card-group">
        <div class="avatar">
            <img height="120px" src="https://aui.atlassian.com/aui/latest/docs/images/avatar-person.svg" alt="">
        </div>
        <div class="card-info">
        <div class="single-info"><span class="single-attributes">First Name: </span><span class="single-data"><strong><?php echo $person['firstname']; ?></strong></span></div>
        <div class="single-info"><span class="single-attributes">Last Name: </span><span class="single-data"><strong><?php echo $person['lastname']; ?></strong></span></div>
        <div class="single-info"><span class="single-attributes">Phone: </span><span class="single-data"><strong><?php echo $person['phone']; ?></strong></span></div>
        <div class="single-info"><span class="single-attributes">City: </span><span class="single-data"><strong><?php echo $person['city']; ?></strong></span></div>
        <div class="single-info"><span class="single-attributes">Birthday: </span><span class="single-data"><strong><?php echo $person['birthday']; ?></strong></span></div>
        <div class="single-info"><span class="single-attributes">E-mail: </span><span class="single-data"><strong><?php echo $person['email']; ?></strong></span></div>
        <div class="single-info"><span class="single-attributes">Added on: </span><span class="single-data"><strong><?php echo $person['addedon']; ?></strong></span></div>
        </div>
        </div>
      
        <div class="notes">
           <h4> Other Notes</h4>
           <br>
           <p>
           <?php echo $person['notes']; ?>
           </p>
        </div>
        <hr>
        <div class="quick-action">
            <span>Quick Action: </span> <div class="action">
                <a href="tel:<?php echo $person['phone']; ?>">Call</a>
                <a href="mailto:<?php echo $person['email']; ?>">E-mail</a>
            </div>
        </div>
    </div>
</div>



<?php
include('./includes/footer.php'); ?>