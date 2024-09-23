<?php
$mysqli = new mysqli('localhost', 'root', '', 'travel_booking');

if ($mysqli->connect_error) {
    die('Connection Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM packages");
$packages = array();

while ($row = $result->fetch_assoc()) {
    $packages[] = $row;
}

echo json_encode($packages);
?>
