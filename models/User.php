<?php

namespace Details\models;

use Details\Database;
use PDO;

class User
{
    public ?int $id = null;
    public string $username;
    public string $email;
    public string $password;
    public string $is_admin;


    public function loadData($data)
    {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->password = md5($data['password']);
    }

    //for crearing protected route 
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
        
    }


    public function validation()
    {
        $errors = [];

        if (!$this->username || !$this->email  || !$this->password) {
            $errors[] = 'All fields are required';
            echo json_encode($errors);
            return;
        }

        return $errors;
    }
    // for search if user is exist or not 
    public static function getUserByUsername($username)
    {
        $db = Database::$db;
        $statement = $db->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindValue(':username', $username);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    // getting all users for amdin dashboard

    public static function getAllUsers()
{
    $db = Database::$db;
    $statement = $db->pdo->prepare("SELECT users.*, COUNT(DISTINCT products.id) AS product_count, COUNT(DISTINCT invoices.id) AS invoice_count
                                   FROM users
                                   LEFT JOIN products ON users.id = products.user_id
                                   LEFT JOIN invoices ON users.id = invoices.user_id
                                   GROUP BY users.id");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

}
