<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "escape";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'create') {
    $destination = $_POST['destination'];
    $num_travellers = $_POST['num-travellers'];
    $services = implode(", ", $_POST['services']);
    $price = $_POST['price'];

    $sql = "INSERT INTO package (destination, num_travellers, services, price)
            VALUES ('$destination', '$num_travellers', '$services', '$price')";

    if ($conn->query($sql) === TRUE) {
        header("Location: displayPackages.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
