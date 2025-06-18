<?php
require_once 'app/models/User.php';

class AuthController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function login() {
        $error = '';
        error_log("Entering login method");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST data: " . print_r($_POST, true));
            $this->user->email = trim($_POST['email']);
            error_log("Login attempt: Email = " . $this->user->email);
            $user = $this->user->login();
            error_log("User query result: " . print_r($user, true));
            if ($user) {
                error_log("Stored hash: " . $user['password']);
                $password_verify = password_verify(trim($_POST['password']), $user['password']);
                error_log("Password verify: " . ($password_verify ? 'true' : 'false'));
                if ($password_verify) {
                    if ($user['role'] === 'pending') {
                        $error = "Your account is pending. Contact the admin to assign a role.";
                        error_log("Login failed: Pending role");
                    } else {
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['role'] = $user['role'];
                        error_log("Login successful: User ID = " . $user['id'] . ", Role = " . $user['role']);
                        header("Location: index.php?page=dashboard");
                        error_log("Redirect header sent");
                        exit;
                    }
                } else {
                    $error = "Invalid email or password";
                    error_log("Login failed: Password mismatch");
                }
            } else {
                $error = "Invalid email or password";
                error_log("Login failed: No user found");
            }
        } else {
            error_log("No POST request");
        }
        error_log("Rendering login page with error: $error");
        include_once 'views/auth/login.php';
    }

    public function register() {
        // ... (unchanged, assuming provided code)
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
?>