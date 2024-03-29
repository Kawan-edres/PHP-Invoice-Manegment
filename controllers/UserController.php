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

        if (!User::isLoggedIn()) {
            header('Location: /signin');
            exit;
        }
        $router->renderView('home');
    }
    public static function dashboard(Router $router)
    {

        if (!User::isLoggedIn()) {
            header('Location: /signin');
            exit;
        }

         // Handle delete user request
         if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
            $userId = $_POST['user_id'];
            $database = new Database();
            $success = $database->deleteUser($userId);

            if ($success) {
                // User deleted successfully
                // You can redirect to the updated user list or display a success message
                header('Location: /dashboard');
                exit;
            } else {
                // Error occurred while deleting the user
                // You can redirect to the user list or display an error message
                header('Location: /dashboard');
                exit;
            }
        }

        $users = User::getAllUsers();

        $router->renderView('dashboard',['users' => $users]);
    }
   

    public static function signup(Router $router)
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            if (empty($username) || empty($password)) {
                echo json_encode(['error' => 'All fields are required']);
                return;
            }
    
            $existingUser = User::getUserByUsername($username);
    
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
    
            // Check if the user is an admin
            if ($existingUser['is_admin']) {
                $_SESSION['is_admin'] = true;
            }
    
            echo json_encode(['success' => true]);
            exit;
    
        }
    
        $router->renderView('signin');
    }
    

    public function logout(Router $router)
    {
     
        session_destroy();
        header("Location: /signin");
    }
    
}
