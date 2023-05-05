<?php

namespace Details;

use Details\models\User;
use Details\models\Product;
use PDO;

class Database
{

    public \PDO $pdo;
    public static Database $db;

    // constructure to connect with my sql 
    public function __construct()

    {
        $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=invoice_manegement', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db = $this;
    }

    // create user
    public function createUser(User $user)
    {

        $statement = $this->pdo->prepare("INSERT INTO users (username, email, password)
                VALUES (:username, :email, :password)");
        $statement->bindValue(':username', $user->username);
        $statement->bindValue(':email', $user->email);
        $statement->bindValue(':password', $user->password);

        $statement->execute();
    }

//  get products 
    public function getProducts($search = '')
    {


        if ($search) {
            $statment = $this->pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY  create_date DESC');
            $statment->bindValue(':title', "%$search%");
        } else {

            $statment = $this->pdo->prepare('SELECT * FROM products ORDER BY  create_date DESC');
        }


        $statment->execute();
        return $statment->fetchAll(PDO::FETCH_ASSOC); // how do you wanna get the data 

    }

    // create product 
    public function createProduct(Product $product)
    {
        $statement = $this->pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                VALUES (:title, :image, :description, :price, :date)");
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));

        $statement->execute();
    }

    // get product by id 
    public function getProductById($id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function updateProduct(Product $product)
    {
        $statement = $this->pdo->prepare("UPDATE products SET title = :title, 
                                        image = :image, 
                                        description = :description, 
                                        price = :price WHERE id = :id");
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':id', $product->id);

        $statement->execute();
    }

    public function deleteProduct($id)
    {
        $statement = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
        $statement->bindValue(':id', $id);

        return $statement->execute();
    }
}
