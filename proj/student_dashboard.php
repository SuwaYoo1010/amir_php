<?php
require_once('config.php');

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch the logged-in user's record from the student table
$sqlUserRecord = "SELECT s.*, l.course FROM student s
                  JOIN login l ON s.email = l.email
                  WHERE s.email = '$email'";
$resultUserRecord = mysqli_query($conn, $sqlUserRecord);

// Check if the result set contains any rows
if ($resultUserRecord && mysqli_num_rows($resultUserRecord) > 0) {
    $userRecord = mysqli_fetch_assoc($resultUserRecord);
} else {
    session_destroy();
    // Handle the case where the user's record is not found
    echo "Error: User record not found.";
    exit();
}

// Display a message for GPA condition
$gpaMessage = ($userRecord['gpa'] == '0.00') ? "If your GPA is set to 0, please wait for the admin to update your GPA." : "";

// Fetch all student records, with the logged-in user's record at the top
$sqlAllStudentRecords = "SELECT s.*, l.course FROM student s
                         JOIN login l ON s.email = l.email
                         ORDER BY s.email = '{$userRecord['email']}' DESC";
$resultAllStudentRecords = mysqli_query($conn, $sqlAllStudentRecords);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/student_dashboard.css">
</head>
<body>
    <div class="container student-content">
        <div class="student-card">
            <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>

            <div class="actions">
                <div class="logout-box">
                    <form method="post" action="">
                        <button type="submit" name="logout">Logout</button>
                    </form>
                </div>
                <div class="view-records-box">
                    <button><a href="view_students.php">View Student Records</a></button>
                </div>
            </div>

            <div class="record">
                <h3>Your Record</h3>
                <p>Name: <b><?php echo isset($userRecord['name']) ? $userRecord['name'] : ''; ?></b></p>
                <p>Age: <b><?php echo isset($userRecord['age']) ? $userRecord['age'] : ''; ?></b></p>
                <p>Email: <b><?php echo isset($userRecord['email']) ? $userRecord['email'] : ''; ?></b></p>
                <p>Course: <b><?php echo isset($userRecord['course']) ? $userRecord['course'] : ''; ?></b></p>
                <p>GPA: <b><?php echo isset($userRecord['gpa']) ? $userRecord['gpa'] : ''; ?></b></p>
                <p><?php echo $gpaMessage; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
