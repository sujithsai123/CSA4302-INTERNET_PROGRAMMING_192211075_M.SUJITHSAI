<?php
$mysqli = new mysqli('localhost', 'root', '', 'travel_booking');

if ($mysqli->connect_error) {
    die('Connection Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$destination = $_POST['destination'];
$num_travelers = $_POST['num_travelers'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$price = $_POST['price'];

$stmt = $mysqli->prepare("INSERT INTO packages (destination, num_travelers, start_date, end_date, price) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sissd', $destination, $num_travelers, $start_date, $end_date, $price);
$stmt->execute();
$stmt->close();

header('Location: admin.html');
?>
