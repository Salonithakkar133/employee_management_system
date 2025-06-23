<?php include 'app/views/template/header.php'; ?>
<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['id'])) die("You are not logged in.");
?>

<div class="container">

    <h2>My Profile</h2>

    <?php if (!empty($_GET['message'])): ?>
        <p class="message"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <!-- Show profile image if exists -->
    <?php if (!empty($user['profile_image']) && file_exists('uploads/' . $user['profile_image'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($user['profile_image']); ?>" width="120" alt="Profile Image">
    <?php else: ?>
        <p><em>No profile image uploaded.</em></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=update_profile" enctype="multipart/form-data">
        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($user['profile_image'] ?? ''); ?>">

        <div>
            <label>Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div>
            <label>Role</label>
            <input type="text" value="<?php echo htmlspecialchars($user['role']); ?>" readonly>
        </div>

        <div>
            <label>Upload Profile Image</label>
            <input type="file" name="profile_image" accept="image/*">
        </div>

        <button type="submit">Update Profile</button>
    </form>
</div>
<?php include 'app/views/template/footer.php'; ?>
