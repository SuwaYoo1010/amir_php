<?php 
include('config.php');

$errors = []; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $course = $_POST['course'];

    if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors['password'] = "Password must be 8 characters or more and contain a combination of alphanumeric and special characters.";
    }

    $emailCheckQuery = "SELECT * FROM login WHERE email = '$email'";
    $emailCheckResult = mysqli_query($conn, $emailCheckQuery);

    if ($emailCheckResult && mysqli_num_rows($emailCheckResult) > 0) {
        $errors['email'] = "Email already exists. Please use a different email.";
    }

    if ($age < 17 || $age > 70) {
        $errors['age'] = "Invalid age. Please enter an age between 17 and 70.";
    }

    if (!empty($errors)) {
         } 
    else {
        $sqlInsertStudent = "INSERT INTO student (name, age, email, gpa) VALUES ('$name', '$age', '$email', '0.0')";
        mysqli_query($conn, $sqlInsertStudent);

        $studentId = mysqli_insert_id($conn);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sqlInsertLogin = "INSERT INTO login (email, password, name, course, student_id) VALUES ('$email', '$hashedPassword', '$name', '$course', $studentId)";        mysqli_query($conn, $sqlInsertLogin);

        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

    <div class="container">
        <div class="container1">
            <div class="image-container">
                <img src="img/Xiao namecard.jpg" alt="name card">
            </div>

            <div class="container2">
                <h2>Register</h2>
                <form action="register.php" method="post">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required><br>
                    
                        <?php
                        if (isset($errors['email'])) {
                            echo "<p class='error-message'>{$errors['email']}</p>";
                        }
                        ?>
                        
                    <label for="password">Password:</label>
                    <input type="password" name="password" required pattern="(?=.*\d)(?=.*[A-Za-z])(?=.*[^A-Za-z0-9]).{8,}" 
                        title="Password must be 8 characters or more and contain a combination of alphanumeric and special characters"><br>
                    
                    <?php
                    if (isset($errors['password'])) {
                        echo "<p class='error-message'>{$errors['password']}</p><br>";
                    }
                    ?>

                    <label for="name">Full Name:</label>
                    <input type="text" name="name" required><br>

                    <label for="age">Age:</label>
                    <input type="number" name="age" required><br>
                    <?php
                    if (isset($errors['age'])) {
                        echo "<p class='error-message'>{$errors['age']}</p><br>";
                    }
                    ?>
                    <label for="course">Course:</label>
                    <input type="text" name="course" required><br>

                    <button type="submit" name="register">Register</button>
                </form>
                
                <br><p>Already registered? <br><a href="index.php">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
