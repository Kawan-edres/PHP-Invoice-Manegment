<?php

namespace Details\controllers;

use Details\models\Product;
use Details\Router;
 include "helpers/checker.php" ;





class ProductController
{

    public static function index(Router $router) //atwani xo instance drust bkay la router 
    {
        $search = $_GET['search'] ?? '';
        $products = $router->db->getProducts($search);
        $router->renderView('products/index', [
            'products' => $products,
            'search' => $search

        ]);
    }

    public static function create(Router $router)
    {


        $userid = $_SESSION['user_id']  ;
        echo $userid;
        $errors = [];
        $productData = [
            'name' => '',
            'description' => '',
            'image' => '',
            'price' => '',
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData['name'] = $_POST['name'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = (float)$_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;
            $productData['user_id'] = $userid;
            //creating an instace of a product model 
            $product = new Product($userid);
            // adding data to the model 
            $product->load($productData,$userid);
            $errors = $product->save(); // we are checking for errors in model save function 
            if (empty($errors)) {
                header('Location: /products');
                exit;
            }
        }
        // else the error will  passed to to the render view products 
        $router->renderView('products/create', ['product' => $productData, 'errors' => $errors]);
    }

    public static function update(Router $router)
    {

        $userid = $_SESSION['user_id'] ;
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /products');
            exit;
        }
        $productData = $router->db->getProductById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData['name'] = $_POST['name'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = $_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            $product = new Product($userid);
            $product->load($productData,$userid);
            $product->save();
            header('Location: /products');
            exit;
        }

        //render update 
        $router->renderView('products/update', [
            'product' => $productData
        ]);
    }


    public static  function delete(Router $router)
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: /products');
            exit;
        }

        if ($router->db->deleteProduct($id)) {
            header('Location: /products');
            exit;
        }
    }
}
