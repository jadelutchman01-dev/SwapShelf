<?php
include "includes/session.php";
include "includes/db.php";
include "includes/header.php";

$message = "";

if (isset($_POST['add_book'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $module = $_POST['module'];
    $condition_book = $_POST['condition_book'];
    $original_price = $_POST['original_price'];
    $credits_required = $_POST['credits_required'];
    $description = $_POST['description'];

    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = "uploads/" . $image_name;

    move_uploaded_file($image_tmp, $image_path);

    $sql = "INSERT INTO books (
                user_id,
                title,
                module,
                condition_book,
                original_price,
                credits_required,
                image,
                description
            )
            VALUES (
                '$user_id',
                '$title',
                '$module',
                '$condition_book',
                '$original_price',
                '$credits_required',
                '$image_name',
                '$description'
            )";

    if (mysqli_query($conn, $sql)) {
        $message = "Book added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<div class="container">
    <div class="card">
        <h2>Add a Textbook</h2>

        <p>
            Upload a textbook you no longer need. The system will automatically calculate the credits based on the original price and condition.
        </p>

        <p><?php echo $message; ?></p>

        <form method="POST" enctype="multipart/form-data">

            <input type="text" name="title" placeholder="Book Title" required>

            <input type="text" name="module" placeholder="Module or Subject" required>

            <input 
                type="number" 
                name="original_price" 
                id="original_price" 
                placeholder="Original Price" 
                min="0" 
                step="0.01" 
                required
            >

            <select name="condition_book" id="condition_book" required>
                <option value="">Select Book Condition</option>
                <option value="Excellent">Excellent</option>
                <option value="Good">Good</option>
                <option value="Fair">Fair</option>
            </select>

            <input 
                type="number" 
                name="credits_required" 
                id="credits_required" 
                placeholder="Credits Required" 
                readonly 
                required
            >

            <textarea
                name="description"
                placeholder="Describe the textbook, condition, notes, highlights, or anything important..."
                rows="5"
                required
            ></textarea>

            <input type="file" name="image" accept="image/*" required>

            <button type="submit" name="add_book">Add Book</button>

        </form>
    </div>
</div>

<script>
function calculateCredits() {
    let price = parseFloat(document.getElementById("original_price").value);
    let condition = document.getElementById("condition_book").value;
    let credits = 0;

    if (!isNaN(price) && condition !== "") {
        credits = price / 2;

        if (condition === "Good") {
            credits = credits - 20;
        } else if (condition === "Fair") {
            credits = credits - 30;
        }

        if (credits < 0) {
            credits = 0;
        }

        document.getElementById("credits_required").value = Math.round(credits);
    } else {
        document.getElementById("credits_required").value = "";
    }
}

document.getElementById("original_price").addEventListener("input", calculateCredits);
document.getElementById("condition_book").addEventListener("change", calculateCredits);
</script>

<?php include "includes/footer.php"; ?>