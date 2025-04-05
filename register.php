<?php
require 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        try {
            $stmt->execute(['username' => $username, 'password' => $password]);
            $message = "✅ Account created successfully!";
        } catch (PDOException $e) {
            $message = "⚠️ Error: Username may already exist.";
        }
    } else {
        $message = "❗ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Banking System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Register</h2>
    <p style="color:green;"><?php echo $message; ?></p>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Username" required /><br><br>
        <input type="password" name="password" placeholder="Password" required /><br><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
