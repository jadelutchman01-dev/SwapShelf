<?php
include "includes/session.php";
include "includes/db.php";

if (isset($_GET['swap_id'])) {

    $swap_id = $_GET['swap_id'];

    // Get swap request + book details
    $swap_sql = "SELECT 
                    swap_requests.id,
                    swap_requests.book_id,
                    swap_requests.requester_id,
                    swap_requests.status,
                    books.user_id AS owner_id,
                    books.credits_required
                 FROM swap_requests
                 JOIN books ON swap_requests.book_id = books.id
                 WHERE swap_requests.id = '$swap_id'";

    $swap_result = mysqli_query($conn, $swap_sql);
    $swap = mysqli_fetch_assoc($swap_result);

    if (!$swap) {
        echo "<script>
                alert('Swap request not found.');
                window.location.href = 'my_swaps.php';
              </script>";
        exit();
    }

    if ($swap['status'] == 'Approved' || $swap['status'] == 'Completed') {
        echo "<script>
                alert('This swap has already been processed.');
                window.location.href = 'my_swaps.php';
              </script>";
        exit();
    }

    $requester_id = $swap['requester_id'];
    $owner_id = $swap['owner_id'];
    $book_id = $swap['book_id'];
    $credits_required = $swap['credits_required'];

    // Check requester has enough credits
    $user_sql = "SELECT credits FROM users WHERE id = '$requester_id'";
    $user_result = mysqli_query($conn, $user_sql);
    $user = mysqli_fetch_assoc($user_result);

    if ($user['credits'] < $credits_required) {
        echo "<script>
                alert('The requester no longer has enough credits.');
                window.location.href = 'my_swaps.php';
              </script>";
        exit();
    }

    // Deduct credits from requester
    $deduct_sql = "UPDATE users
                   SET credits = credits - $credits_required
                   WHERE id = '$requester_id'";
    mysqli_query($conn, $deduct_sql);

    // Give credits to owner plus 50 bonus
    $owner_credit_sql = "UPDATE users
                         SET credits = credits + $credits_required + 50
                         WHERE id = '$owner_id'";
    mysqli_query($conn, $owner_credit_sql);

    // Update swap status
    $approve_sql = "UPDATE swap_requests
                    SET status = 'Approved'
                    WHERE id = '$swap_id'";
    mysqli_query($conn, $approve_sql);

    // Make book unavailable
    $book_sql = "UPDATE books
                 SET status = 'Unavailable'
                 WHERE id = '$book_id'";
    mysqli_query($conn, $book_sql);

    $_SESSION['success_message'] = "Swap complete! Credits transferred and seller earned a 50 credit bonus.";

    header("Location: dashboard.php");
    exit();
}
?>