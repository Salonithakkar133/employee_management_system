<?php include 'add/views/template/header.php'; ?>
<div class="container">
    <h2>Add Task</h2>
    <?php if (!empty($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="POST" action="index.php?page=add_task">
        <div>
            <label>Title</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label>Description</label>
            <textarea name="description"></textarea>
        </div>
        <div>
            <label>Status</label>
            <select name="status">
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div>
            <label>Assign To</label>
            <select name="assigned_to">
                <option value="">Unassigned</option>
                <?php while ($user = $users->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit">Add Task</button>
    </form>
    <p><a href="index.php?page=tasks">Back to Tasks</a></p>
</div>
<?php include 'add/views/template/footer.php'; ?>