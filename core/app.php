<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'app/controllers/AuthController.php'; // Adjust path
require_once 'app/controllers/UserController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'login';
$authController = new AuthController();
$userController = new UserController();

switch ($page) {
    case 'login':
        $authController->login();
        break;
    case 'register':
        $authController->register();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'users':
        session_start();
        if (!isset($_SESSION['u_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=login");
            exit;
        }
        $userController->list();
        break;
    case 'edit_user':
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=login");
            exit;
        }
        $userController->edit();
        break;
    default:
        $authController->login();
}
?>