<?php
// dashboard.php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <meta name="color-scheme" content="dark light">
</head>
<body>
    <div class="container">
        <h1>Welcome to your Dashboard, <?php echo $_SESSION['username']; ?>!</h1>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
