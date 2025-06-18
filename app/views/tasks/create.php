<?php include 'app/views/template/header.php'; ?>
<h2>Create Task</h2>
<form method="POST" action="index.php?controller=task&action=create">
    <input type="text" name="title" placeholder="Task Title" required>
    <textarea name="description" placeholder="Task Description"></textarea>
    <select name="assigned_to" required>
        <?php
        $userModel = new User($this->db);
        $users = $userModel->getAll();
        foreach ($users as $user) {
            echo "<option value='{$user['id']}'>{$user['username']}</option>";
        }
        ?>
    </select>
    <button type="submit">Create Task</button>
</form>
<?php include 'app/views/template/footer.php'; ?>