<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $payment_details = $_POST['payment_details'];

    $conn = new mysqli("localhost", "root", "", "hotel_booking");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO bookings (room_id, user_name, user_email, payment_details) VALUES ('$room_id', '$user_name', '$user_email', '$payment_details')";
    if ($conn->query($sql) === TRUE) {
        $booking_id = $conn->insert_id;
        echo "<script>
                alert('Booking successful! Booking ID: $booking_id');
                window.location.href = 'AdminFlight.html';
              </script>";

        if ($booking_id > 0) {
            $update_sql = "UPDATE rooms SET availability = 0 WHERE id = $room_id";
            $conn->query($update_sql);

            $booking_sql = "SELECT b.id, r.hotel_name, r.location, r.room_number, r.room_type, r.price, b.user_name, b.user_email, b.payment_details, b.booking_date 
                            FROM bookings b 
                            JOIN rooms r ON b.room_id = r.id 
                            WHERE b.id = $booking_id";
            $booking_result = $conn->query($booking_sql);

            if ($booking_result) {
                $booking_details = $booking_result->fetch_assoc();
                if ($booking_details) {
                    echo "<h2>Booking Details</h2>";
                    echo "<p>Booking ID: " . (isset($booking_details['id']) ? $booking_details['id'] : 'N/A') . "</p>";
                    echo "<p>Hotel Name: " . (isset($booking_details['hotel_name']) ? $booking_details['hotel_name'] : 'N/A') . "</p>";
                    echo "<p>Location: " . (isset($booking_details['location']) ? $booking_details['location'] : 'N/A') . "</p>";
                    echo "<p>Room Number: " . (isset($booking_details['room_number']) ? $booking_details['room_number'] : 'N/A') . "</p>";
                    echo "<p>Room Type: " . (isset($booking_details['room_type']) ? $booking_details['room_type'] : 'N/A') . "</p>";
                    echo "<p>Price: $" . (isset($booking_details['price']) ? $booking_details['price'] : 'N/A') . "</p>";
                    echo "<p>User Name: " . (isset($booking_details['user_name']) ? $booking_details['user_name'] : 'N/A') . "</p>";
                    echo "<p>User Email: " . (isset($booking_details['user_email']) ? $booking_details['user_email'] : 'N/A') . "</p>";
                    echo "<p>Payment Details: " . (isset($booking_details['payment_details']) ? $booking_details['payment_details'] : 'N/A') . "</p>";
                    echo "<p>Booking Date: " . (isset($booking_details['booking_date']) ? $booking_details['booking_date'] : 'N/A') . "</p>";
                    echo "<p>Booking successful!</p>";
                } else {
                    echo "<p>No booking details found.</p>";
                }
            } else {
                echo "Error executing query: " . $conn->error . "<br>";
            }
        } else {
            echo "Error: Booking ID is 0.<br>";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    $room_id = $_GET['room_id'];
    echo "
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #65f77e;
            background-image: url('your-image-url.jpg');
            background-size: cover;
            background-position: center;
            color: #ffffff;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        form {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #3af491;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            background: #ffffff;
            color: #000000;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #3af491;
            color: #000000;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #2eaf7d;
        }
    </style>
    <form method='POST' action='book_room.php'>
        <input type='hidden' name='room_id' value='$room_id'>
        <label for='user_name'>Name:</label>
        <input type='text' id='user_name' name='user_name' required>
        <label for='user_email'>Email:</label>
        <input type='email' id='user_email' name='user_email' required>
        <label for='payment_details'>Payment Details (Card Number, CVV, etc.):</label>
        <input type='text' id='payment_details' name='payment_details' required>
        <button type='submit'>Book Now</button>
    </form>
    ";
}
?>
