<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db.php";

$credits = 0;

if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $credit_sql = "SELECT credits FROM users WHERE id = '$user_id'";
    $credit_result = mysqli_query($conn, $credit_sql);

    if ($credit_result && mysqli_num_rows($credit_result) > 0) {

        $credit_row = mysqli_fetch_assoc($credit_result);
        $credits = $credit_row['credits'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwapShelf</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="navbar">

    <div class="logo">
        Swap<span>Shelf</span>
    </div>

    <div class="nav-links">

        <a href="dashboard.php">Dashboard</a>

        <a href="browse_books.php">Browse</a>

        <a href="add_book.php">Add Book</a>

        <a href="my_books.php">My Books</a>

        <a href="my_swaps.php">My Swaps</a>

        <a href="admin_dashboard.php">Admin Dashboard</a>

        <a href="logout.php" onclick="return confirmLogout()">Logout</a>

    </div>

    <div class="credit-box">
        Credits: <?php echo $credits; ?>
    </div>
    <script>
function confirmLogout() {
    return confirm("Are you sure you want to logout?");
}
</script>

</div>