<?php
require_once 'includes/db.php';

$result = $mysqli->query("SELECT username, comment, created_at FROM comments ORDER BY created_at DESC");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p><strong>" . htmlspecialchars($row['username']) . ":</strong> " . htmlspecialchars($row['comment']) . " <em>[" . $row['created_at'] . "]</em></p>";
    }
} else {
    echo "No comments yet!";
}
?>
