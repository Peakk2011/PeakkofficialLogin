<?php
session_start();
require_once('../LineLogin/LineLogin.php');

if (!isset($_SESSION['profile'])) {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peakkofficial</title>
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
                <h1><?php echo $profile->name; ?></h1>
            </div>
            <div class="navbarlinks">
                <li><a href="#" id="HighlightNavbar">หน้าแรก</a></li>
                <li><a href="./logout.php">ออกจากระบบ</a></li>
            </div>
        </div>
    </nav>


</body>

</html>