<?php
$mysqli = new mysqli('localhost', 'root', '', 'travel_booking');

if ($mysqli->connect_error) {
    die('Connection Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$id = $_GET['id'];

$mysqli->query("DELETE FROM packages WHERE id = $id");

header('Location: admin.html');
?>
