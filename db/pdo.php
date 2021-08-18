<?php
define('__ROOT__', dirname(dirname(__FILE__)));


class Database
{
    protected $pdo;

    function __construct()
    {
        require_once(__ROOT__.'/db/config.php');
        $dsn = "mysql:=$host;dbname=$dbname;charset=$charset";
        $this->pdo = new PDO($dsn, $user, $password, $opt);
    }

    public function read()
    {
        $sql = "SELECT * FROM `users`";

        $stmt = $this->pdo->query($sql);

        while ($row = $stmt->fetch()) {
            print_r($row);
        }
    }
}


