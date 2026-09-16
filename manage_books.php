<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";

$sql = "SELECT books.*, users.fullname
        FROM books
        JOIN users ON books.user_id = users.id
        ORDER BY books.id DESC";

$result = mysqli_query($conn, $sql);
?>

<div class="container">

    <h2>Manage Books</h2>
    <p>View all uploaded textbooks on SwapShelf.</p>

    <div class="card">

        <table class="admin-table">

            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Module</th>
                <th>Owner</th>
                <th>Condition</th>
                <th>Credits</th>
                <th>Status</th>
            </tr>

            <?php while($book = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td>
                        <img 
                            src="uploads/<?php echo $book['image']; ?>" 
                            width="70"
                            style="border-radius: 10px;"
                        >
                    </td>

                    <td><?php echo $book['title']; ?></td>

                    <td><?php echo $book['module']; ?></td>

                    <td><?php echo $book['fullname']; ?></td>

                    <td><?php echo $book['condition_book']; ?></td>

                    <td><?php echo $book['credits_required']; ?></td>

                    <td><?php echo $book['status']; ?></td>

                </tr>

            <?php } ?>

        </table>

    </div>

    <br>

    <a href="admin_dashboard.php" class="btn btn-secondary">
        Back to Admin Dashboard
    </a>

</div>

<?php include "includes/footer.php"; ?>