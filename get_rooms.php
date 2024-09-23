<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM rooms WHERE availability = 1";
$result = $conn->query($sql);

$rooms = array();
while($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

echo json_encode($rooms);

$conn->close();
?>
