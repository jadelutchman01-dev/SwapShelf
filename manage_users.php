<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";

$sql = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container">
    <h2>Manage Users</h2>
    <p>View all registered SwapShelf users.</p>

    <div class="card">
        <table class="admin-table">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Credits</th>
            </tr>

            <?php while($user = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['fullname']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['credits']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <br>
    <a href="admin_dashboard.php" class="btn btn-secondary">Back to Admin Dashboard</a>
</div>

<?php include "includes/footer.php"; ?>