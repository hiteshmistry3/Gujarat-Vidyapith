<?php
// --- Connect to database ---
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_sams"; // 🔁 CHANGE THIS

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// --- Handle form submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    // --- Validation ---
    $name = trim($name);

    $name = mysqli_real_escape_string($conn, $name);
    $roll = mysqli_real_escape_string($conn, $roll);

    if (empty($name)) {
        $msg = "<div style='color: red;'>Error: All fields are required.</div>";
    } else {
        // --- Check if roll already exists ---
        $check_sql = "SELECT * FROM tbl_student WHERE roll = '$roll'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $msg = "<div style='color: red;'>Error: Roll number already exists.</div>";
        } else {
            // --- Insert student ---
            $insert_sql = "INSERT INTO tbl_student(name, roll) VALUES('$name', '$roll')";
            $insert_result = mysqli_query($conn, $insert_sql);

            // --- Insert blank attendance record ---
            $att_sql = "INSERT INTO tbl_attendance(roll) VALUES('$roll')";
            $att_result = mysqli_query($conn, $att_sql);

            if ($insert_result && $att_result) {
                $msg = "<div style='color: green;'>Success: Student added successfully.</div>";
            } else {
                $msg = "<div style='color: red;'>Error: Failed to add student.</div>";
            }
        }
    }
}
?>

<!-- --- HTML Form --- -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Student (No OOP)</title>
</head>
<body>
    <h2>Add Student</h2>

    <?php
    if (isset($msg)) {
        echo $msg;
    }
    ?>

    <form method="post" action="">
        <label>Student Name:</label><br>
        <input type="text" name="name" required><br><br>


        <input type="submit" value="Add Student">
    </form>
</body>
</html>



