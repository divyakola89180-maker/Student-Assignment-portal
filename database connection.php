<?php
$host = "localhost";
$user = "root"; // default XAMPP/WAMP user
$pass = "";     // default password
$db   = "swarnandhra_portal";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
