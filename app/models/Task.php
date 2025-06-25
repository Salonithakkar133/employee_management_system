<?php
class Task {
    private $conn;
    private $table_name = "tasks";
    public $id;
    public $title;
    public $description;
    public $status;
    public $assigned_to;
    public $created_by;
    public $assigned_by_role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
       $query = "INSERT INTO tasks (title, description, status, assigned_to, created_by, start_date, end_date) 
          VALUES (:title, :description, :status, :assigned_to, :created_by, :start_date, :end_date)";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(string: strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->assigned_to = $this->assigned_to ? htmlspecialchars(strip_tags($this->assigned_to)) : null;
        $this->created_by = htmlspecialchars(strip_tags($this->created_by));
        $this->start_date = $_POST['start_date'];
        $this->end_date = $_POST['end_date'];

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":assigned_to", $this->assigned_to, PDO::PARAM_INT);
        $stmt->bindParam(":created_by", $this->created_by);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);


        return $stmt->execute();
    }

    public function readAll() {
    $query = "SELECT t.*, u.name as assigned_to, c.name as created_by 
              FROM " . $this->table_name . " t 
              LEFT JOIN users u ON t.assigned_to = u.id
              LEFT JOIN users c ON t.created_by = c.id
              WHERE t.is_deleted = 0";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}


public function readByUser($user_id, $role) {
    if ($role === 'employee') {
        // Only assigned and not deleted
        $query = "SELECT 
                    t.*, 
                    t.assigned_to AS assigned_to_id,
                    a.name AS assigned_to, 
                    c.name AS created_by 
                  FROM tasks t 
                  LEFT JOIN users a ON t.assigned_to = a.id 
                  LEFT JOIN users c ON t.created_by = c.id 
                  WHERE t.assigned_to = :user_id AND t.is_deleted = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
    } else {
        // Admin and TL see all tasks, including deleted ones
        $query = "SELECT 
                    t.*, 
                    t.assigned_to AS assigned_to_id,
                    a.name AS assigned_to, 
                    c.name AS created_by 
                  FROM tasks t 
                  LEFT JOIN users a ON t.assigned_to = a.id 
                  LEFT JOIN users c ON t.created_by = c.id";
        $stmt = $this->conn->prepare($query);
    }

    $stmt->execute();
    return $stmt;
}


    public function getTaskById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE tasks SET title = :title, description = :description, status = :status, assigned_to = :assigned_to,
          start_date = :start_date, end_date = :end_date WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->assigned_to = $this->assigned_to ? htmlspecialchars(strip_tags($this->assigned_to)) : null;
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->start_date = $_POST['start_date'];
        $this->end_date = $_POST['end_date'];
        
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":assigned_to", $this->assigned_to, PDO::PARAM_INT);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);


        return $stmt->execute();
    }

    public function updateStatusOnly() {
        $query = "UPDATE tasks SET status = :status WHERE id = :id AND assigned_to = :assigned_to";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":assigned_to", $_SESSION['id']);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }


    public function getAllTasks() {
        $query = "SELECT * FROM tasks WHERE is_deleted = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getDeletedTasks() {
        $query = "SELECT t.*, u.name as assigned_to, c.name as created_by 
                  FROM tasks t 
                  LEFT JOIN users u ON t.assigned_to = u.id 
                  LEFT JOIN users c ON t.created_by = c.id 
                  WHERE t.is_deleted = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function softDelete($id) {
    $query = "UPDATE tasks SET is_deleted = 1 WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

public function restore($id) {
    $query = "UPDATE tasks SET is_deleted = 0 WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

}
?>
