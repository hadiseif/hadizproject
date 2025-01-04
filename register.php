<?php
session_start(); 


$host = 'localhost'; 
$db = 'maindb'; 
$user = 'root'; 
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'user'; 

    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    if ($stmt->rowCount() > 0) {
        $error = "Username already exists. Please choose another.";
    } else {
     
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        if ($stmt->execute(['username' => $username, 'password' => $hashed_password, 'role' => $role])) {
            header("Location: index.php?success=Registration successful! You can now log in.");
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 25rem;">
            <div class="card-body">
                <h5 class="card-title text-center">Register</h5>
                <form action="register.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                    <?php if (isset($error)): ?>
                        <p class="text-danger text-center mt-2"><?php echo htmlspecialchars($error); ?></p>
                    <?php endif; ?>
                    <?php if (isset($_GET['success'])): ?>
                        <p class="text-success text-center mt-2"><?php echo htmlspecialchars($_GET['success']); ?></p>
                    <?php endif; ?>
                </form>
                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-secondary">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>