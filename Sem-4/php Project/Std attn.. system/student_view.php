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

// --- Get the date parameter from the URL ---
$dt = $_GET['dt'];
$attattend = ''; // Declare variable to hold the attendance update result

// Initialize counters for present and absent students
$present_count = 0;
$absent_count = 0;
$present_students = [];
$absent_students = [];

// Check if the form is submitted and the 'attend' array is set
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['attend'])) {
    $attend = $_POST['attend'];

    // Loop through each student attendance and ensure a value is set
    foreach ($attend as $roll => $status) {
        // If no attendance is selected, mark the student as absent
        if (empty($status)) {
            $attend[$roll] = 'absent';
        }
    }

    // --- Update attendance in the database ---
    $attattend = updateAttendance($dt, $attend);
}

include "inc/header.php"; 
?>

<div class="container">
    <?php 
    // Display the success/error message for attendance update
    if (isset($attattend)) {
        echo $attattend;
    }
    ?>

    <div class='alert alert-danger' style="display: none;"><strong>Error!</strong> Student Roll Missing!</div>

    <div class="card">
        <div class="card-header">
            <h2>
                <a class="btn btn-success" href="add.php">Add Student</a>
                <a class="btn btn-info float-right" href="date_view.php">Back</a>
            </h2>
        </div>

        <div class="card-body">
            <div class="card bg-light text-center mb-3">
                <h4 class="m-0 py-3"><strong>Date</strong>: <?php echo $dt; ?></h4>
            </div>
            <form action="" method="post">
                <table class="table table-striped">
                    <tr>
                        <th width="25%">S/L</th>
                        <th width="25%">Student Name</th>
                        <th width="25%">Student Roll</th>
                        <th width="25%">Attendance</th>
                    </tr>

                    <?php 
                    // Fetch student attendance data for the specified date
                    $getstudent = getAllData($dt);
                    if ($getstudent) {
                        // Loop through the student attendance data and display it
                        $attendance_data = $getstudent; // Assuming this is directly returned as the result

                        $i = 0;
                        while ($value = mysqli_fetch_assoc($attendance_data)) {
                            $i++;    
                            // Count present and absent students
                            if ($value['attend'] == "present") {
                                $present_count++;
                                $present_students[] = ['name' => $value['name'], 'roll' => $value['roll']];
                            } elseif ($value['attend'] == "absent") {
                                $absent_count++;
                                $absent_students[] = ['name' => $value['name'], 'roll' => $value['roll']];
                            }
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['roll']; ?></td>
                        <td>
                            <!-- Use checkboxes for present and absent, with JS to auto-check absent if present is not checked -->
                            <input type="checkbox" name="attend[<?php echo $value['roll']; ?>]" value="present" class="present-checkbox" <?php if($value['attend'] == "present") {echo "checked";} ?>> Present
                            <input type="checkbox" name="attend[<?php echo $value['roll']; ?>]" value="absent" class="absent-checkbox" <?php if($value['attend'] == "absent") {echo "checked";} ?>> Absent
                        </td>
                    </tr>
                    <?php } } ?>

                    <tr>
                        <td colspan="4" class="text-center">
                            <input type="submit" name="submit" class="btn btn-primary px-5" value="Update">
                        </td>
                    </tr>
                </table>
            </form>

            <!-- Display Present and Absent students with their names and roll numbers -->
            <div class="alert alert-info mt-4">
                <strong>Present Students:</strong> <?php echo $present_count; ?><br>
                <ul>
                    <?php foreach ($present_students as $student) { ?>
                        <li><?php echo $student['name']; ?> (Roll No: <?php echo $student['roll']; ?>)</li>
                    <?php } ?>
                </ul>
            </div>

            <div class="alert alert-warning">
                <strong>Absent Students:</strong> <?php echo $absent_count; ?><br>
                <ul>
                    <?php foreach ($absent_students as $student) { ?>
                        <li><?php echo $student['name']; ?> (Roll No: <?php echo $student['roll']; ?>)</li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </div>
</div>

<!-- Add JS for checkbox behavior -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const presentCheckboxes = document.querySelectorAll(".present-checkbox");
        const absentCheckboxes = document.querySelectorAll(".absent-checkbox");

        // Add event listener to ensure if present is unchecked, absent is checked
        presentCheckboxes.forEach(function(presentCheckbox) {
            presentCheckbox.addEventListener("change", function() {
                const absentCheckbox = this.closest('td').querySelector(".absent-checkbox");
                if (!this.checked) {
                    absentCheckbox.checked = true;
                } else {
                    absentCheckbox.checked = false;
                }
            });
        });

        // If absent is checked, ensure present is unchecked
        absentCheckboxes.forEach(function(absentCheckbox) {
            absentCheckbox.addEventListener("change", function() {
                const presentCheckbox = this.closest('td').querySelector(".present-checkbox");
                if (this.checked) {
                    presentCheckbox.checked = false;
                }
            });
        });
    });
</script>

<?php include("inc/footer.php"); ?>

<?php
// --- Function to fetch student attendance data for the specified date ---
function getAllData($dt) {
    global $conn;
    $query = "SELECT s.name, s.roll, a.attend FROM tbl_student s 
              LEFT JOIN tbl_attendance a ON s.roll = a.roll 
              WHERE a.att_time = '$dt'";
    $result = mysqli_query($conn, $query);
    return $result;
}

// --- Function to update student attendance ---
function updateAttendance($dt, $attend) {
    global $conn;

    foreach ($attend as $roll => $status) {
        $status = mysqli_real_escape_string($conn, $status);
        $roll = mysqli_real_escape_string($conn, $roll);
        $query = "UPDATE tbl_attendance SET attend = '$status' WHERE roll = '$roll' AND att_time = '$dt'";
        $result = mysqli_query($conn, $query);
    }

    if ($result) {
        return "<div class='alert alert-success'>Attendance updated successfully!</div>";
    } else {
        return "<div class='alert alert-danger'>Error updating attendance.</div>";
    }
}
?>
