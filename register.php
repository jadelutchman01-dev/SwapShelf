<?php
include "includes/db.php";

$message = "";

if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (fullname, email, password, credits)
            VALUES ('$fullname', '$email', '$password', 500)";

    if (mysqli_query($conn, $sql)) {
        $message = "Registration successful. You can now log in.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - SwapShelf</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-container">
    <h1>SwapShelf</h1>
    <h2>Create Account</h2>

    <p><?php echo $message; ?></p>

    <form method="POST">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="register">Register</button>
    </form>

    <p>Already registered? <a href="login.php">Login here</a></p>
</div>

</body>
</html>