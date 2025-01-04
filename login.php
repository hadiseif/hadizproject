<?php
session_start(); 

include('config.php'); 


$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';


$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($user && password_verify($password, $user['password'])) {
    $_SESSION['role'] = $user['role']; 
    
    header('Location: ' . ($user['role'] === 'admin' ? 'admindb.php' : 'userhome.php'));
    exit();
} else {
    
    header('Location: index.php?error=Invalid username or password.');
    exit();
}
?>
