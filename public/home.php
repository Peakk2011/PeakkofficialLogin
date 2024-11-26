<?php
session_start();

if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true) {
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $_COOKIE['username'];
}

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_username'])) {
    $new_username = $_POST['new_username'];
    $user_id = $_SESSION['user_id'];

    require_once '../includes/db.php';

    $stmt = $mysqli->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->bind_param('si', $new_username, $user_id);

    if ($stmt->execute()) {
        $_SESSION['username'] = $new_username;
        setcookie('username', $new_username, time() + (86400 * 30), "/");
        header('Location: home.php');
        exit();
    } else {
        echo "Failed to update username";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($username); ?> - Peakkofficial</title>
    <meta name="color-scheme" content="dark light">
    <link rel="stylesheet" href="../css/mainpage.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>

    <nav>
        <div class="Navbar">
            <div class="NavLogo">
                <ion-icon name="person-sharp"></ion-icon>
                <h1 id="username-display"><?php echo htmlspecialchars($username); ?></h1>
            </div>
            <div class="navbarlinks">
                <li><a href="#" id="HighlightNavbar">หน้าแรก</a></li>
                <li><a href="./logout.php">ออกจากระบบ</a></li>
            </div>
        </div>
    </nav>

    <div class="form-container">
        <form method="POST" action="home.php">
            <h2>เปลี่ยนชื่อผู้ใช้</h2>
            <label for="new_username">ชื่อใหม่:</label>
            <input type="text" id="new_username" name="new_username" required>
            <button type="submit">ยืนยัน</button>
        </form>
    </div>

</body>

</html>
