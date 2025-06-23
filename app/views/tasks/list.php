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
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        <?php while ($task = $tasks->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo htmlspecialchars($task['id']); ?></td>
            <td><?php echo htmlspecialchars($task['title']); ?></td>
            <td><?php echo htmlspecialchars($task['description']); ?></td>
            <td><?php echo htmlspecialchars($task['status']); ?></td>
            <td><?php echo htmlspecialchars($task['assigned_to']); ?></td>
            <td><?php echo htmlspecialchars($task['created_by']); ?></td>
            <td><?php echo htmlspecialchars($task['created_at']); ?></td>

            <td><td>
    <?php if ($_SESSION['role'] !== 'employee'): ?>
        <a href="index.php?page=edit_task&id=<?php echo $task['id']; ?>">Edit</a>
        <a href="index.php?page=delete_task&id=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
    <?php elseif ($task['assigned_to_id'] == $_SESSION['id']): ?>
        <a href="index.php?page=edit_task&id=<?php echo $task['id']; ?>">Update Status</a>
    <?php else: ?>
        N/A
    <?php endif; ?>
</td>

            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if ($_SESSION['role'] !== 'employee'): ?>
        <p><a href="index.php?page=add_task">Add New Task</a></p>
    <?php endif; ?>
</div>
<?php include 'app/views/template/footer.php'; ?>
