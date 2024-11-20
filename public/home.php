<?php
session_start();

if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true) {
    // ตั้งค่าสถานะเซสชันตามคุกกี้
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $_COOKIE['username'];
}

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <meta name="color-scheme" content="dark light">
    <link rel="stylesheet" href="../css/mainpage.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>

    <?php
    if (isset($_SESSION['profile'])) {
        $profile = $_SESSION['profile'];
    }
    ?>

    <nav>
        <div class="Navbar">
            <div class="NavLogo">
                <ion-icon name="person-sharp"></ion-icon>
                <h1><?php echo htmlspecialchars($username); ?></h1>
            </div>
            <div class="navbarlinks">
                <li><a href="#" id="HighlightNavbar">หน้าแรก</a></li>
                <li><a href="./logout.php">ออกจากระบบ</a></li>
            </div>
        </div>
    </nav>

</body>

</html>