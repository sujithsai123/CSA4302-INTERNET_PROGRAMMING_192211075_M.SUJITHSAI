<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #6dd5fa, #2980b9);
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            color: #ff6f61; /* New color */
            font-size: 2em; /* Larger font size */
            text-transform: uppercase; /* Uppercase text */
            letter-spacing: 2px; /* Spacing between letters */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Text shadow */
        }
        p {
            margin: 10px 0;
            font-family: 'Courier New', Courier, monospace; /* Different font */
            color: #555; /* Different color */
        }
        .flight-details {
            font-family: 'Georgia', serif; /* Different font */
            color: #2980b9; /* Different color */
        }
        button {
            padding: 10px;
            background: #2980b9;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #1a5276;
        }
    </style>
</head>
<body>
    <div class="container">
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

            $flight_id = $_POST['flight_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO booking (flight_id, name, email, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $flight_id, $name, $email, $phone);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "<h1>Booking successful!</h1>";
                echo "<p>Name: " . $name . "</p>";
                echo "<p>Email: " . $email . "</p>";
                echo "<p>Phone: " . $phone . "</p>";

                // Fetch and display the selected flight details
                $stmt = $conn->prepare("SELECT * FROM flights WHERE id = ?");
                $stmt->bind_param("i", $flight_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<div class='flight-details'>";
                    echo "<p>Flight Details:</p>";
                    echo "<p>Destination: " . $row["destination"] . "</p>";
                    echo "<p>Number of Travellers: " . $row["num_travellers"] . "</p>";
                    echo "<p>Departure Date: " . $row["departure_date"] . "</p>";
                    echo "<p>Return Date: " . $row["return_date"] . "</p>";
                    echo "<p>Class: " . $row["class"] . "</p>";
                    echo "<p>Price: $" . $row["price"] . "</p>";
                    echo "</div>";
                } else {
                    echo "<p>Flight details not found.</p>";
                }
            } else {
                echo "<p>Booking failed. Please try again.</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
        <br>
        <a href="index.html">
            <button>Back</button>
        </a>
    </div>
</body>
</html>
