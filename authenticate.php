<?php
include 'includes/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM employees WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        session_start();
        $_SESSION['user_id'] = $row['id'];
        header("Location: tasks.php");
    } else {
        echo "Invalid password";
    }
} else {
    echo "No user found";
}

$conn->close();
?>