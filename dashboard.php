<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get total registered user count
$queryUserCount = "SELECT COUNT(*) AS total_users FROM users";
$statementUserCount = $db->query($queryUserCount);
$totalUserCount = $statementUserCount->fetch(PDO::FETCH_ASSOC)['total_users'];

// Get user names and total notes count
$queryUserNotesCount = "SELECT u.username, COUNT(n.id) AS total_notes 
                        FROM users u 
                        LEFT JOIN notes n ON u.id = n.user_id 
                        GROUP BY u.id";
$statementUserNotesCount = $db->query($queryUserNotesCount);
$userNotesCounts = $statementUserNotesCount->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <?php include 'navigation.php'; ?>
    
    <div class="container">
        <h1>Dashboard</h1>
        <h3>Total Registered Users: <?php echo $totalUserCount; ?></h3>
        <h3>User Notes:</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Total Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userNotesCounts as $userNotes): ?>
                    <tr>
                        <td><?php echo $userNotes['username']; ?></td>
                        <td><?php echo $userNotes['total_notes']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>