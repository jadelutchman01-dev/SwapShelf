<?php
include "includes/session.php";
include "includes/db.php";

if (!isset($_GET['id'])) {
    header("Location: my_books.php");
    exit();
}

$book_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM books 
        WHERE id = '$book_id' 
        AND user_id = '$user_id'";

mysqli_query($conn, $sql);

header("Location: my_books.php");
exit();
?>