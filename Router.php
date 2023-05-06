<?php

namespace Details;

use Details\controllers\ProductController;
use Details\controllers\UserController;
use Details\models\User;


class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];
    public Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }
    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }
    public function resolve() //detects what is the current route 
    {
        $currentUrl = $_SERVER['REQUEST_URI'] ?? "/";
        $method = $_SERVER['REQUEST_METHOD'];
        $action = $_GET['action'] ?? '';

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        }
        else if($method === 'POST' && $action === 'signup'){
            $fn = [UserController::class, 'signup'];
        }
        else if($method==='POST' && $action==='signin'){
            $fn = [UserController::class, 'signin'];
        }
        else if($method==='POST' && $action==='create_product'){
            $fn = [ProductController::class, 'create'];
        }
        else if($method==='POST' && $action==='update_product'){
            $fn = [ProductController::class, 'update'];
        }
       
         else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }
        if ($fn) {
                // echo "<pre>";
                // var_dump($this->getRoutes);
                // echo "</pre>";
            call_user_func($fn, $this); //aw func   tiona render bka ka dawa krawa ka rendery view aka  wa $this routery pe anerin  wakw parameter   
        }
            //  else {
            //     echo 'page not found';
            // }
    }
    public function renderView($view, $params = [])  //products/index.php
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start(); //cashing out in browser  put  it wont send to the browser it will save it in the buffer
        include_once __DIR__ . "/views/$view.php"; //and save it in content varibale 
        $content = ob_get_clean(); //now view file is saved in $content and its inside _layout
        include_once __DIR__ . "/views/_layout.php";
    }
}
