<?php include 'app/views/template/header.php'; ?>
<div class="container">
    <h2>Register</h2>
    <?php if (!empty($message)): ?>
        <p class="<?php echo strpos($message, 'failed') !== false || strpos($message, 'already') !== false ? 'error' : 'message'; ?>">
            <?php echo $message; ?>
        </p>
    <?php else: ?>
        <form method="POST" action="index.php?page=register">
            <div>
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
    <?php endif; ?>
    <p><a href="index.php?page=login">Back to Login</a></p>
</div>
<?php include 'app/views/template/footer.php'; ?>