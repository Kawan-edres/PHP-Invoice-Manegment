<?php

namespace Details\controllers;

use Details\models\Product;
use Details\Router;


$userid= $_SESSION['user_id'] ?? "";
$username= $_SESSION['user_name'] ?? "";
$useremail= $_SESSION['user_email'] ?? "";
if(!$userid) {
    header("Location:/");
    exit();
}





class ProductController
{

    public static function index(Router $router) //atwani xo instance drust bkay la router 
    {
        $search = $_GET['search'] ?? '';
        $products = $router->db->getProducts($search);
        $router->renderView('products/product', [
            'products' => $products,
            'search' => $search

        ]);
    }

    public static function create(Router $router)
    {


        $userid = $_SESSION['user_id']  ;
        
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
                header('Content-Type: application/json');
                echo json_encode(['success' => 'Product created successfully!']);
                exit;
            }
            
            // If there are errors, return them as an AJAX response
            header('Content-Type: application/json');
            echo json_encode(['error' => $errors]);
            exit;
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
        echo "<pre>";
        print_r($productData);
        echo "</pre>";
 
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $productData) {
            $productData['name'] = $_POST['name'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = $_POST['price'];
            $productData['image'] = $_FILES['image'] ?? null;

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
    


    public static function delete(Router $router)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? null;
    echo $id;
    if (!$id) {
        header('Location: /products');
        exit;
    }

    $success = $router->db->deleteProduct($id);
    if ($success) {
        header('Content-Type: application/json');
        header("Location:/products");
        echo json_encode(['success' => 'Product deleted successfully!']);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Failed to delete product.']);
        exit;
    }
}

}

}
