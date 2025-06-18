<?php include 'app/views/template/header.php'; ?>
<div class="container">
    <h2>Users</h2>
    <?php if (isset($_GET['message'])): ?>
        <p class="message"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php while ($user = $users->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="index.php?page=edit_user&id=<?php echo $user['id']; ?>">Edit Role</a> |
                <a href="index.php?page=update_user&id=<?php echo $user['id']; ?>">Update</a> |
                <a href="index.php?page=delete_user&id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                <?php elseif ($_SESSION['role'] === 'team_leader'): ?>
                <a href="index.php?page=update_user&id=<?php echo $user['id']; ?>">Update</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php if ($_SESSION['role'] === 'admin'): ?>
    <p><a href="index.php?page=add_user">Add New User</a></p>
    <?php endif; ?>
</div>
<?php include 'app/views/template/footer.php'; ?>