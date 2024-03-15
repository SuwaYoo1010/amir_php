<?php
include('config.php');

$errors = [];

session_start();

if (isset($_SESSION['email'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        header("Location: student_dashboard.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['course'] = $row['course'];
            $_SESSION['role'] = $row['role']; 

            if ($row['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: student_dashboard.php");
                exit();
            }
        } else {
            $errors['password'] = "Incorrect password.";
        }
    } else {
        $errors['email'] = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/logreg.css">
</head>

<body>

    <div class="container">
        <div class="container1">
            <div class="container2">
                <h2>Login</h2>
                <form action="index.php" method="post">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required><br>

                    <?php
                    if (isset($errors['email'])) {
                        echo "<p class='error-message'>{$errors['email']}</p>";
                    }
                    ?>

                    <label for="password">Password:</label>
                    <input type="password" name="password" required><br>
                    <?php
                    if (isset($errors['password'])) {
                        echo "<p class='error-message'>{$errors['password']}</p>";
                    }
                    ?>

                    <button type="submit" name="login">Login</button>
                </form>
                <p>Not yet registered? <a href="register.php"><br>Register now</a></p>
            </div>

            <div class="image-container">
                <img src="img/Xiao namecard.jpg" alt="name card">
            </div>

        </div>
    </div>
</body>
</html>
