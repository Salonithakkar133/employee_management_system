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
            echo "<option value='{$user['id']}'>{$user['name']}</option>";
        }
        ?>
    </select>
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" required>

    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" required>

    <button type="submit">Create Task</button>
   
</form>
<?php include 'app/views/template/footer.php'; ?>