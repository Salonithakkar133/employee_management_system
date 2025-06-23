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
                        $_SESSION['id'] = $user['id'];
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
        include_once 'app/views/auth/login.php';
    }

    public function register() {
        $error = '';
        error_log("Entering register method");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST data: " . print_r($_POST, true));
            $this->user->name = trim($_POST['name']);
            $this->user->email = trim($_POST['email']);
            $this->user->password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
            $this->user->role = 'pending'; 
            try {
                if ($this->user->register()) {
                    error_log("Registration successful: Email = " . $this->user->email);
                     $message = "Registration successful. Please contact admin to assign a role.";
                    include_once 'app/views/auth/registration.php';
                    return;
                    
                    } 
                     else {
                    $error = "Registration failed. Email may already exist.";
                    error_log("Registration failed: Email = " . $this->user->email);
                }
            } catch (Exception $e) {
                $error = "Error: " . $e->getMessage();
                error_log("Registration error: " . $e->getMessage());
            }
        }
        error_log("Rendering register page with error: $error");
        include_once 'app/views/auth/registration.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
?>