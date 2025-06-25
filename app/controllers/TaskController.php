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
        
        $user_id = $_SESSION['id'];
        $role = $_SESSION['role'];
        $tasks = $this->task->readByUser($user_id, $role);
        include_once 'app/views/tasks/list.php';
    }

    public function add() {
       
        $message = '';
        $users = $this->user->getAllUsers();
        if ($_POST) {
            $this->task->title = $_POST['title'];
            $this->task->description = $_POST['description'];
            $this->task->status = $_POST['status'];
            $this->task->assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : null;
            $this->task->created_by = $_SESSION['id'];
            $this->task->assigned_by_role = $_SESSION['role'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

                if (strtotime($end_date) < strtotime($start_date)) {
                    $message = "End Date must be greater than Start Date.";
                        include_once 'app/views/tasks/add.php';
                        return;
                    }

            if ($this->task->create()) {
                $message = "Task added successfully.";
            } else {
                $message = "Failed to add task.";
            }
        }
       
        include_once 'app/views/tasks/add.php';
    }

    public function edit() {
    $message = '';
    $task_id = isset($_GET['id']) ? $_GET['id'] : null;
    $task = $this->task->getTaskById($task_id);
    $role = $_SESSION['role'];
    $user_id = $_SESSION['id'];

    // Restrict employees from editing others' tasks
    if ($role === 'employee' && $task['assigned_to'] != $user_id) {
        die("Unauthorized access.");
    }

    $users = $this->user->getAllUsers(); //Ensure users are available for dropdown

    if ($_POST) {
        $this->task->id = $_POST['task_id'];

        if ($role === 'employee') {
            // Employees can only update status
            $this->task->status = $_POST['status'];
            $this->task->assigned_to = $user_id;

            if ($this->task->updateStatusOnly()) {
                $message = "Status updated successfully.";
            } else {
                $message = "Failed to update status.";
            }
        } else {
            // Admin or Team Leader can update all fields
            $this->task->title = $_POST['title'];
            $this->task->description = $_POST['description'];
            $this->task->status = $_POST['status'];
            $this->task->assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : null;
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            // ✅ Validate dates
            if (strtotime($end_date) < strtotime($start_date)) {
                $message = "End Date must be greater than Start Date.";
                include_once 'app/views/tasks/edit.php';
                return;
            }

            // Pass to model
            $this->task->start_date = $start_date;
            $this->task->end_date = $end_date;

            if ($this->task->update()) {
                $message = "Task updated successfully.";
            } else {
                $message = "Failed to update task.";
            }
        }
    }

    include_once 'app/views/tasks/edit.php';
}

    // For employee status-only update


public function delete_task() {
    $id = $_GET['id'] ?? null;
    if ($id && $this->task->softDelete($id)) {
        header("Location: index.php?page=tasks&message=Task+deleted+successfully");
    } else {
        header("Location: index.php?page=tasks&message=Failed+to+delete+task");
    }
}

public function restore_task() {
    $id = $_GET['id'] ?? null;
    if ($id && $this->task->restore($id)) {
        header("Location: index.php?page=tasks&message=Task+restored+successfully");
    } else {
        header("Location: index.php?page=tasks&message=Failed+to+restore+task");
    }
}
public function view() {
    $task_id = isset($_GET['id']) ? $_GET['id'] : null;
    if ($task_id === null) {
        header("Location: index.php?page=tasks&message=Invalid task ID");
        exit;
    }

    $task = $this->task->getTaskById($task_id);
    //var_dump($task); // Add before include_once
    if ($task === false || $task === null) {
        header("Location: index.php?page=tasks&message=Task not found");
        exit;
    }


    include_once 'app/views/tasks/view.php';
}

}
?>
