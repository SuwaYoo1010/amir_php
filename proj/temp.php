There's something wrong with this code I cant see all data stored in my table:
<?php
require_once('config.php');

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: admin_login.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: admin_login.php");
    exit();
}


// Pagination setup
$recordsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch all student records with course information
$sqlAllStudentRecords = "SELECT s.*, l.course FROM student s
                        JOIN login l ON s.email = l.email
                        LIMIT $offset, $recordsPerPage";


$resultAllStudentRecords = mysqli_query($conn, $sqlAllStudentRecords);

// Handle delete operation
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $sqlDeleteStudent = "DELETE FROM student WHERE id = $deleteId";
    mysqli_query($conn, $sqlDeleteStudent);
    header("Location: admin_dashboard.php?page=$page&search=$search");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin-card.css">
    <link rel="stylesheet" href="css/view.css">
</head>
<body>

<div class="container admin-content">

    <div class="admin-card">
        <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>

        <div class="actions">
            <div class="create-box">
                <button><a href="create_student.php" class="create-btn">Create</a></button>
            </div>
            <div class="view-box">
                <button><a href="admin_dashboard.php" class="view-btn">View</a></button>
            </div>
            <div class="logout-box">
                <form method="post" action="">
                    <button type="submit" name="logout">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <?php include('view.php'); ?>

</div>
</body>
</html>
