<?php
require_once('./db/pdo.php');

class Contacts extends Database
{
    public $errors = [];

    public function addContact($firstName, $lastName, $phone, $city, $birthday, $email, $userId)
    {
        $sql = "INSERT INTO `contacts` (`firstname`,`lastname`, `phone`, `city`, `birthday`, `email`, `userid`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        /* $stmt->execute(["armend", "zekjiri", "234231234121234215", "Oberhausen", "1992-09-12", "armendzekjiri@gmail.com", "33"]);
        print_r($stmt->errorInfo()); */
        if ($stmt->execute([$firstName, $lastName, $phone, $city, $birthday, $email, $userId])) {
            header("Location: home.php?action=insert&status=1");
        } else {

            header("Location: add-contact.php?action=insert&status=0");
        }
    }

    public function myContacts($userId)
    {
        $sql = "SELECT * FROM `contacts` WHERE `userid`=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }


    public function getSingleContact($contactId, $userId)
    {
        $sql = "SELECT * FROM `contacts` WHERE `id`=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$contactId]);
        $result = $stmt->fetchAll()['0'];

        if ($result['userid'] == $userId) {
            return $result;
        } else {
            header("Location: home.php?action=edit&auth=0");
        }
    }

    public function updateContact($firstName, $lastName, $phone, $city, $birthday, $email, $contactId, $userId)
    {
        $sql = "SELECT * FROM `contacts` WHERE `id`=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$contactId]);
        $result = $stmt->fetchAll()['0'];


        if ($result['userid'] == $userId) {
            $sql = "UPDATE `contacts` SET firstname=?, lastname=?, phone=?, city=?, birthday=?, email=?  WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$firstName, $lastName, $phone, $city, $birthday, $email, $contactId])) {
                header("Location: home.php?action=insert&status=1");
            } else {
                header("Location: home.php?action=insert&status=0");
            }
        } else {
            header("Location: home.php?action=edit&auth=0");
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
            header("Location: home.php?action=delete&auth=0");
        }
    }
}
