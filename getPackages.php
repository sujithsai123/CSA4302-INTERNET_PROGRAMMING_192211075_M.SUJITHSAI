<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "escape";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$sql = "SELECT destination, num_travellers, services, price FROM package";
$result = $conn->query($sql);

$packages = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($packages);

$conn->close();
?>
