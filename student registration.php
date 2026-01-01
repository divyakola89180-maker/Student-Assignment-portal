<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $college_id = $_POST['college_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO students (college_id, name, email, password) VALUES ('$college_id', '$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        header("Location: student_login.html");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
