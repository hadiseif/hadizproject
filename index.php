<?php
session_start(); 


if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admindb.php');
        exit();
    } else {
        header('Location: userhome.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 25rem;">
            <div class="card-body">
                <h5 class="card-title text-center">Login</h5>
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                    <?php if (isset($_GET['error'])): ?>
                        <p class="text-danger text-center mt-2"><?php echo htmlspecialchars($_GET['error']); ?></p>
                    <?php endif; ?>
                </form>
                <div class="text-center mt-3">
                    <a href="register.php" class="btn btn-secondary">Register</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>