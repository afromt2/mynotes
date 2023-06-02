<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
require_once 'db.php';

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

// Perform basic form validation
if (empty($username) || empty($password) || empty($confirmPassword)) {
    echo "Please fill in all the required fields.";
    exit;
}

// Check if the password and confirm password match
if ($password !== $confirmPassword) {
    echo "Password and confirm password do not match.";
    exit;
}

// Check if the username already exists in the database
$query = "SELECT id FROM users WHERE username = :username";
$stmt = $conn->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "Username already exists. Please choose a different username.";
    exit;
}

// Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user into the database
$query = "INSERT INTO users (username, password) VALUES (:username, :password)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $hashedPassword);
$stmt->execute();

echo "Registration successful. You can now <a href='login.php'>login</a>.";

// Close the database connection
$conn = null;
?>