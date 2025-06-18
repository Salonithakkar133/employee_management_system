<?php include 'app/views/template/header.php'; ?>
<div class="container">
    <h2>Edit Task</h2>
    <?php if (!empty($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="POST" action="index.php?page=edit_task&id=<?php echo $task['id']; ?>">
        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
        <div>
            <label>Title</label>
            <input type="text" name="title" value="<?php echo $task['title']; ?>" required>
        </div>
        <div>
            <label>Description</label>
            <textarea name="description"><?php echo $task['description']; ?></textarea>
        </div>
        <div>
            <label>Status</label>
            <select name="status">
                <option value="pending" <?php echo $task['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="in_progress" <?php echo $task['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                <option value="completed" <?php echo $task['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
            </select>
        </div>
        <div>
            <label>Assign To</label>
            <select name="assigned_to">
                <option value="">Unassigned</option>
                <?php while ($user = $users->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?php echo $user['id']; ?>" <?php echo $user['id'] == $task['assigned_to'] ? 'selected' : ''; ?>><?php echo $user['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit">Update Task</button>
    </form>
    <p><a href="index.php?page=tasks">Back to Tasks</a></p>
</div>
<?php include 'app/views/template/footer.php'; ?>