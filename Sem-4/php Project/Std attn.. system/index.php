<?php
session_start();

// Check login
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header('Location: login.php');
    exit;
}

// --- DB Connection ---
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_sams";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$cur_date = date('Y-m-d');
$msg = '';

// --- Handle attendance form submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attend = $_POST['attend'];

    // --- Check if attendance already exists for today ---
    $check_sql = "SELECT DISTINCT att_time FROM tbl_attendance WHERE att_time = '$cur_date'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $msg = "<div class='alert alert-danger'><strong>Error!</strong> Attendance already taken today.</div>";
    } else {
        foreach ($attend as $roll => $status) {
            $status = ($status === 'present') ? 'present' : 'absent';
            $insert_sql = "INSERT INTO tbl_attendance(roll, attend, att_time) VALUES('$roll', '$status', '$cur_date')";
            mysqli_query($conn, $insert_sql);
        }

        $msg = "<div class='alert alert-success'><strong>Success!</strong> Attendance saved successfully.</div>";
    }
}
?>

<?php include "inc/header.php"; ?>

<div class="container">
    <h2 class="my-4">Mark Attendance</h2>

    <?php if (!empty($msg)) echo $msg; ?>

    <div class="card">
        <div class="card-header">
            <h2>
                <a class="btn btn-success" href="add.php">Add Student</a>
                <a class="btn btn-info float-right" href="date_view.php">View All</a>
                <a class="btn btn-info float-right" href="logout.php" style="margin-right:10px;">Logout</a>
            </h2>
        </div>

        <div class="card-body">
            <div class="card bg-light text-center mb-3">
                <h4 class="m-0 py-3"><strong>Date</strong>: <?php echo $cur_date; ?></h4>
            </div>

            <form method="post" action="">
                <table class="table table-striped">
                    <tr>
                        <th width="25%">S/L</th>
                        <th width="25%">Student Name</th>
                        <th width="25%">Student Roll</th>
                        <th width="25%">Attendance</th>
                    </tr>

                    <?php
                    $i = 0;
                    $stu_query = "SELECT * FROM tbl_student ORDER BY roll ASC";
                    $stu_result = mysqli_query($conn, $stu_query);

                    if (mysqli_num_rows($stu_result) > 0) {
                        while ($row = mysqli_fetch_assoc($stu_result)) {
                            $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['roll']; ?></td>
                        <td>
                            <!-- Hidden for default absent -->
                            <input type="hidden" name="attend[<?php echo $row['roll']; ?>]" value="absent">
                            <input type="checkbox" name="attend[<?php echo $row['roll']; ?>]" value="present"> Present
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>No students found.</td></tr>";
                    }
                    ?>

                    <tr>
                        <td colspan="4" class="text-center">
                            <input type="submit" name="submit" class="btn btn-primary px-5" value="Submit Attendance">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
