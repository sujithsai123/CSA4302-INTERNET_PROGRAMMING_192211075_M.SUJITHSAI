<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'escape');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the booking ID from the query string
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

// Fetch user and package details
$sql = "
    SELECT bookings.name, bookings.email, bookings.phone, 
           package.destination, package.num_travellers, 
           package.services, package.price 
    FROM bookings 
    JOIN package ON bookings.package_id = package.id 
    WHERE bookings.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'No booking found']);
}

$stmt->close();
$conn->close();
?>
