<?php include 'app/views/template/header.php'; ?>
<div class="container">
    <h2>Admin Dashboard</h2>
    <p>Welcome, Admin! Manage tasks and users below.</p>
    <h3>Task Management</h3>
    <ul>
        <li><a href="index.php?page=tasks">View All Tasks</a></li>
        <li><a href="index.php?page=add_task">Add New Task</a></li>
    </ul>
    <h3>User Management</h3>
    <ul>
        <li><a href="index.php?page=users">View All Users</a></li>
        <li><a href="index.php?page=add_user">Add New User</a></li>
    </ul>
</div>
<?php include 'app/views/template/footer.php'; ?>