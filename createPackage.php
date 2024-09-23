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

// Get form data
$destination = $_POST['destination'];
$numTravellers = $_POST['num-travellers'];
$services = implode(", ", $_POST['services']);
$price = $_POST['price'];

// Insert data into database
$sql = "INSERT INTO package(destination, num_travellers, services, price) VALUES ('$destination', '$numTravellers', '$services', '$price')";

if ($conn->query($sql) === TRUE) {
    
    header("Location: displayPackages.html");
    echo "New package created successfully";
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
