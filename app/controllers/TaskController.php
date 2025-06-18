<?php
class TaskController {
    private $db;
    private $task;
    private $user;

    public function __construct() {
        require_once 'config/database.php';
        require_once 'app/models/Task.php';
        require_once 'app/models/User.php';
        $database = new Database();
        $this->db = $database->getConnection();
        $this->task = new Task($this->db);
        $this->user = new User($this->db);
    }

    public function list() {
        session_start();
        $user_id = $_SESSION['id'];
        $role = $_SESSION['role'];
        $tasks = $this->task->readByUser($user_id, $role);
        include_once 'views/tasks/list.php';
    }

    public function add() {
        session_start();
        $message = '';
        if ($_POST) {
            $this->task->title = $_POST['title'];
            $this->task->description = $_POST['description'];
            $this->task->status = $_POST['status'];
            $this->task->assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : null;
            $this->task->created_by = $_SESSION['id'];
            $this->task->assigned_by_role = $_SESSION['role'];

            if ($this->task->create()) {
                $message = "Task added successfully.";
            } else {
                $message = "Failed to add task.";
            }
        }
        $users = $this->user->getAllUsers();
        include_once 'views/tasks/add.php';
    }

    public function edit() {
        session_start();
        $message = '';
        $task_id = isset($_GET['id']) ? $_GET['id'] : null;
        $task = $this->task->getTaskById($task_id);

        if ($_POST) {
            $this->task->id = $_POST['task_id'];
            $this->task->title = $_POST['title'];
            $this->task->description = $_POST['description'];
            $this->task->status = $_POST['status'];
            $this->task->assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : null;

            if ($this->task->update()) {
                $message = "Task updated successfully.";
            } else {
                $message = "Failed to update task.";
            }
        }
        $users = $this->user->getAllUsers();
        include_once 'views/tasks/edit.php';
    }

    public function delete() {
        session_start();
        if ($_SESSION['role'] === 'employee') {
            header("Location: index.php?page=dashboard");
            exit;
        }
        $task_id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($this->task->delete($task_id)) {
            header("Location: index.php?page=tasks&message=Task deleted successfully");
        } else {
            header("Location: index.php?page=tasks&message=Failed to delete task");
        }
        exit;
    }
}
?>