<?php

namespace Details;

use Details\models\User;
use PDO;

class Database
{

    public \PDO $pdo;
    public static Database $db;

    public function __construct()

    {
        $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=invoice_manegement', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db = $this;
    }

    public function createUser(User $user)
    {

        $statement = $this->pdo->prepare("INSERT INTO users (username, email, password)
                VALUES (:username, :email, :password)");
        $statement->bindValue(':username', $user->username);
        $statement->bindValue(':email', $user->email);
        $statement->bindValue(':password', $user->password);

        $statement->execute();
    }
}
