<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM books 
        WHERE user_id = '$user_id'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<div class="container">
    <h2>My Uploaded Books</h2>

    <a href="add_book.php" class="btn">Add New Book</a>

    <?php if (mysqli_num_rows($result) == 0) { ?>

        <div class="card">
            <p>You have not uploaded any books yet.</p>
        </div>

    <?php } else { ?>

        <div class="book-grid">

            <?php while($book = mysqli_fetch_assoc($result)) { ?>

                <div class="book-card">

                    <div class="book-image">
                        <img src="uploads/<?php echo $book['image']; ?>" alt="Book Image">
                    </div>

                    <div class="book-info">
                        <h3><?php echo $book['title']; ?></h3>

                        <p>
                            <strong>Module:</strong>
                            <?php echo $book['module']; ?>
                        </p>

                        <span class="badge">
                            <?php echo $book['condition_book']; ?>
                        </span>

                        <p class="credits">
                            <?php echo $book['credits_required']; ?> Credits
                        </p>

                        <p>
                            <strong>Status:</strong>
                            <?php echo $book['status']; ?>
                        </p>

                        <br>
                        <a 
    href="edit_book.php?id=<?php echo $book['id']; ?>" 
    class="btn"
>
    Edit
</a>

                        <a 
                            href="delete_book.php?id=<?php echo $book['id']; ?>" 
                            class="btn btn-secondary"
                            onclick="return confirm('Are you sure you want to delete this book?');"
                        >
                            Delete
                        </a>
                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } ?>

</div>

<?php include "includes/footer.php"; ?>