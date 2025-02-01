<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$task_id = $_GET['id'];
$task = $conn->query("SELECT * FROM tasks WHERE id='$task_id'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $sql = "UPDATE tasks SET title='$title', description='$description', status='$status' WHERE id='$task_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: tasks.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Edit Task</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $task['title']; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required><?php echo $task['description']; ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Pending" <?php echo $task['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="In Progress" <?php echo $task['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Completed" <?php echo $task['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block">
                            Update Task
                            </button>
                        </div>
                        
                    </form>

                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>