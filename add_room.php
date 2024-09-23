<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotel_name = $_POST['hotel_name'];
    $location = $_POST['location'];
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];

    $sql = "INSERT INTO rooms (hotel_name, location, room_number, room_type, price, availability) VALUES ('$hotel_name', '$location', '$room_number', '$room_type', '$price', 1)";

    if ($conn->query($sql) === TRUE) {
        echo "New room added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
