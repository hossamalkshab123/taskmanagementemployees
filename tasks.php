<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];

// استعلام لاستخراج المهام مع أسماء الموظفين
$sql = "
    SELECT 
        tasks.id, 
        tasks.title, 
        tasks.description, 
        tasks.status, 
        creator.name AS assigned_by_name, 
        assignee.name AS assigned_to_name 
    FROM 
        tasks 
    JOIN 
        employees AS creator ON tasks.assigned_by = creator.id 
    JOIN 
        employees AS assignee ON tasks.assigned_to = assignee.id 
    WHERE 
        tasks.assigned_to='$user_id' OR tasks.assigned_by='$user_id'
";
$result = $conn->query($sql);

// استعلام لاستخراج بيانات المستخدم الحالي
$user_sql = "SELECT * FROM employees WHERE id='$user_id'";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <!-- قسم البروفايل -->
    <div class="profile-section card mb-4">
        <div class="card-body">
            <h3 class="card-title">Profile</h3>
            <p class="card-text"><strong>Name:</strong> <?php echo $user['name']; ?></p>
            <p class="card-text"><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <div class="d-flex gap-2">
                <a href="logout.php" class="btn btn-warning">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <a href="index.php" class="btn btn-info">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- عنوان الصفحة وزر إنشاء مهمة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tasks</h2>
        <a href="create_task.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Create Task
        </a>
    </div>

    <!-- جدول المهام -->
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Assigned By</th>
                <th>Assigned To</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    <span class="badge 
                        <?php 
                        if ($row['status'] == 'Pending') echo 'bg-warning';
                        elseif ($row['status'] == 'In Progress') echo 'bg-primary';
                        else echo 'bg-success';
                        ?>">
                        <?php echo $row['status']; ?>
                    </span>
                </td>
                <td><?php echo $row['assigned_by_name']; ?></td>
                <td><?php echo $row['assigned_to_name']; ?></td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="edit_task.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?');">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'includes/footer.php'; ?>