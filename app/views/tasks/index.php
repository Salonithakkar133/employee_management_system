


<?php include 'app/views/template/header.php'; ?>
<div class="container">
    <h2>Task Management</h2>
    <a href="index.php?page=add_task">Add New Task</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['id']); ?></td>
                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                    <td><?php echo htmlspecialchars($task['assigned_to']); ?></td>
                    <td><?php echo htmlspecialchars($task['status']); ?></td>
                    <td>
                        <a href="index.php?controller=task&action=edit&id=<?php echo $task['id']; ?>">Edit</a>
                        <a href="index.php?page=view_task&id=<?php echo htmlspecialchars($task['id']); ?>">View</a>
                        <a href="index.php?page=delete_task&id=<?php echo htmlspecialchars($task['id']); ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'app/views/template/footer.php'; ?>