<?php include 'app/views/template/header.php'; ?>
<h2>Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['id']; ?>!</p>
<h3>Your Tasks</h3>
<table>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Status</th>
        <th>Assigned To</th>
        <?php if ($_SESSION['role_id'] != 1) echo '<th>Actions</th>'; ?>
    </tr>
    <?php foreach ($tasks as $task): ?>
    <tr>
        <td><?php echo $task['title']; ?></td>
        <td><?php echo $task['description']; ?></td>
        <td><?php echo $task['status']; ?></td>
        <td><?php echo $task['assigned_to']; ?></td>
        <?php if ($_SESSION['role_id'] != 1): ?>
        <td>
            <a href="index.php?controller=task&action=edit&id=<?php echo $task['id']; ?>">Edit</a>
            <a href="index.php?controller=task&action=delete&id=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
</table>
<?php include 'app/views/template/footer.php'; ?>