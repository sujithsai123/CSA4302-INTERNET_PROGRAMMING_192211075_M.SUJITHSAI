<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b); /* New gradient colors */
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

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="submit"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: calc(100% - 22px);
        }

        input[type="submit"] {
            background: #ff6f61; /* New color */
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #e55d4a; /* New hover color */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Flight Booking</h1>
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

            echo '<form method="post" action="confirm_booking.php">
                    <input type="hidden" name="flight_id" value="' . $flight_id . '">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" required><br>
                    <input type="submit" value="Proceed">
                  </form>';
        }
        ?>
    </div>
</body>
</html>
