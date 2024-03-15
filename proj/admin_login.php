<?php
require_once('config.php');

session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sqlAdminLogin = "SELECT * FROM login WHERE email = '$email' AND role = 'admin'";
    $resultAdminLogin = mysqli_query($conn, $sqlAdminLogin);

    if ($resultAdminLogin && mysqli_num_rows($resultAdminLogin) == 1) {
        $adminData = mysqli_fetch_assoc($resultAdminLogin);

        if (password_verify($password, $adminData['password'])) {
            $_SESSION['email'] = $adminData['email'];
            $_SESSION['name'] = $adminData['name'];
            $_SESSION['course'] = $adminData['course'];
            $_SESSION['role'] = 'admin'; 

            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error_message = "Invalid password";
        }
    } else {
        $error_message = "Invalid admin credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/admin-login.css">
</head>
<body>
    <div class="container">
        <div class="container1">
            <div class="container2">
                <h2>Admin Login</h2>
                <form action="admin_login.php" method="post">
                    <label for="email">Admin Username:</label>
                    <input type="text" name="email" required><br>

                    <label for="password">Admin Password:</label>
                    <input type="password" name="password" required><br>

                    <button type="submit" name="login">Login</button>
                </form>

                <?php if (isset($error_message)) : ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
            </div>
            
            <div class="image-container">
                <img src="img/zhongli.jpg" alt="name card">
            </div>
            
        </div> 
    </div>
</body>
</html>
