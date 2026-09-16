<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";

$user_id = $_SESSION['user_id'];

$search = "";

$sql = "SELECT * FROM books 
        WHERE user_id != '$user_id'
        AND status = 'Available'";

if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = $_GET['search'];

    $sql .= " AND (
                title LIKE '%$search%' 
                OR module LIKE '%$search%'
              )";
}

$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<div class="container">

    <h2>Browse Textbooks</h2>

    <div class="search-bar">
        <form method="GET">
            <input 
                type="text" 
                name="search" 
                placeholder="Search by title or module..."
                value="<?php echo $search; ?>"
            >

            <button type="submit">Search</button>

            <a href="browse_books.php" class="btn btn-secondary">Clear</a>
        </form>
    </div>

    <?php if (mysqli_num_rows($result) == 0) { ?>

        <div class="card">
            <p>No available textbooks found.</p>
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

                        <a href="view_book.php?id=<?php echo $book['id']; ?>" class="btn">
                            View Book
                        </a>

                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } ?>

</div>

<?php include "includes/footer.php"; ?>