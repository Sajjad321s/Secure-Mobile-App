<?php
// Encryption Key
define('ENCRYPTION_KEY', '98858e688a9c2cf5ad42aa196ec027e5');

// Encrypt data
function encryptData($data) {
    return openssl_encrypt($data, 'aes-256-cbc', ENCRYPTION_KEY, 0, substr(ENCRYPTION_KEY, 0, 16));
}

// Decrypt data
function decryptData($data) {
    return openssl_decrypt($data, 'aes-256-cbc', ENCRYPTION_KEY, 0, substr(ENCRYPTION_KEY, 0, 16));
}

// Hash and salt password
function hashPassword($password) {
    // Generate a random salt
    $salt = uniqid(mt_rand(), true);

    // Hash the password along with the salt using SHA-256 algorithm
    $hashedPassword = hash('sha256', $password . $salt);

    // Return the hashed password and salt concatenated together with a separator
    return $hashedPassword . ':' . $salt;
}

function verifyPassword($enteredPassword, $storedPassword) {
    // Split the stored password into hash and salt using the separator (':')
    $parts = explode(':', $storedPassword);
    $storedHashedPassword = $parts[0];
    $salt = $parts[1];

    // Hash the entered password with the extracted salt using SHA-256 algorithm
    $enteredHashedPassword = hash('sha256', $enteredPassword . $salt);

    // Compare the computed hash with the stored hashed password
    if ($enteredHashedPassword === $storedHashedPassword) {
        return true; // Passwords match
    } else {
        return false; // Passwords do not match
    }
}

?>
