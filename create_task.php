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
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Create Task</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <!-- حقل عنوان المهمة -->
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter task title" required>
                        </div>
                        <!-- حقل وصف المهمة -->
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter task description" required></textarea>
                        </div>
                        <!-- قائمة منسدلة لاختيار الموظف -->
                        <div class="form-group mb-3">
                            <label for="assigned_to" class="form-label">Assign To</label>
                            <select class="form-control" id="assigned_to" name="assigned_to" required>
                                <?php while($row = $employees->fetch_assoc()): ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <!-- زر إنشاء المهمة -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>