<?php
require_once('config.php');

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $gpa = $_POST['gpa'];
    $password = $_POST['password']; 
    $course = $_POST['course']; 

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sqlInsertStudent = "INSERT INTO student (name, age, email, gpa) VALUES ('$name', $age, '$email', '$gpa')";
    mysqli_query($conn, $sqlInsertStudent);
    
    $studentId = mysqli_insert_id($conn);
    
    $sqlInsertLogin = "INSERT INTO login (email, password, name, course, student_id) VALUES ('$email', '$hashedPassword', '$name', '$course', $studentId)";
    mysqli_query($conn, $sqlInsertLogin);
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
    <link rel="stylesheet" href="css/update.css">
</head>
<body>
    <div class="container admin-content">
        <div class="actions">
            <button><a href="admin_dashboard.php" class="logout-back-link">Back to Dashboard</a></button>
        </div>
        <div class="admin-card">
            <h2>Create Student Record</h2>
            <form action="create_student.php" method="post">
                <label for="name">Name:</label>
                <input type="text" name="name" required><br>

                <label for="age">Age:</label>
                <input type="number" name="age" required><br>

                <label for="email">Email:</label>
                <input type="email" name="email" required><br>

                <label for="gpa">GPA:</label>
                <select name="gpa" required>
                    <option value="1.00">1.00</option>
                    <option value="1.25">1.25</option>
                    <option value="1.50">1.50</option>
                    <option value="1.75">1.75</option>
                    <option value="2.00">2.00</option>
                    <option value="2.25">2.25</option>
                    <option value="2.50">2.50</option>
                    <option value="2.75">2.75</option>
                    <option value="3.00">3.00</option>
                </select><br>

                <label for="password">Password:</label>
                <input type="password" name="password" required><br>

                <label for="course">Course:</label>
                <input type="text" name="course" required><br>

                <button type="submit">Create</button>
            </form>
        </div>
    </div>
</body>
</html>
