<?php
session_start();

if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true) {
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['login_date'] = date("Y-m-d H:i:s"); // เก็บวันที่ล็อกอินในเซสชัน
}

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$login_date = $_SESSION['login_date'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_username'])) {
    $new_username = $_POST['new_username'];
    $user_id = $_SESSION['user_id'];

    require_once '../includes/db.php'; // เชื่อมต่อฐานข้อมูล

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

// ฟังก์ชันสำหรับคำนวณปี เดือน และวันที่สมัคร
function calculateDurationSince($signup_date) {
    $current_date = new DateTime();
    $signup_date = new DateTime($signup_date);
    $interval = $current_date->diff($signup_date);
    $years = $interval->y;
    $months = $interval->m;
    $days = $interval->d;

    if ($years > 0) {
        return "$years ปี $months เดือน";
    } elseif ($months > 0) {
        return "$months เดือน $days วัน";
    } else {
        return "$days วัน";
    }
}

// เชื่อมต่อกับฐานข้อมูล
require_once '../includes/db.php';

// ดึงข้อมูลผู้ใช้งานจากฐานข้อมูล
$sql = "SELECT id, username, created_at FROM users WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php
// include("navbar.php");
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

    <div class="sidebar" id="SidebarNew">
        <div class="sidebarElement" id="SidebarCon">
            <div class="sidebartitile">
                <svg width="467" height="798" viewBox="0 0 467 798" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_65_10)">
                        <path
                            d="M118.175 191.008L421.552 736.811C429.34 750.822 419.673 765.35 402.562 765.35L379.393 765.35C368.7 765.35 358.224 759.47 353.332 750.721L48.1369 204.918C40.2966 190.897 49.9588 176.326 67.0972 176.326L92.085 176.326C102.802 176.326 113.297 182.232 118.175 191.008Z"
                            fill="#FFFFE9" stroke="#FFFFE9" stroke-width="9" />
                        <path
                            d="M119.692 176.203L265.336 25.384C266.84 23.8268 269.079 22.9319 271.402 22.9602L330.25 23.6759C336.538 23.7524 339.72 30.0251 335.587 34.1973L188.964 182.24C187.556 183.662 185.525 184.519 183.38 184.595L125.511 186.655C119.067 186.885 115.523 180.52 119.692 176.203Z"
                            fill="#FFFFE9" stroke="#FFFFE9" stroke-width="8" />
                        <path
                            d="M102 607.5H227C237.217 607.5 245.5 615.783 245.5 626V643C245.5 653.217 237.217 661.5 227 661.5H102C91.7827 661.5 83.5 653.217 83.5 643V626C83.5 615.783 91.7827 607.5 102 607.5Z"
                            fill="#FFFFE9" stroke="#FFFFE9" stroke-width="7" />
                        <path
                            d="M99 721C99 711.059 107.059 703 117 703H231C240.941 703 249 711.059 249 721V749C249 758.941 240.941 767 231 767H117C107.059 767 99 758.941 99 749V721Z"
                            fill="#FFFFE9" />
                        <path
                            d="M24.7626 767V170.636H237.334C283.73 170.636 322.168 179.081 352.646 195.97C383.124 212.859 405.934 235.961 421.077 265.274C436.219 294.393 443.79 327.201 443.79 363.697C443.79 400.388 436.122 433.39 420.785 462.703C405.643 491.822 382.736 514.924 352.064 532.007C321.586 548.896 283.245 557.341 237.042 557.341H90.8635V481.048H228.889C258.202 481.048 281.983 476.001 300.231 465.906C318.479 455.617 331.874 441.64 340.416 423.974C348.958 406.309 353.229 386.216 353.229 363.697C353.229 341.179 348.958 321.183 340.416 303.712C331.874 286.24 318.382 272.554 299.94 262.653C281.692 252.753 257.62 247.803 227.724 247.803H114.741V767H24.7626Z"
                            fill="#FFFFE9" />
                        <path
                            d="M25 55.2C25 42.8788 25 36.7183 27.3979 32.0122C29.5071 27.8726 32.8726 24.5071 37.0122 22.3979C41.7183 20 47.8788 20 60.2 20H81.8C94.1212 20 100.282 20 104.988 22.3979C109.127 24.5071 112.493 27.8726 114.602 32.0122C117 36.7183 117 42.8788 117 55.2V157.8C117 170.121 117 176.282 114.602 180.988C112.493 185.127 109.127 188.493 104.988 190.602C100.282 193 94.1212 193 81.8 193H60.2C47.8788 193 41.7183 193 37.0122 190.602C32.8726 188.493 29.5071 185.127 27.3979 180.988C25 176.282 25 170.121 25 157.8V55.2Z"
                            fill="#FFFFE9" />
                    </g>
                    <defs>
                        <clipPath id="clip0_65_10">
                            <rect width="467" height="798" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                <h1></h1>
            </div>
            <div class="sidebarcon">
                <li><a href="javascript:void(0)" id="sidebarhigh"><ion-icon name="golf-sharp"></ion-icon>ภาพรวม</a>
                </li>
                <li><a href=""><ion-icon name="person-outline"></ion-icon>เกียวกับ</a></li>
                <li><a href="javascript:void(0)" class="btn-toggle"><ion-icon
                            name="color-fill-outline"></ion-icon>เปลียนธีม</a>
                </li>
                <li><a href="javascript:void(0)" id="SidebarHireOpen"><ion-icon
                            name="cash-outline"></ion-icon>จ้างงาน</a>
                </li>
                <li><a href="#"><ion-icon
                            name="chevron-forward-outline"></ion-icon>ติดต่อพวกเรา</a></li>
                <li><a href="javascript:void(0)" onclick="Settings()"><ion-icon name="settings-outline"></ion-icon>การตั้งค่า</a></li>
                </a></li>
            </div>
            <div class="bottomusername">
                <ion-icon name="person-sharp"></ion-icon>
                <p><?php echo htmlspecialchars($username); ?></p>
            </div>
        </div>
    </div>

    <div id="settings">

        <div id="EventsToggleClickSettings"></div>

        <div class="form-container">
            <form id="username-form" method="POST" action="home.php" onsubmit="return validateUsername()">
                <h2>เปลี่ยนชื่อผู้ใช้</h2>
                <label for="new_username">ชื่อใหม่:</label>
                <input type="text" id="new_username" name="new_username" required>
                <button type="submit">ยืนยัน</button>
                <p id="error-message" style="color: red; display: none;">ชื่อผู้ใช้ต้องมีมากกว่า 1 ตัวและไม่มีช่องว่าง</p>
            </form>
        </div>

        <div class="user-info">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $signup_date = htmlspecialchars($row["created_at"]);
                    $duration_since_signup = calculateDurationSince($row["created_at"]);
                    echo "<p>ผู้ใช้: " . htmlspecialchars($username) . "</p>";
                    echo "<p>วันที่สมัคร: " . $signup_date . " - สมัครมาแล้ว: " . $duration_since_signup . "</p>";
                    echo "<p>วันที่ล็อกอินล่าสุด: " . htmlspecialchars($login_date) . "</p>";
                }
            } else {
                echo "<p>No user found.</p>";
            }
            ?>
        </div>

    </div>

    <script src="./javascripts/mainpage.js"></script>

</body>

</html>