<?php 
include "includes/session.php";
include "includes/db.php";

if (!isset($_GET['id'])) {
    header("Location: browse_books.php");
    exit();
}

$book_id = $_GET['id'];
$requester_id = $_SESSION['user_id'];

$book_sql = "SELECT * FROM books WHERE id = '$book_id'";
$book_result = mysqli_query($conn, $book_sql);
$book = mysqli_fetch_assoc($book_result);

if (!$book) {
    header("Location: browse_books.php");
    exit();
}

$owner_id = $book['user_id'];

// Stop users from requesting their own book
if ($owner_id == $requester_id) {
    echo "<script>
            alert('You cannot request your own book.');
            window.location.href = 'browse_books.php';
          </script>";
    exit();
}

$credits_required = $book['credits_required'];

$user_sql = "SELECT credits FROM users WHERE id = '$requester_id'";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

$user_credits = $user['credits'];

if ($user_credits < $credits_required) {
    echo "<script>
            alert('You do not have enough credits to request this book.');
            window.location.href = 'browse_books.php';
          </script>";
    exit();
}

$check_sql = "SELECT * FROM swap_requests 
              WHERE book_id = '$book_id' 
              AND requester_id = '$requester_id'";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) == 0) {
    $insert_sql = "INSERT INTO swap_requests (book_id, requester_id, status)
                   VALUES ('$book_id', '$requester_id', 'Pending')";
    mysqli_query($conn, $insert_sql);
} else {
    echo "<script>
            alert('You have already requested this book.');
            window.location.href = 'browse_books.php';
          </script>";
    exit();
}

header("Location: my_swaps.php");
exit();
?>