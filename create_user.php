<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mynotes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Get username and password from form
$username = $_POST['username'];
$password = $_POST['password'];

// Hash password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user into database
$sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
$result = mysqli_query($conn, $sql);

// Check if query was successful
if ($result) {
	// User created successfully
	echo "User created successfully.";
} else {
	// User creation failed
	echo "Error creating user: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>