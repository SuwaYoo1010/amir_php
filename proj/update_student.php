<?php
require_once('config.php');

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $gpa = $_POST['gpa'];
    $course = $_POST['course'];

    $sqlUpdateStudent = "UPDATE student SET name='$name', age=$age, email='$email', gpa='$gpa' WHERE id=$id";
    mysqli_query($conn, $sqlUpdateStudent);

    $sqlUpdateLogin = "UPDATE login SET name='$name', email='$email', course='$course' WHERE email='$email'";
    mysqli_query($conn, $sqlUpdateLogin);

    header("Location: admin_dashboard.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlGetStudent = "SELECT * FROM student WHERE id = $id";
    $resultGetStudent = mysqli_query($conn, $sqlGetStudent);
    $studentData = mysqli_fetch_assoc($resultGetStudent);

    $sqlGetLogin = "SELECT course FROM login WHERE email = '$studentData[email]'";
    $resultGetLogin = mysqli_query($conn, $sqlGetLogin);

    if ($resultGetLogin && mysqli_num_rows($resultGetLogin) > 0) {
        $loginData = mysqli_fetch_assoc($resultGetLogin);
        $studentData['course'] = $loginData['course'];
    } else {
        $studentData['course'] = "Default Course";
    }
} else {
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="css/update.css">
</head>
<body>
    <div class="container admin-content">
        <div class="actions">
            <a href="admin_dashboard.php" class="logout-back-link">Back to Dashboard</a>
        </div>
        <div class="admin-card">
            <h2>Update Student Record</h2>

            <form action="update_student.php" method="post">
                <input type="hidden" name="id" value="<?php echo $studentData['id']; ?>">

                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo $studentData['name']; ?>" required><br>

                <label for="age">Age:</label>
                <input type="number" name="age" value="<?php echo $studentData['age']; ?>" required><br>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $studentData['email']; ?>" required><br>

                <label for="gpa">GPA:</label>
                    <select name="gpa" required>
                        <option value="1.00" <?php echo ($studentData['gpa'] == '1.00') ? 'selected' : ''; ?>>1.00</option>
                        <option value="1.25" <?php echo ($studentData['gpa'] == '1.25') ? 'selected' : ''; ?>>1.25</option>
                        <option value="1.50" <?php echo ($studentData['gpa'] == '1.50') ? 'selected' : ''; ?>>1.50</option>
                        <option value="1.75" <?php echo ($studentData['gpa'] == '1.75') ? 'selected' : ''; ?>>1.75</option>
                        <option value="2.00" <?php echo ($studentData['gpa'] == '1.00') ? 'selected' : ''; ?>>2.00</option>
                        <option value="2.25" <?php echo ($studentData['gpa'] == '1.25') ? 'selected' : ''; ?>>2.25</option>
                        <option value="2.50" <?php echo ($studentData['gpa'] == '1.50') ? 'selected' : ''; ?>>2.50</option>
                        <option value="2.75" <?php echo ($studentData['gpa'] == '1.75') ? 'selected' : ''; ?>>2.75</option>
                        <option value="3.00" <?php echo ($studentData['gpa'] == '1.00') ? 'selected' : ''; ?>>3.00</option>
                    </select><br>

                <label for="course">Course:</label>
                <input type="text" name="course" value="<?php echo $studentData['course']; ?>" required><br>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
