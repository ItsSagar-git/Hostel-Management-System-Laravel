<?php
session_start();
include('includes/config.php');

if (isset($_GET['id'])) {
    $hostel_id = $_GET['id'];

    // Fetch the photo BLOB from the database
    $query = "SELECT hostel_photo FROM hostels WHERE hostel_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $hostel_id);
    $stmt->execute();
    $stmt->bind_result($hostel_photo);
    $stmt->fetch();
    $stmt->close();

    // Output the image
    header("Content-Type: image/jpeg"); // Adjust the content type if your images are in another format
    echo $hostel_photo;
}
?>
