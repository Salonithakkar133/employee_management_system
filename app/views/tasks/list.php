<?php include 'app/views/template/header.php'; ?>
<div class="container">
    <h2>Tasks</h2>

    <?php if (isset($_GET['message'])): ?>
        <p class="message"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <?php if ($tasks->rowCount() > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Assigned To</th>
            <th>Assigned By</th>
            <th>Created At</th>
            <th>Start date</th>
            <th>End date</th>
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
            <td><?php echo htmlspecialchars($task['start_date']); ?></td>
            <td><?php echo htmlspecialchars($task['end_date']); ?></td>
            <td>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <?php if ($task['is_deleted']): ?>
            <a href="index.php?page=restore_task&id=<?php echo $task['id']; ?>">Restore</a>
        <?php else: ?>
            <a href="index.php?page=edit_task&id=<?php echo $task['id']; ?>">Edit</a> |
            <a href="index.php?page=delete_task&id=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        <?php endif; ?>

    <?php elseif ($_SESSION['role'] === 'team_leader'): ?>
        <?php if ($task['is_deleted']): ?>
            <span style="color:gray;">Deleted</span>
        <?php else: ?>
            <a href="index.php?page=edit_task&id=<?php echo $task['id']; ?>">Edit</a> |
            <a href="index.php?page=delete_task&id=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        <?php endif; ?>

    <?php elseif ($_SESSION['role'] === 'employee'): ?>
        <?php if (!$task['is_deleted'] && $task['assigned_to_id'] == $_SESSION['id']): ?>
            <a href="index.php?page=edit_task&id=<?php echo $task['id']; ?>">Update Status</a>
        <?php else: ?>
            N/A
        <?php endif; ?>
    <?php endif; ?>
</td>
            
</tr>

    <td>
    <a href="index.php?page=view_task&id=<?php echo $task['id']; ?>">View</a>  
    </td>

        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>

    <?php if ($_SESSION['role'] !== 'employee'): ?>
        <p><a href="index.php?page=add_task">Add New Task</a></p>
    <?php endif; ?>
</div>
<?php include 'app/views/template/footer.php'; ?>
