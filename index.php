<?php
include('./includes/header.php');

if(isset($_SESSION['is_logged_in'])){
    if($_SESSION['is_logged_in'] === true){
        header("Location: home.php");
    }
} else {
    header("Location: login.php");
}

?>





<?php
include('./includes/footer.php'); ?>