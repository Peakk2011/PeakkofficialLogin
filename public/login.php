<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header('Location: home.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hash);
    $stmt->fetch();
    $stmt->close();

    if ($hash && verifyPassword($password, $hash)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;

        // ตั้งคุกกี้เพื่อจำสถานะการล็อกอิน
        setcookie("logged_in", true, time() + (86400 * 30), "/");
        setcookie("username", $username, time() + (86400 * 30), "/");

        header('Location: home.php');
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/styles.css">
    <meta name="color-scheme" content="dark light">
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form method="post" id="loginForm">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <?php if ($error) { ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>

        <?php
        // if (isset($_COOKIE['recent_accounts'])) {
        //     $recent_accounts = json_decode($_COOKIE['recent_accounts'], true);
        //     if (!empty($recent_accounts)) {
        //         echo '<h2>Recent Account</h2>';
        //         echo '<p><a href="#" onclick="fillUsername(\'' . htmlspecialchars($recent_accounts[0]) . '\')">' . htmlspecialchars($recent_accounts[0]) . '</a></p>';
        //     }
        // }
        ?>
    </div>
    <script>
        function fillUsername(username) {
            document.getElementById('username').value = username;
            document.getElementById('password').value = ''; // ทำให้ผู้ใช้ใส่รหัสผ่านเอง
            document.getElementById('password').focus(); // ให้ฟิลด์รหัสผ่านมีโฟกัส
        }
    </script>
</body>

</html>
