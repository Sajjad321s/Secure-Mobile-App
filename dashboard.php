<?php
session_start();
include 'config.php';
include 'functions.php';

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Handle logout action
if (isset($_GET['logout'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to home.html after logout
    header("Location: home.html");
    exit();
}

$username = $_SESSION['username'];

// Decrypt and fetch user information
$sql = "SELECT * FROM users WHERE username = '" . encryptData($username) . "'";
$result = $conn->query($sql);

// Display user information and logout button
echo '<div style="display: flex; justify-content: center; align-items: center; height: 100vh; font-family: Arial, sans-serif;">';
echo '<div style="border: 2px solid #007bff; border-radius: 12px; padding: 30px; max-width: 600px; width: 80%; text-align: center; background-color: #f8f9fa; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">';

echo '<h2 style="font-size: 32px; color: #007bff; margin-bottom: 20px;">User Information</h2>';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $decryptedUsername = decryptData($row['username']);
        $decryptedEmail = decryptData($row['email']);
        $decryptedPhone = decryptData($row['phone_no']);

        echo '<p style="font-size: 24px;"><strong>Username:</strong> ' . $decryptedUsername . '</p>';
        echo '<p style="font-size: 24px;"><strong>Email:</strong> ' . $decryptedEmail . '</p>';
        echo '<p style="font-size: 24px;"><strong>Phone No:</strong> ' . $decryptedPhone . '</p>';
    }
} else {
    echo '<p style="font-size: 24px; color: red;">User information not found.</p>';
}

// Add logout button/link
echo '<a href="?logout" style="text-decoration: none; font-size: 20px; color: #007bff; margin-top: 20px;">Logout</a>';

echo '</div>';
echo '</div>';

$conn->close(); // Close the database connection
?>
