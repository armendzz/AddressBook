<?php
define('__ROOT__', dirname(dirname(__FILE__)));


class Database
{
    protected $pdo;

    function __construct()
    {

        require(__ROOT__ . '/db/config.php');
        $dsn = "mysql:=$host;dbname=$dbname;charset=$charset";

        try {
            $this->pdo = new PDO($dsn, $user, $password, $opt);
        } catch (PDOException $e) {
            echo $e->getmessage();
            die();
        }
    }

    public function tableExists($table)
    {
            try {
                $sql = "SELECT 1 FROM `{$table}` LIMIT 1";

                $result = $this->pdo->query($sql);

            } catch (Exception $e) {
                return FALSE;
            }
            return $result !== FALSE;
        
    }


    public function install()
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sqls = [
                "CREATE TABLE IF NOT EXISTS `users` (
            id INT(11) AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            registered TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )",

                "CREATE TABLE IF NOT EXISTS `contacts` (
                id INT(11) AUTO_INCREMENT PRIMARY KEY, 
                firstname VARCHAR(255) NOT NULL,
                lastname VARCHAR(255) NOT NULL,
                phone BIGINT(30) NOT NULL,
                city TEXT NOT NULL,
                birthday DATE NOT NULL,
                email VARCHAR(300) NOT NULL,
                userid INT(11) NOT NULL,
                addedon TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                notes TEXT NULL
                )"

            ];
            foreach ($sqls as $sql) {
                $this->pdo->exec($sql);
            }
            header('Location: ../index.php');
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    public function rawQuery($query){
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}
