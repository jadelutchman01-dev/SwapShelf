<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT swap_requests.*, books.title, books.image, books.module, users.fullname
        FROM swap_requests
        JOIN books ON swap_requests.book_id = books.id
        JOIN users ON swap_requests.requester_id = users.id
        WHERE books.user_id = '$user_id'
        ORDER BY swap_requests.id DESC";

$result = mysqli_query($conn, $sql);
?>

<div class="container">
    <h2>Incoming Swap Requests</h2>

    <div class="book-grid">

        <?php while($request = mysqli_fetch_assoc($result)) { ?>

            <div class="book-card">
                <div class="book-image">
                    <img src="uploads/<?php echo $request['image']; ?>">
                </div>

                <div class="book-info">
                    <h3><?php echo $request['title']; ?></h3>
                    <p><strong>Module:</strong> <?php echo $request['module']; ?></p>
                    <p><strong>Requested by:</strong> <?php echo $request['fullname']; ?></p>
                   <?php
$badgeClass = "";

if ($swap['status'] == "Completed") {
    $badgeClass = "completed";
}

if ($swap['status'] == "Declined") {
    $badgeClass = "declined";
}
?>

<span class="badge <?php echo $badgeClass; ?>">
    <?php echo $swap['status']; ?>
</span>
                    <br><br>

<?php if ($request['status'] == "Pending") { ?>

    <br><br>

    <a class="btn" href="update_request.php?id=<?php echo $request['id']; ?>&status=Approved">
        Approve
    </a>

    <a class="btn btn-secondary" href="update_request.php?id=<?php echo $request['id']; ?>&status=Declined">
        Decline
    </a>

<?php } ?>
        <?php } ?>

    </div>
</div>

<?php include "includes/footer.php"; ?>