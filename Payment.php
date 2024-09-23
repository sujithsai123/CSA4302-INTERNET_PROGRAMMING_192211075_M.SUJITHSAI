<?php
// bookingDetails.php (Backend API)

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

// Get package ID and user ID from the URL parameters
$package = $_GET['package'];
$bookings= $_GET['bookings'];

// Fetch package details
$package_sql = "SELECT * FROM package WHERE id = '$package'";
$package_result = $conn->query($package_sql);
$package = $package_result->fetch_assoc();

// Fetch user details
$user_sql = "SELECT * FROM bookings WHERE id = '$bookings'";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();

// Send JSON response
$response = [
    "package" => $package,
    "user" => $user
];

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
