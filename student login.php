<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $college_id = $_POST['college_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE college_id='$college_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        if (password_verify($password, $student['password'])) {
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['name'];
            header("Location: student_dashboard.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No student found!";
    }
}
?>
