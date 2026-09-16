<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";

if (!isset($_GET['id'])) {
    header("Location: my_books.php");
    exit();
}

$book_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM books 
        WHERE id = '$book_id' 
        AND user_id = '$user_id'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: my_books.php");
    exit();
}

$book = mysqli_fetch_assoc($result);

$message = "";

if (isset($_POST['update_book'])) {
    $title = $_POST['title'];
    $module = $_POST['module'];
    $condition_book = $_POST['condition_book'];
    $credits_required = $_POST['credits_required'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $update_sql = "UPDATE books SET
                    title = '$title',
                    module = '$module',
                    condition_book = '$condition_book',
                    credits_required = '$credits_required',
                    description = '$description',
                    status = '$status'
                   WHERE id = '$book_id'
                   AND user_id = '$user_id'";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: my_books.php");
        exit();
    } else {
        $message = "Error updating book: " . mysqli_error($conn);
    }
}
?>

<div class="container">
    <div class="card">
        <h2>Edit Book</h2>
        <p>Update your textbook listing details.</p>

        <p><?php echo $message; ?></p>

        <form method="POST">
            <input 
                type="text" 
                name="title" 
                value="<?php echo $book['title']; ?>" 
                required
            >

            <input 
                type="text" 
                name="module" 
                value="<?php echo $book['module']; ?>" 
                required
            >

            <select name="condition_book" required>
                <option value="Excellent" <?php if($book['condition_book'] == "Excellent") echo "selected"; ?>>
                    Excellent
                </option>

                <option value="Good" <?php if($book['condition_book'] == "Good") echo "selected"; ?>>
                    Good
                </option>

                <option value="Fair" <?php if($book['condition_book'] == "Fair") echo "selected"; ?>>
                    Fair
                </option>
            </select>

            <input 
                type="number" 
                name="credits_required" 
                value="<?php echo $book['credits_required']; ?>" 
                required
            >

            <textarea 
                name="description" 
                rows="5" 
                required
            ><?php echo $book['description']; ?></textarea>

            <select name="status" required>
                <option value="Available" <?php if($book['status'] == "Available") echo "selected"; ?>>
                    Available
                </option>

                <option value="Unavailable" <?php if($book['status'] == "Unavailable") echo "selected"; ?>>
                    Unavailable
                </option>
            </select>

            <button type="submit" name="update_book">Update Book</button>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>