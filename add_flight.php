<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_booking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_POST['id'];
$destination = $_POST['destination'];
$num_travellers = $_POST['numTravellers'];
$departure_date = $_POST['departureDate'];
$return_date = $_POST['returnDate'];
$class = $_POST['class'];
$price = $_POST['price'];

$sql = "INSERT INTO flights(id, destination, num_travellers, departure_date, return_date, class, price) VALUES ($id,'$destination', $num_travellers, '$departure_date', '$return_date', '$class', $price)";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('New flight added successfully');
            window.location.href = 'AdminFlight.html';
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
