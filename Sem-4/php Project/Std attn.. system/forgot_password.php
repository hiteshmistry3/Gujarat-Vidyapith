<?php
session_start();
include "inc/header.php";

// Initialize error and success messages
$error_message = '';
$success_message = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email (or username) from POST
    $email_or_username = $_POST['email_or_username'];

    // Simulate checking if the email or username exists (replace this with your actual database check)
    $valid_email = 'hitesh@gmail.com';  // Example email (you would normally check this against a database)
    
    if ($email_or_username == $valid_email) {
        // Simulate sending a password reset email (you would send an actual email here)
        $success_message = 'A password reset link has been sent to your email address.';
    } else {
        // If the email or username doesn't exist
        $error_message = 'No account found with that email/username.';
    }
}
?>

<div class="container">
    <h2 class="my-4">Forgot Password</h2>
    
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

    <form action="forgot_password.php" method="POST">
        <div class="form-group">
            <label for="email_or_username">Enter Your Email or Username</label>
            <input type="text" class="form-control" id="email_or_username" name="email_or_username" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php include "inc/footer.php"; ?>
