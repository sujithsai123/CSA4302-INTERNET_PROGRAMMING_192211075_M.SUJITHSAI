<?php
// Database connection
$servername = "localhost"; // XAMPP server
$username = "root"; // Default XAMPP username
$password = ""; // No password for default XAMPP installation
$dbname = "escape"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect POST data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Prepare and bind (SQL query to insert data into the database)
$stmt = $conn->prepare("INSERT INTO bookings (name, email, phone) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $phone);

// Execute the query and check if the insertion was successful
if ($stmt->execute()) {
    echo "Booking details successfully stored!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
