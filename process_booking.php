<?php
$mysqli = new mysqli('localhost', 'root', '', 'travel_booking');

if ($mysqli->connect_error) {
    die('Connection Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$package_id = $_POST['package_id'];
$user_name = $_POST['user_name'];
$email = $_POST['email'];
$contact = $_POST['contact'];

// Insert booking
$stmt = $mysqli->prepare("INSERT INTO bookings (package_id, user_name, email, contact) VALUES (?, ?, ?, ?)");
$stmt->bind_param('isss', $package_id, $user_name, $email, $contact);
$stmt->execute();
$booking_id = $stmt->insert_id;
$stmt->close();

// Redirect to payment page
header("Location: Travelpayent.html?booking_id=$booking_id");
?>
