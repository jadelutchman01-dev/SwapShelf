<?php
include "includes/session.php";
include "includes/db.php";

if (!isset($_GET['id'])) {
    header("Location: my_swaps.php");
    exit();
}

$id = $_GET['id'];

$sql = "UPDATE swap_requests
        SET status = 'Completed'
        WHERE id = '$id'";

mysqli_query($conn, $sql);

header("Location: my_swaps.php");
exit();

if ($swap['status'] == 'Completed') {
    echo "<script>
            alert('This swap has already been completed.');
            window.location.href='my_swaps.php';
          </script>";
    exit();
}
?>