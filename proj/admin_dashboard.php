<?php
require_once('config.php');

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: admin_login.php");
    exit();
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$recordsPerPage = 7; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

if (isset($_GET['priority']) && $_GET['priority'] === 'true') {
    $sqlStudentRecords = "SELECT *, ROW_NUMBER() OVER () as row_num FROM student WHERE gpa = '0' ORDER BY id LIMIT $offset, $recordsPerPage";
} else {
    $sqlStudentRecords = "SELECT *, ROW_NUMBER() OVER () as row_num FROM student where email !='hahatdoggz@gmail.com' ORDER BY id LIMIT $offset, $recordsPerPage";
}

$resultStudentRecords = mysqli_query($conn, $sqlStudentRecords);

$totalRecordsQuery = "SELECT COUNT(*) as total FROM student";
$totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];

$totalPages = ceil($totalRecords / $recordsPerPage);

$prevPage = max($page - 1, 1);
$nextPage = min($page + 1, $totalPages);

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    $getEmailQuery = "SELECT email FROM student WHERE id = $deleteId";
    $emailResult = mysqli_query($conn, $getEmailQuery);
    $email = mysqli_fetch_assoc($emailResult)['email'];

    $sqlDeleteLogin = "DELETE FROM login WHERE email = '$email'";
    mysqli_query($conn, $sqlDeleteLogin);

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
</head>
<body>

<div class="container admin-content">

    <div class="admin-card">
        <h2>Welcome, Admin!</h2>

        <div class="actions">
            <div class="create-box">
                <button><a href="create_student.php" class="create-btn">Create</a></button>
            </div>
            <div class="view-box">
                <button><a href="admin_dashboard.php" class="view-btn">All</a></button>
            </div>
            <div class="priority-box">
                <button><a href="admin_dashboard.php?priority=true" class="priority-btn">Priority</a></button>
            </div>
            <div class="logout-box">
                <form method="post" action="">
                    <button type="submit" name="logout">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="record-card">
        <div class="rec-head">
        <h3>
            <?php 
                echo isset($_GET['priority']) && $_GET['priority'] === 'true' ? 'Priority' : 'All'; 
                if (isset($_GET['priority']) && $_GET['priority'] === 'true') {
                    echo " Student Records<br>";
                    echo " Please update the GPA ASAP!";
                }
                else{
                    echo " Student Records";
                }
            ?>
        </h3>
        </div>

        <div class="record">
            <table border="0">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>GPA</th>
                    <th>Action</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($resultStudentRecords)) {
                    echo "<tr>
                        <td>{$row['row_num']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['gpa']}</td>
                        <td>
                            <a href='update_student.php?id={$row['id']}' class='action-btn'>Update</a>
                            <a href='admin_dashboard.php?delete_id={$row['id']}' class='action-btn' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </table>
        </div>
        
        <!-- Pagination links -->
        <?php if ($totalPages > 1) : ?>
            <div class="pagination">
                <?php if ($page > 1) : ?>
                    <a href='admin_dashboard.php?page=<?php echo $prevPage; ?>&priority=<?php echo isset($_GET['priority']) ? $_GET['priority'] : 'false'; ?>'>Previous</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <a href='admin_dashboard.php?page=<?php echo $i; ?>&priority=<?php echo isset($_GET['priority']) ? $_GET['priority'] : 'false'; ?>' <?php echo $i == $page ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
                
                <?php if ($page < $totalPages) : ?>
                    <a href='admin_dashboard.php?page=<?php echo $nextPage; ?>&priority=<?php echo isset($_GET['priority']) ? $_GET['priority'] : 'false'; ?>'>Next</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
