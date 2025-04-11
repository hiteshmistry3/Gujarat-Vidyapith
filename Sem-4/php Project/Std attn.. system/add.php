<?php include "inc/header.php"; ?>

<?php
// --- Connect to database ---
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_sams"; // Make sure this matches your database name

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// --- Handle form submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    @$roll = $_POST['roll'];

    // --- Sanitize input ---
    $name = trim($name);
    $roll = trim($roll);
    $name = mysqli_real_escape_string($conn, $name);
    $roll = mysqli_real_escape_string($conn, $roll);

    if (empty($name) ) {
        $msg = "<div class='alert alert-danger'>Error: All fields are required.</div>";
    } else {
        // --- Check if roll already exists ---
        $check_sql = "SELECT * FROM tbl_student WHERE roll = '$roll'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $msg = "<div class='alert alert-danger'>Error: Roll number already exists.</div>";
        } else {
            // --- Insert student ---
            $insert_sql = "INSERT INTO tbl_student(name, roll) VALUES('$name', '$roll')";
            $insert_result = mysqli_query($conn, $insert_sql);

            // --- Insert blank attendance record ---
            $att_sql = "INSERT INTO tbl_attendance(roll) VALUES('$roll')";
            $att_result = mysqli_query($conn, $att_sql);

            if ($insert_result && $att_result) {
                // Redirect to index.php after success
                header("Location: index.php?msg=success");
                exit();
            } else {
                $msg = "<div class='alert alert-danger'>Error: Failed to add student.</div>";
            }
        }
    }
}
?>

<div class="container">
    <?php if (isset($msg)) { echo $msg; } ?>
    <div class="card">
        <div class="card-header">
            <h2>
                <a class="btn btn-success" href="add.php">Add Student</a>
                <a class="btn btn-info float-right" href="index.php">Back</a>
            </h2>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Student Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>


                <div class="form-group text-center">
                    <input type="submit" name="submit" class="btn btn-primary px-5" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
