<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $destination = $_POST['destination'];
    $num_travellers = $_POST['numTravellers'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM flights WHERE destination = ? AND num_travellers >= ?");
    $stmt->bind_param("si", $destination, $num_travellers);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='flight'>";
            echo "Destination: " . $row["destination"] . " - Number of Travellers: " . $row["num_travellers"] . " - Departure Date: " . $row["departure_date"] . " - Return Date: " . $row["return_date"] . " - Class: " . $row["class"] . " - Price: $" . $row["price"] . "<br>";
            echo '<form method="post" action="book_flight.php">
                    <input type="hidden" name="flight_id" value="' . $row["id"] . '">
                    <input type="submit" value="Book Now">
                  </form>';
            echo "</div><br>";
        }
    } else {
        echo "No flights found";
    }

    $stmt->close();
    $conn->close();
}
?>
