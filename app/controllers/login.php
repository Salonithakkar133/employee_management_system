<?php
class Login extends Controller {
    public function index() {
        $this->view('auth/login');
    }

    public function register() {
        $this->view('auth/registration');
    }

    public function createUser() {
        require '../config/db.php'; // Adjust if needed
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$name, $email, $password]);
            $_SESSION['success'] = "User registered successfully.";
            header("Location: /employee_management_system/public/Login");
        } catch (PDOException $e) {
            $_SESSION['error'] = "Email already exists.";
            header("Location: /employee_management_system/public/Login/registration");
        }
    }
}
