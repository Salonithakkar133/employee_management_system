<?php
class UserController {
    private $db;
    private $user;

    public function __construct() {
        require_once 'config/database.php';
        require_once 'app/models/User.php';
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function list() {
        session_start();
        $users = $this->user->getAllUsers();
        include_once 'views/users/list.php';
    }

    public function add() {
        session_start();
        $message = '';
        if ($_POST) {
            $this->user->name = $_POST['name'];
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];
            $this->user->role = $_POST['role'];

            $result = $this->user->add();
            if ($result === true) {
                $message = "User added successfully.";
            } elseif ($result === "Email is already registered") {
                $message = "Email is already registered.";
            } else {
                $message = "Failed to add user.";
            }
        }
        include_once 'views/users/add.php';
    }

    public function edit() {
        session_start();
        $message = '';
        $user_id = isset($_GET['id']) ? $_GET['id'] : null;
        $user = $this->user->getUserById($user_id);

        if ($_POST) {
            $this->user->id = $_POST['user_id'];
            $this->user->role = $_POST['role'];
            if ($this->user->updateRole($this->user->id, $this->user->role)) {
                $message = "Role updated successfully.";
            } else {
                $message = "Failed to update role.";
            }
        }
        include_once 'views/users/edit.php';
    }

    public function update() {
        session_start();
        $message = '';
        $user_id = isset($_GET['id']) ? $_GET['id'] : null;
        $user = $this->user->getUserById($user_id);

        if ($_POST) {
            $this->user->id = $_POST['id'];
            $this->user->name = $_POST['name'];
            $this->user->email = $_POST['email'];
            $this->user->password = !empty($_POST['password']) ? $_POST['password'] : '';
            $this->user->role = $_POST['role'];

            $result = $this->user->update();
            if ($result === true) {
                $message = "User updated successfully.";
            } elseif ($result === "Email is already registered") {
                $message = "Email is already registered.";
            } else {
                $message = "Failed to update user.";
            }
        }
        include_once 'views/users/update.php';
    }

    public function delete() {
        session_start();
        $user_id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($this->user->delete($user_id)) {
            header("Location: index.php?page=users&message=User deleted successfully");
        } else {
            header("Location: index.php?page=users&message=Failed to delete user");
        }
        exit;
    }
}
?>