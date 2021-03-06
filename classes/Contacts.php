<?php
require_once('./db/pdo.php');

class Contacts extends Database
{
    public $errors = [];

    // Method to add contact
    public function addContact($firstName, $lastName, $phone, $city, $birthday, $email, $notes, $userId)
    {
        $sql = "INSERT INTO `contacts` (`firstname`,`lastname`, `phone`, `city`, `birthday`, `email`, `notes`, `userid`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute([$firstName, $lastName, $phone, $city, $birthday, $email, $notes, $userId])) {
            header("Location: home.php?action=add&status=1");
        } else {

            header("Location: add-contact.php?action=add&status=0");
        }
        
   
    }

    // Method to get all contact that belongs to one user
    public function myContacts($userId)
    {
        $sql = "SELECT * FROM `contacts` WHERE `userid`=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function myContactsWithLimit($userId, $start)
    {
        $sql = "SELECT * FROM `contacts` WHERE `userid`=? LIMIT $start, 10";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // Method to get contacts with given search term that belongs to one user
    public function searchContacts($userId, $searchterm)
    {   
        $sql = "SELECT * FROM contacts WHERE ((`firstname` LIKE ?) OR (`lastname` LIKE ?) OR (`phone` LIKE ?) OR (`city` LIKE ?) OR (`birthday` LIKE ?) OR (`email` LIKE ?)) AND (`userid`=?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["%$searchterm%", "%$searchterm%", "%$searchterm%", "%$searchterm%", "%$searchterm%", "%$searchterm%", $userId]);
        return $stmt->fetchAll();
    }

    public function searchContactsWithLimit($userId, $searchterm, $start)
    {   
        $sql = "SELECT * FROM contacts WHERE ((`firstname` LIKE ?) OR (`lastname` LIKE ?) OR (`phone` LIKE ?) OR (`city` LIKE ?) OR (`birthday` LIKE ?) OR (`email` LIKE ?)) AND (`userid`=?) LIMIT $start, 10";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["%$searchterm%", "%$searchterm%", "%$searchterm%", "%$searchterm%", "%$searchterm%", "%$searchterm%", $userId]);
        return $stmt->fetchAll();
    }

    public function searchContactsWithLimitAndSort($userId, $searchterm, $sortBy ,$start)
    {   
        $sql = "SELECT * FROM contacts WHERE ((`firstname` LIKE ?) OR (`lastname` LIKE ?) OR (`phone` LIKE ?) OR (`city` LIKE ?) OR (`birthday` LIKE ?) OR (`email` LIKE ?)) AND (`userid`=?) ORDER BY $sortBy LIMIT $start, 10";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["%$searchterm%", "%$searchterm%", "%$searchterm%", "%$searchterm%", "%$searchterm%", "%$searchterm%", $userId]);
        return $stmt->fetchAll();
    }

    public function mySortedContacts($userId, $sortBy)
    {
        $sql = "SELECT * FROM `contacts` WHERE `userid`=? ORDER BY $sortBy";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function mySortedContactsWithLimit($userId, $sortBy, $start)
    {
        $sql = "SELECT * FROM `contacts` WHERE `userid`=? ORDER BY $sortBy LIMIT $start, 10";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getSingleContact($contactId, $userId)
    {
        $sql = "SELECT * FROM `contacts` WHERE `id`=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$contactId]);

        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll()['0'];


            if ($result > 0 && $result['userid'] == $userId) {
                return $result;
            } else {
                /* header("HTTP/1.1 401 Unauthorized");
                echo "You are unathorized for this action";
                die(); */
                header("Location: home.php?action=update&auth=0");
            }
        } else {
            echo "Contact not found";
            die();
        }
    }

    public function updateContact($firstName, $lastName, $phone, $city, $birthday, $email, $contactId, $userId, $notes)
    {
        $sql = "SELECT * FROM `contacts` WHERE `id`=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$contactId]);
        $result = $stmt->fetchAll()['0'];


        if ($result['userid'] == $userId) {
            $sql = "UPDATE `contacts` SET firstname=?, lastname=?, phone=?, city=?, birthday=?, email=?, notes=? WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$firstName, $lastName, $phone, $city, $birthday, $email, $notes, $contactId])) {
                header("Location: home.php?action=update&status=1");
            } else {
                header("Location: home.php?action=update&status=0");
            }
        } else {
            header("Location: home.php?action=update&auth=0");
        }
    }


    public function deleteContact($contactId, $userId)
    {
        $sql = "SELECT * FROM `contacts` WHERE `id`=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$contactId]);
        $result = $stmt->fetchAll()['0'];

        if ($result['userid'] == $userId) {
            $sql = "DELETE FROM `contacts` WHERE `id`=?";
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$contactId])) {
                header("Location: home.php?action=deleted&status=1");
            } else {
                header("Location: home.php?action=deleted&status=0");
            }
        } else {
            header("Location: home.php?action=deleted&auth=0");
        }
    }
}
