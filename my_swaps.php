<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";

$user_id = $_SESSION['user_id'];

/*
========================================
INCOMING REQUESTS
Books owned by logged-in user
========================================
*/

$incoming_sql = "SELECT 
                    swap_requests.*,
                    books.title,
                    books.image,
                    books.module,
                    books.user_id AS owner_id
                 FROM swap_requests
                 JOIN books 
                    ON swap_requests.book_id = books.id
                 WHERE books.user_id = '$user_id'
                 ORDER BY swap_requests.id DESC";

$incoming_result = mysqli_query($conn, $incoming_sql);


/*
========================================
OUTGOING REQUESTS
Swaps requested by logged-in user
========================================
*/

$outgoing_sql = "SELECT 
                    swap_requests.*,
                    books.title,
                    books.image,
                    books.module
                 FROM swap_requests
                 JOIN books 
                    ON swap_requests.book_id = books.id
                 WHERE swap_requests.requester_id = '$user_id'
                 ORDER BY swap_requests.id DESC";

$outgoing_result = mysqli_query($conn, $outgoing_sql);
?>

<div class="container">

    <h2>Incoming Swap Requests</h2>

    <?php if (mysqli_num_rows($incoming_result) == 0) { ?>

        <div class="card">
            <p>No incoming swap requests.</p>
        </div>

    <?php } else { ?>

        <div class="book-grid">

            <?php while($swap = mysqli_fetch_assoc($incoming_result)) { ?>

                <div class="book-card">

                    <div class="book-image">
                        <img src="uploads/<?php echo $swap['image']; ?>">
                    </div>

                    <div class="book-info">

                        <h3><?php echo $swap['title']; ?></h3>

                        <p>
                            <strong>Module:</strong>
                            <?php echo $swap['module']; ?>
                        </p>

                        <span class="badge">
                            <?php echo $swap['status']; ?>
                        </span>

                        <?php if ($swap['status'] == "Pending") { ?>

                            <br><br>

                            <a class="btn"
                               href="approve_swap.php?swap_id=<?php echo $swap['id']; ?>">
                                Approve
                            </a>

                            <a class="btn danger"
                               href="decline_swap.php?swap_id=<?php echo $swap['id']; ?>">
                                Decline
                            </a>

                        <?php } ?>

                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } ?>


    <h2 style="margin-top: 50px;">My Sent Swap Requests</h2>

    <?php if (mysqli_num_rows($outgoing_result) == 0) { ?>

        <div class="card">
            <p>You have not requested any swaps yet.</p>

            <a href="browse_books.php" class="btn">
                Browse Books
            </a>
        </div>

    <?php } else { ?>

        <div class="book-grid">

            <?php while($swap = mysqli_fetch_assoc($outgoing_result)) { ?>

                <div class="book-card">

                    <div class="book-image">
                        <img src="uploads/<?php echo $swap['image']; ?>">
                    </div>

                    <div class="book-info">

                        <h3><?php echo $swap['title']; ?></h3>

                        <p>
                            <strong>Module:</strong>
                            <?php echo $swap['module']; ?>
                        </p>

                        <span class="badge">
                            <?php echo $swap['status']; ?>
                        </span>

                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } ?>

</div>

<?php include "includes/footer.php"; ?>