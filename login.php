<?php
session_start();
include 'config.php';
include 'functions.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Encrypt the username before querying the database
    $encryptedUsername = encryptData($username);

    // Retrieve user record from the database based on encrypted username
    $sql = "SELECT * FROM users WHERE username = '$encryptedUsername'";
    $result = $conn->query($sql);

    // Check if user exists and verify password
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, set session and redirect to dashboard
            $_SESSION['username'] = $username; // Store decrypted username in session
            header("Location: dashboard.php");
            exit(); // Always use exit() after header redirect
        } else {
            $errorMessage = "Invalid username or password.";
        }
    } else {
        $errorMessage = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('pic5.jpg');
            background-size: cover;
        }
        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 320px;
            text-align: center;
        }
        h2 {
            color: #333333;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #ff3333;
            margin-top: 10px;
        }
        a {
            color: #007bff;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php
        if (isset($errorMessage)) {
            echo '<p class="error-message">' . $errorMessage . '</p>';
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p>Go back to <a href="home.html">Home</a></p>
    </div>
</body>
</html>
