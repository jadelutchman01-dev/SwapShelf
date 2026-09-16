<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";

if (!isset($_GET['id'])) {
    header("Location: browse_books.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM books WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

$book = mysqli_fetch_assoc($result);
?>

<div class="container">

    <div class="view-book-container">

        <div class="view-book-image">
            <img src="uploads/<?php echo $book['image']; ?>">
        </div>

        <div class="view-book-details">

            <span class="badge">
                <?php echo $book['condition_book']; ?>
            </span>

            <h1><?php echo $book['title']; ?></h1>

            <p>
                <strong>Module:</strong>
                <?php echo $book['module']; ?>
            </p>

            <p>
                <strong>Credits Required:</strong>
                <?php echo $book['credits_required']; ?>
            </p>

            <p>
                <strong>Description:</strong>
            </p>

            <p>
                <div class="description-box">
    <?php echo nl2br($book['description']); ?>
</div>
            </p>

            <a href="request_swap.php?id=<?php echo $book['id']; ?>" class="btn">
                Request Swap
            </a>

        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>