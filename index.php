<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="jumbotron bg-light p-5 rounded shadow">
                <h1 class="display-4">Welcome to Mindset Supervisor</h1>
                <p class="lead">This is a simple task management system where employees can register, log in, create tasks, and manage them.</p>
                <hr class="my-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <p>You are logged in. <a href="tasks.php" class="btn btn-primary btn-lg">Go to Tasks</a></p>
                <?php else: ?>
                    <p>
                        <a href="login.php" class="btn btn-primary btn-lg mr-3">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="register.php" class="btn btn-success btn-lg">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>