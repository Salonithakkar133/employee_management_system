<?php
include("config/database.php");
class User {
    private $conn;
    private $table_name = "users";
    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public function __construct() {
      $db=new Database();  
        $this->conn =$db->getConnection();
        
    }

    public function register() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, email=:email, password=:password, role=:role";
        $stmt = $this->conn->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->role = 'pending';

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return "Email is already registered";
            }
            return false;
        }
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
    $query = "SELECT * FROM users";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}    
public function getUserById($id) {
        $query = "SELECT id, name, email, role FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, email=:email, password=:password, role=:role";
        $stmt = $this->conn->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->role = htmlspecialchars(strip_tags($this->role));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return "Email is already registered";
            }
            return false;
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, email=:email, role=:role";
        if (!empty($this->password)) {
            $query .= ", password=:password";
        }
        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":id", $this->id);
        
        if (!empty($this->password)) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindParam(":password", $this->password);
        }

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return "Email is already registered";
            }
            return false;
        }
    }

    public function softDelete($id) {
    $query = "UPDATE users SET is_deleted = 1 WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}



// For team_leader: return only non-deleted users
public function getAllActiveUsers() {
    $query = "SELECT * FROM users WHERE is_deleted = 0";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

    public function updateRole($id, $role) {
        $query = "UPDATE " . $this->table_name . " SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

public function updateProfile($id, $name, $email) {
    $query = "UPDATE users SET name = :name, email = :email WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":id", $id);
    return $stmt->execute();
}

    public function restoreUser($id) {
    $query = "UPDATE users SET is_deleted = 0 WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

}
?>