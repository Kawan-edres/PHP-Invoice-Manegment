<?php

namespace Details\controllers;

use Details\models\User;
use Details\Router;
use Details\Database;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public static function index(Router $router)
    {
        $router->renderView('signin');
    }
    public static function home(Router $router)
    {

        if (User::isLoggedIn()) {
            header('Location: /signin');
            exit;
        }
        $router->renderView('home');
    }
   

    public static function signUp(Router $router)
    {
        $userData = [
            'username' => '',
            'email' => '',
            'password' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData['username'] = $_POST['username'];
            $userData['email'] = $_POST['email'];
            $userData['password'] = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($userData['password'] !== $confirmPassword) {
                echo json_encode(['error' => 'Passwords do not match']);
                return;
            }
            // Check if username already exists
            $existingUser = User::getUserByUsername($userData['username']);
            if ($existingUser) {
                echo json_encode(['error' => 'Username already exists']);
                return;
            }

            $user = new User();
            $user->loadData($userData);
            $errors = $user->validation();
            if (empty($errors)) {
                $database = new Database();
                $database->createUser($user);
                echo json_encode(['success' => true]);
                return;
            }
            echo json_encode(['error' => $errors]);
            return;
        }

        $router->renderView('signup', ['model' => $userData]);
    }

    
    public static function signIn(Router $router)
    {
        session_start();
          
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['username'];
            $password = $_POST['password'];
           

        if (empty($username) || empty($password)) {
            echo json_encode(['error' => 'All fields are required']);
            return;
        }
        $existingUser = User::getUserByUsername($username);
       

        // var_dump(password_verify($password, $existingUser['password']));
        if (!$existingUser) {
            echo json_encode(['error' => 'Username Not Found']);
            return;
        }

        if (md5($password)!==$existingUser['password']) {
            
            echo json_encode(['error' => 'Invalid password']);
            return;
        }

        $_SESSION['user_id'] = $existingUser['id'];
        $_SESSION['user_name'] = $existingUser['username'];
        $_SESSION['user_email'] = $existingUser['email'];
        echo json_encode(['success' => true]);
        exit;

    }
    $router->renderView('signin');



    }

    public function logout(Router $router)
    {
        session_start();
        session_destroy();
        header("Location: /signin");
    }
    
}
