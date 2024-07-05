<?php
include 'config.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_no= $_POST['phone_no'];

    // Hash and salt the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
   

    // Encrypt user data
    $encryptedUsername = encryptData($username);
    $encryptedEmail = encryptData($email);
    $encryptedPhone = encryptData($phone_no);

    $sql = "INSERT INTO users (username, email, password, phone_no) VALUES ('$encryptedUsername', '$encryptedEmail', '$hashedPassword', '$encryptedPhone')";

    if ($conn->query($sql) === TRUE) {
        $success= "Registration successful!";
    } else {
        $error= "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            background-image: url('pic4.avif');
            background-size: cover;
        }
        .container {
            max-width: 400px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
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
        a {
            color: #007bff;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }
        a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #ff3333;
            margin-top: 10px;
        }
        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php
        if (isset($success)) {
            echo '<p class="success-message">' . $success . '</p>';
        }
        elseif (isset($error)){
            echo '<p class="error-message">' . $error . '</p>';

        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="text" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="text" name="phone_no" placeholder="Phone No" required><br>
            <input type="submit" value="Register">
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
        <p>Go back to <a href="home.html">Home</a></p>
    </div>
</body>
</html>


