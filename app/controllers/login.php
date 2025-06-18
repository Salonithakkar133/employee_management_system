<?php
session_start();
class Login extends Controller {
    public function index() {
        $this->view('auth/login');
    }

    public function register() {
        $this->view('auth/registration');
    }

    public function createUser() {
        require '../config/db.php';
        $first = $_POST['first_name'];
        $last = $_POST['last_name'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $confirm = $_POST['confirm_password'];

        if ($pass !== $confirm) {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: " . BASE_URL . "/Login/register");
            return;
        }

        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        $name = $first . ' ' . $last;
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashed]);
            $_SESSION['success'] = "Registered successfully.";
            header("Location: " . BASE_URL . "/Login");
        } catch (PDOException $e) {
            $_SESSION['error'] = "Email already exists.";
            header("Location: " . BASE_URL . "/Login/register");
        }
    }

    public function auth() {
        require '../config/db.php';
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: " . BASE_URL . "/Dashboard");
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: " . BASE_URL . "/Login");
        }
    }
}
?>
