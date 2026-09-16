<?php
session_start();
include "includes/db.php";

$error = "";

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Incorrect password.";
        }

    } else {
        $error = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SwapShelf</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-container">

    <h2>Login</h2>

    <?php
    if ($error != "") {
        echo "<p class='error'>$error</p>";
    }
    ?>

    <form method="POST" action="">

        <input type="email"
               name="email"
               placeholder="Enter Email"
               required>

        <input type="password"
               name="password"
               placeholder="Enter Password"
               required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <p>
        Don't have an account?
        <a href="register.php">Register here</a>
    </p>

</div>

</body>
</html>