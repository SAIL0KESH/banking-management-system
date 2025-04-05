<?php
session_start();
require 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "❌ Invalid username or password.";
        }
    } else {
        $message = "⚠️ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Banking System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Login</h2>
    <p style="color:red;"><?php echo $message; ?></p>
    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="Username" required /><br><br>
        <input type="password" name="password" placeholder="Password" required /><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
