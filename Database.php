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
        $statement = $this->pdo->prepare("INSERT INTO users (username, email, password, is_admin)
    VALUES (:username, :email, :password, :is_admin)");
        $statement->bindValue(':username', $user->username);
        $statement->bindValue(':email', $user->email);
        $statement->bindValue(':password', $user->password);
        $statement->bindValue(':is_admin', 0); // Set default value to 0

        $statement->execute();
    }

    //get product 
    public function getProducts($search = '')
    {
        if ($search) {
            $statement = $this->pdo->prepare('SELECT * FROM products WHERE user_id = :user_id AND name LIKE :name ORDER BY create_date DESC');
            $statement->bindValue(':name', "%$search%");
        } else {
            $statement = $this->pdo->prepare('SELECT * FROM products WHERE user_id = :user_id ORDER BY create_date DESC');
        }
        $statement->bindValue(':user_id', $_SESSION['user_id']);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getInvoiceDetail($invoice_id)
    {
        $statement = $this->pdo->prepare('SELECT invoice_items.id, invoice_items.invoice_id, invoice_items.quantity, invoice_items.price, products.name FROM invoice_items INNER JOIN products ON invoice_items.product_id = products.id WHERE invoice_items.invoice_id = :invoice_id');
        $statement->bindValue(':invoice_id', $invoice_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // create product 
    public function createProduct(Product $product)
    {
        $statement = $this->pdo->prepare("INSERT INTO products (name, image, description, price, user_id, create_date)
        VALUES (:name, :image, :description, :price, :user_id, :date)");

        $statement->bindValue(':name', $product->name);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));
        $statement->bindValue(':user_id', $product->userId);

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
        $statement = $this->pdo->prepare("UPDATE products SET name = :name, 
                                            image = :image, 
                                            description = :description, 
                                            price = :price WHERE id = :id");
        $statement->bindValue(':name', $product->name);
        if ($product->imagePath) {
            $statement->bindValue(':image', $product->imagePath);
        } else {
            $statement->bindValue(':image', null, PDO::PARAM_NULL);
        }

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

    public function getInvoices()
    {
        $statement = $this->pdo->prepare('SELECT * FROM invoices WHERE user_id = :user_id');
        $statement->bindValue(':user_id', $_SESSION['user_id']);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createInvoices($total)
    {
        $statement = $this->pdo->prepare('INSERT INTO invoices (user_id, total) VALUES (:user_id,:total)');
        $statement->bindValue(":user_id", $_SESSION["user_id"]);
        $statement->bindValue(":total", $total);
        $statement->execute();

        return $this->pdo->lastInsertId();
    }

    public function createInvoiceItem($data)
    {
        $statement = $this->pdo->prepare('INSERT INTO invoice_items (invoice_id, product_id, quantity, price) 
        VALUES (:invoiceId, :productId, :quantity, :price)');
        $statement->bindValue(":invoiceId", $data->invoice_id);
        $statement->bindValue(":productId", $data->product_id);
        $statement->bindValue(":quantity", $data->qty);
        $statement->bindValue(":price", $data->price);
        $statement->execute();
    }
}
