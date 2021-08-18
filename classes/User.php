<?php

require_once('./db/pdo.php');


class User extends Database
{
    public $errors = [];

    public function register($username, $password)
    {

        $sql = "INSERT INTO `users` (`username`,`password`) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $passwordhash = password_hash($password, PASSWORD_BCRYPT);

        if ($stmt->execute([$username, $passwordhash])) {
            $_SESSION['username'] = $username;
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user_id'] = $this->pdo->lastInsertId();
            
            header("Location: home.php?action=register&status=1");
        } else {
            if ($stmt->errorInfo()['1'] == 1062) {
                header("Location: register.php?error=1062");
            } else {
                header("Location: register.php?action=register&status=0");
            }
        }
    }

    public function login($username, $password)
    {

        $sql = "SELECT * FROM `users` WHERE `username`=?";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$username]);

        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll()['0'];
            if (password_verify($password, $result['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['is_logged_in'] = true;
                $_SESSION['user_id'] = $result['id'];
                header("Location: home.php");
            } else {
                $this->errors[] = "Passowrd is incorrect";
            }
        } else {
            $this->errors[] = "User not found";
        }
    }
}
