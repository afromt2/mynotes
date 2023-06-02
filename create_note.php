<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userID = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = $_POST['customer_name'];
    $phoneNumber = $_POST['phone_number'];
    $content = $_POST['content'];
    $reminder = $_POST['reminder'];
    $country = $_POST['country'];
    $type = $_POST['type'];
    $propertyType = $_POST['property_type'];

    $query = "INSERT INTO notes (user_id, customer_name, phone_number, content, reminder, country, type, property_type)
              VALUES (:user_id, :customer_name, :phone_number, :content, :reminder, :country, :type, :property_type)";

    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userID);
    $statement->bindValue(':customer_name', $customerName);
    $statement->bindValue(':phone_number', $phoneNumber);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':reminder', $reminder);
    $statement->bindValue(':country', $country);
    $statement->bindValue(':type', $type);
    $statement->bindValue(':property_type', $propertyType);

    if ($statement->execute()) {
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Failed to create a note. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Note</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Create Note</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="customer_name" class="form-label">Customer Name:</label>
                <input type="text" class="form-control" name="customer_name" id="customer_name" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input type="text" class="form-control" name="phone_number" id="phone_number" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content:</label>
                <textarea class="form-control" name="content" id="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="reminder" class="form-label">Reminder:</label>
                <input type="datetime-local" class="form-control" name="reminder" id="reminder">
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country:</label>
                <input type="text" class="form-control" name="country" id="country">
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type:</label>
                <input type="text" class="form-control" name="type" id="type">
            </div>
            <div class="mb-3">
                <label for="property_type" class="form-label">Property Type:</label>
                <input type="text" class="form-control" name="property_type" id="property_type">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</body>
</html>
