<?php
require_once('config.php');

if (isset($_POST['logout'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$recordsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

$sqlAllStudentRecords = "SELECT s.*, l.course FROM student s
                         JOIN login l ON s.email = l.email
                         LIMIT $offset, $recordsPerPage";
$resultAllStudentRecords = mysqli_query($conn, $sqlAllStudentRecords);

$sqlCountRecords = "SELECT COUNT(*) AS total FROM student";
$resultCountRecords = mysqli_query($conn, $sqlCountRecords);
$totalRecords = mysqli_fetch_assoc($resultCountRecords)['total'];

$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Records</title>
    <link rel="stylesheet" href="css/view.css">
</head>
<body>
    <div class="container student-content">
        <div class="actions">
            <div class="back-to-dashboard-box">
                <button><a href="student_dashboard.php">Back to Student Dashboard</a></button>
            </div>

            <div class="logout-box">
                <form method="post" action="">
                    <button type="submit" name="logout">Logout</button>
                </form>
            </div>
        </div>

        <div class="record">
            <h3>All Student Records</h3>
            <table border="0">
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>GPA</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($resultAllStudentRecords)) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['age']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['course']}</td>
                            <td>{$row['gpa']}</td>
                        </tr>";
                }
                ?>
            </table>

            <div class="pagination">
                <?php
                if ($page > 1) {
                    echo "<a href='view_students.php?page=" . ($page - 1) . "'>Previous</a>";
                }

                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='view_students.php?page=$i'>$i</a>";
                }

                if ($page < $totalPages) {
                    echo "<a href='view_students.php?page=" . ($page + 1) . "'>Next</a>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
