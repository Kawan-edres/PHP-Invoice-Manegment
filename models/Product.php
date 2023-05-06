<?php

namespace Details\models;

use Details\Database;
use Details\helpers\UtilHelper;

// require_once "helpers/checker.php";

class Product
{
    public ?int $id = null;
    public string $name;
    public string $description;
    public float $price;
    public array $imageFile;
    public ?string $imagePath = null;
    public int $userId;

    public function __construct($userid)
    {
        $this->userId = $userid;
    }



    public function load($data, $userId)
{
    
    $this->id = $data['id'] ?? null;
    $this->name = $data['name'];
    $this->description = $data['description'];
    $this->price = $data['price'];
    $this->imageFile = $data['imageFile'];
    $this->imagePath = $data['image'] ?? null;
    $this->userId = $userId;
}

    public function save()
    {
        $errors = [];
        if (!$this->name) $errors[] = "Product name is required ";
        if (!$this->price) $errors[] = "Product price is required ";
        if (!is_dir(__DIR__ . '/../assets/images')) {
            mkdir(__DIR__ . '/../assets/images');
        }
        if (empty($errors)) {

            if ($this->imageFile && $this->imageFile['tmp_name']) {
                if ($this->imagePath) {
                    unlink(__DIR__ . '/../assets/' . $this->imagePath);
                }
                $this->imagePath = 'images/' . UtilHelper::randomString(8) . '/' . $this->imageFile['name'];
                mkdir(dirname(__DIR__ . '/../assets/' . $this->imagePath));
                move_uploaded_file($this->imageFile['tmp_name'], __DIR__ . '/../assets/' . $this->imagePath);
            }

            $db = Database::$db;
            if ($this->id) {
                $db->updateProduct($this);
            } else {
                $db->createProduct($this);
            }
        }

        return $errors;
    }
}
