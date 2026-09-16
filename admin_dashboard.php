<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";

$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$total_books = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM books"))['total'];
$total_requests = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM swap_requests"))['total'];
?>

<div class="container">
    <h2>Admin Dashboard</h2>
    <p>Manage users, uploaded books, and swap activity on SwapShelf.</p>

    <div class="stats-grid">
        <div class="stat-card">
            <h3><?php echo $total_users; ?></h3>
            <p>Total Users</p>
        </div>

        <div class="stat-card">
            <h3><?php echo $total_books; ?></h3>
            <p>Total Books</p>
        </div>

        <div class="stat-card">
            <h3><?php echo $total_requests; ?></h3>
            <p>Swap Requests</p>
        </div>
    </div>

    <br>

    <a href="manage_users.php" class="btn">Manage Users</a>
    <a href="manage_books.php" class="btn btn-secondary">Manage Books</a>
</div>

<?php include "includes/footer.php"; ?>