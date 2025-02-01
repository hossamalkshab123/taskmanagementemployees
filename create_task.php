<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];
    $assigned_by = $_SESSION['user_id'];

    $sql = "INSERT INTO tasks (title, description, assigned_by, assigned_to) VALUES ('$title', '$description', '$assigned_by', '$assigned_to')";

    if ($conn->query($sql) === TRUE) {
        header("Location: tasks.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$employees = $conn->query("SELECT * FROM employees");
?>
<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Create Task</h2>
    <form method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="assigned_to">Assign To</label>
            <select class="form-control" id="assigned_to" name="assigned_to" required>
                <?php while($row = $employees->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>