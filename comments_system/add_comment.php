<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['comment'])) {
    $username = $_POST['username'];
    $comment = $_POST['comment'];
    
    $stmt = $mysqli->prepare("INSERT INTO comments (username, comment) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $comment);

    if ($stmt->execute()) {
        echo "Comment added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    header('Location: comments.php');
    exit();
} else {
    echo "Invalid request";
}
?>
