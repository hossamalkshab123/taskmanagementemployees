<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$task_id = $_GET['id'];
$task = $conn->query("SELECT * FROM tasks WHERE id='$task_id'")->fetch_assoc();

if ($task['assigned_by'] != $_SESSION['user_id']) {
    die("You do not have permission to delete this task.");
}

$sql = "DELETE FROM tasks WHERE id='$task_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: tasks.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>