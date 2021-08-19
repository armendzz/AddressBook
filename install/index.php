<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Install AddressBook</title>
</head>
<body>
    <div class="container">
        <h1>Install AddressBook</h1>
        <br><br>
        <div class="install">
            Checking database connection. <br><br><br>
            <div class="msg-danger">
             <?php

                require_once('../db/pdo.php');

                $db = new Database()
                ?>
            </div>
           
            <div class="msg-success">
            Connection to database is established.
            <br>
            <br>
            <?php

                if ($db->tableExists("contacts") && $db->tableExists("users")){
                    echo "AddressBook is already installed, please delete folder install";
                    die();
                }
                
                ?>
                
            </div>

            <form action="install.php" method="post">
                <button name="btn-install" class="btn-install">Install</button>
            </form>
        </div>
    </div>
</body>
</html>