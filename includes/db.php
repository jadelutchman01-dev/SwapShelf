<?php

$conn = mysqli_connect("localhost", "root", "", "swapshelf");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>