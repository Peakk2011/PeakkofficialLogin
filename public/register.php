<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header('Location: home.php');
    exit();
}

if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true) {
    // ตั้งค่าสถานะเซสชันตามคุกกี้
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $_COOKIE['username'];
    header('Location: home.php');
    exit();
}
?>

<?php
// register.php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once('../LineLogin/LineLogin.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบความยาวและรูปแบบของรหัสผ่าน
    if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password)) {
        $error = "Password must be at least 8 characters long and contain letters!";
    } else {
        $password = hashPassword($password);
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username already exists!";
        } else {
            $stmt->close();
            $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $stmt->close();
            header('Location: login.php');
            exit();
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/styles.css">
    <meta name="color-scheme" content="dark light">
</head>
<body>
    <div class="container">
        <h1>สร้างบัญชี</h1>
        <?php
            if (!isset($_SESSION['profile'])) {
                $line = new LineLogin();
                $link = $line->getLink();
            }
        ?>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Register">
            <a href="<?php echo $link; ?>" id="LineloginPeakkofficial">Login ด้วย line</a>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
        <?php if ($error) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
    </div>
</body>
</html>
