<?php
session_start();
if(!isset($_SESSION['student_id'])) {
    header("Location: student_login.html");
    exit();
}

include "db.php";

$student_id = $_SESSION['student_id'];

// Handle File Upload
if(isset($_POST['submit'])) {
    $due_date = $_POST['due_date'];
    $file = $_FILES['assignment']['name'];
    $target = "uploads/".basename($file);
    $fileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

    if($fileType == "pdf" || $fileType == "jpg" || $fileType == "png") {
        if(move_uploaded_file($_FILES['assignment']['tmp_name'], $target)) {
            $conn->query("INSERT INTO assignments (student_id, file_name, due_date) VALUES ('$student_id','$file','$due_date')");
            $msg = "File uploaded successfully!";
        } else {
            $msg = "Failed to upload file!";
        }
    } else {
        $msg = "Only PDF, JPG, PNG allowed!";
    }
}

// Fetch Assignments
$assignments = $conn->query("SELECT * FROM assignments WHERE student_id='$student_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['student_name']; ?></h2>

        <?php if(isset($msg)) echo "<p>$msg</p>"; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <label>Assignment Due Date:</label>
            <input type="date" name="due_date" required>
            <input type="file" name="assignment" required>
            <button type="submit" name="submit">Upload Assignment</button>
        </form>

        <h3>Your Submissions</h3>
        <table>
            <tr>
                <th>File</th>
                <th>Submission Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
            <?php while($row = $assignments->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['file_name']; ?></td>
                <td><?php echo $row['submission_date']; ?></td>
                <td><?php echo $row['due_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </main>
</body>
</html>
