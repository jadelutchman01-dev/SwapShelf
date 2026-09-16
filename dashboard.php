<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";
?>

<?php
if (isset($_SESSION['success_message'])) {
?>
    <div class="success-message">
        <?php
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        ?>
    </div>
<?php
}
?>

<div class="container">
    <h2>Welcome, <?php echo $_SESSION['fullname']; ?>!</h2>

    <div class="card">
        <h3>What would you like to do?</h3>

        <a class="btn" href="add_book.php">Add a Book</a>
        <a class="btn" href="browse_books.php">Browse Books</a>
        <a class="btn" href="my_books.php">My Books</a>
        <a class="btn" href="my_swaps.php">My Swaps</a>
    </div>
</div>

<div class="credit-info">

    <h2>How Book Credits Work</h2>

    <p>
        Credits are automatically calculated based on the original price and condition of the book.
    </p>

    <ul>
        <li>
            <strong>Excellent Condition:</strong>
            Credits = Half of the original book price
        </li>

        <li>
            <strong>Good Condition:</strong>
            Credits = Half of the original book price minus 20 credits
        </li>

        <li>
            <strong>Fair Condition:</strong>
            Credits = Half of the original book price minus 30 credits
        </li>
    </ul>

    <p>
        Example: A book priced at R200 in excellent condition will be worth 100 credits.
    </p>

    <p>
        When a swap is completed, both users earn 100 credits.
    </p>

</div>

<?php include "includes/footer.php"; ?>