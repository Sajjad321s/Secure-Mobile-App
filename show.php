<?php
session_start();
include 'config.php';
include 'functions.php';

//if (!isset($_SESSION['username'])) {
//    header("Location: login.php");
  //  exit();
//}

// Retrieve all user information including the actual id values
$sql = "SELECT id, username, email, password, phone_no FROM users ORDER BY id ASC";
$result = $conn->query($sql);

// Include a CSS style block to apply aesthetic styling
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        p {
            text-align: center;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>
';

// Start displaying the user information
echo '<h2>User Information</h2>';

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>ID</th><th>Username</th><th>Email</th><th>Password (Hashed)</th><th>Phone No</th></tr>';

    while($row = $result->fetch_assoc()) {
        $decryptedUsername = decryptData($row['username']);
        $decryptedEmail = decryptData($row['email']);
        $decryptedPhone = decryptData($row['phone_no']);

        // Display each user's information in a table row
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>'; // Display the actual ID value
        echo '<td>' . $decryptedUsername . '</td>';
        echo '<td>' . $decryptedEmail . '</td>';
        echo '<td>' . $row['password'] . '</td>'; // Display the hashed password (for debugging only)
        echo '<td>' . $decryptedPhone . '</td>';
        echo '</tr>';
    }

    echo '</table>'; // Close the table
} else {
    // Display a message if no users are found
    echo '<p>No user information found.</p>';
}

echo '
</body>
</html>
';

$conn->close(); // Close the database connection
?>
