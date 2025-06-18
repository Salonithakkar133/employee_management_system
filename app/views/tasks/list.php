<?php include 'app/views/template/header.php'; ?>
<div class="container">
    <h2>Tasks</h2>
    <?php if (isset($_GET['message'])): ?>
        <p class="message"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Assigned To</th>
            <th>Assigned By</th>
            <th>Assigned By Role</th>
            <th>Created At</th>
            <?php if ($_SESSION['role'] !== 'employee'): ?>
            <th>Actions</th>
            <?php endif; ?>
        </tr>
        <?php while ($task = $tasks->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $task['id']; ?></td>
            <td><?php echo $task['title']; ?></td>
            <td><?php echo $task['description']; ?></td>
            <td><?php echo $task['status']; ?></td>
            <td><?php echo $task['assigned_to_name'] ?: 'Unassigned'; ?></td>
            <td><?php echo $task['created_by_name']; ?></td>
            <td><?php echo $task['assigned_by_role']; ?></td>
            <td><?php echo $task['created_at']; ?></td>
            <?php if ($_SESSION['role'] !== 'employee'): ?>
            <td>
                <a href="index.php?page=edit_task&id=<?php echo $task['id']; ?>">Edit</a>
                <a href="index.php?page=delete_task&id=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php if ($_SESSION['role'] !== 'employee'): ?>
    <p><a href="index.php?page=add_task">Add New Task</a></p>
    <?php endif; ?>
</div>
<?php include 'app/views/template/footer.php'; ?>