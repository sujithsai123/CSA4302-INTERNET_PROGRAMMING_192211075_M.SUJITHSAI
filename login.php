<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "escape";

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $stmt->close();
            $conn->close();
            header("Location: index.html");
            exit();
        } else {
            $stmt->close();
            $conn->close();
            header("Location: login.html?error=invalid");
            exit();
        }
    } else {
        $conn->close();
        header("Location: login.html?error=stmt");
        exit();
    }
}
?>
