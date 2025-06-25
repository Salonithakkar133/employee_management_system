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
    $role = $_SESSION['role'];
    if ($role === 'admin') {
        $users = $this->user->getAllUsers(); // includes soft-deleted
    } else {
        $users = $this->user->getAllActiveUsers(); // excludes soft-deleted
    }

    include 'app/views/users/list.php';
}

    public function add() {
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
        include_once 'app/views/users/add.php';
    }

  public function edit() {
    $message = '';
    $user_id = isset($_GET['id']) ? $_GET['id'] : null;
    $user = $this->user->getUserById($user_id);

    if ($_POST) {
        $this->user->id = $_POST['user_id'];
        $this->user->role = $_POST['role'];

        // ✅ Prevent admin from changing their own role
        if ($_SESSION['id'] == $_POST['user_id']) {
            $message = "You cannot change your own role.";
        }
        // ✅ Prevent team_leader from assigning admin role
        elseif ($_SESSION['role'] === 'team_leader' && $_POST['role'] === 'admin') {
            $message = "Team Leader cannot assign Admin role.";
        } else {
            if ($this->user->updateRole($this->user->id, $this->user->role)) {
                $message = "Role updated successfully.";
            } else {
                $message = "Failed to update role.";
            }
        }
    }

    include 'app/views/users/edit.php';
}


   public function update() {
    $message = '';
    $user_id = isset($_GET['id']) ? $_GET['id'] : null;

    // Get the role of the user being edited
    $user = $this->user->getUserById($user_id);

    // Block team leader from accessing admin user
    if ($_SESSION['role'] === 'team_leader' && isset($user['role']) && $user['role'] === 'admin') {
        // Optional: Redirect to users list with message
        header("Location: index.php?page=users&message=" . urlencode("You are not allowed to edit an Admin user."));
        exit;
    }

    // Handle update if allowed
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

    include_once 'app/views/users/update.php';
}
    public function profile() {
    session_start();
    $user_id = $_SESSION['id'];
    $message = '';

    $user = $this->user->getUserById($user_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        if ($this->user->updateProfile($user_id, $name, $email)) {
            $message = "Profile updated successfully.";
            $user = $this->user->getUserById($user_id); // Refresh data
        } else {
            $message = "Failed to update profile.";
        }
    }

    include_once 'app/views/users/profile.php';
}

    public function delete() {
      
        $user_id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($this->user->softdelete($user_id)) {
            header("Location: index.php?page=users&message=User deleted successfully");
        } else {
            header("Location: index.php?page=users&message=Failed to delete user");
        }
        exit;
    }

    
    public function update_profile() {
    session_start();
    $user_id = $_SESSION['id'];
    $message = '';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $image_name = null;

    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "uploads/";
        $image_name = time() . '_' . basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $image_name;

        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
    }

    // Update DB
    $query = "UPDATE users SET name = :name, email = :email" . ($image_name ? ", profile_image = :image" : "") . " WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    if ($image_name) $stmt->bindParam(":image", $image_name);
    $stmt->bindParam(":id", $user_id);

    if ($stmt->execute()) {
        header("Location: index.php?page=profile&message=Profile updated successfully");
    } else {
        header("Location: index.php?page=profile&message=Failed to update profile");
    }
    exit;
}
public function getProfileData($user_id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(":id", $user_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function restore() {
    $id = $_GET['id'];

    if ($this->user->restoreUser($id)) {
        header("Location: index.php?page=users&message=User+restored+successfully");
    } else {
        header("Location: index.php?page=users&message=Failed+to+restore+user");
    }
}

}




?>
