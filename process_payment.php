<?php
$mysqli = new mysqli('localhost', 'root', '', 'travel_booking');

if ($mysqli->connect_error) {
    die('Connection Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Check if the necessary POST data exists
if (isset($_POST['booking_id']) && isset($_POST['payment_method']) && isset($_POST['card_number']) && isset($_POST['cvv'])) {
    $booking_id = $_POST['booking_id'];
    $payment_method = $_POST['payment_method'];
    $card_number = $_POST['card_number'];
    $cvv = $_POST['cvv'];

    // Validate booking ID exists in the bookings table
    $result = $mysqli->query("SELECT id FROM bookings WHERE id = $booking_id");
    if ($result->num_rows > 0) {
        // Insert payment details into the database
        $stmt = $mysqli->prepare("INSERT INTO payments (booking_id, payment_method, card_number, cvv) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isss', $booking_id, $payment_method, $card_number, $cvv);
        $stmt->execute();
        $stmt->close();

        // Fetch package and payment details for confirmation
        $packageResult = $mysqli->query("SELECT packages.destination, packages.start_date, packages.end_date, packages.price FROM bookings 
                                         JOIN packages ON bookings.package_id = packages.id WHERE bookings.id = $booking_id");
        $package = $packageResult->fetch_assoc();

        // After processing, render HTML for the payment confirmation
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Confirmation</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .confirmation-container {
                    background-color: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                    text-align: center;
                    animation: fadeIn 0.5s ease-in-out;
                }
                h1 {
                    color: #28a745;
                    margin-bottom: 20px;
                }
                .details {
                    text-align: left;
                    margin: 20px 0;
                    line-height: 1.6;
                }
                .details span {
                    font-weight: bold;
                }
                button {
                    background-color: #28a745;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 16px;
                    margin-top: 20px;
                }
                button:hover {
                    background-color: #218838;
                }
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            </style>
        </head>
        <body>
            <div class='confirmation-container'>
                <h1>Payment Successful!</h1>
                <div class='details'>
                    <p><span>Destination:</span> <?php echo $package['destination']; ?></p>
                    <p><span>Start Date:</span> <?php echo $package['start_date']; ?></p>
                    <p><span>End Date:</span> <?php echo $package['end_date']; ?></p>
                    <p><span>Price:</span> $<?php echo $package['price']; ?></p>
                    <p><span>Payment Method:</span> <?php echo $payment_method; ?></p>
                </div>
                <button onclick="window.location.href='index.html'">Back to Home</button>
            </div>
            <script>alert('Payment successful!');</script>
        </body>
        </html>
        <?php
    } else {
        echo "Error: Invalid booking ID.";
    }
} else {
    echo "Error: Missing payment details.";
}
?>
