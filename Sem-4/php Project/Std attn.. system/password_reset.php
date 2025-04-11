<?php
session_start();
include "inc/header.php";


$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($token != 'valid-token') {
    header('Location: forgot_password.php');
    exit;
}

$success_message = '';
$error_message = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];

  
    if (strlen($new_password) >= 6) {
    
        $success_message = 'Your password has been successfully reset!';
    } else {
        $error_message = 'Password must be at least 6 characters long.';
    }
}
?>

<div class="container">
    <h2 class="my-4">Reset Your Password</h2>

    <?php if ($error_message): ?>
        <div class="alert alert-danger">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <?php if ($success_message): ?>
        <div class="alert alert-success">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <form action="password_reset.php?token=<?php echo $token; ?>" method="POST">
        <div class="form-group">
            <label for="new_password">Enter New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>

        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>

<?php include "inc/footer.php"; ?>
