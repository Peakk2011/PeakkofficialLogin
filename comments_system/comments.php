<!DOCTYPE html>
<html>

<head>
    <title>Comments System</title>
</head>

<body>
    <h1>Comment System</h1>
    <form method="POST" action="add_comment.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" required></textarea>
        <br>
        <button type="submit">Add Comment</button>
    </form>
    <h2>Comments</h2>
    <?php include 'view_comments.php'; ?>
</body>

</html>