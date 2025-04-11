<?php
session_start();

// Check if logged in
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header('Location: login.php');
    exit;
}

// --- Database connection ---
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_sams";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// --- Fetch attendance dates ---
$getdate_query = "SELECT DISTINCT att_time FROM tbl_attendance ORDER BY att_time DESC";
$getdate_result = mysqli_query($conn, $getdate_query);

// Check if attendance dates are available
$getdate = mysqli_num_rows($getdate_result) > 0 ? $getdate_result : null;

include "inc/header.php"; 
?>

<div class="container">
    <?php if (isset($insertattend)) echo $insertattend; ?>

    <div class="card">
        <div class="card-header">
            <h2>
                <a class="btn btn-success" href="add.php">Add Student</a>
                <a class="btn btn-info float-right" href="index.php">Back</a>
                <a class="btn btn-info float-right" href="attendance.php" style="margin-right:10px;">Take Attendance</a>
            </h2>
        </div>

        <div class="card-body">
            <form action="" method="post">
                <table class="table table-striped">
                    <tr>
                        <th width="30%">S/L</th>
                        <th width="50%">Attendance Date</th>
                        <th width="20%">Action</th>
                    </tr>

                    <?php
                    if ($getdate) {
                        $i = 0;
                        while ($value = mysqli_fetch_assoc($getdate)) {
                            $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['att_time']; ?></td>
                        <td>
                            <a class="btn btn-primary" href="student_view.php?dt=<?php echo $value['att_time']; ?>">View</a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='3'>No attendance records found.</td></tr>";
                    }
                    ?>

                </table>
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
