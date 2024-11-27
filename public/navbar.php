<link rel="stylesheet" href="../css/navbar.css">

<nav>
    <div class="Navbar">
        <div class="NavLogo">
            <ion-icon name="person-sharp"></ion-icon>
            <h1 id="username-display"><?php echo htmlspecialchars($username); ?></h1>
        </div>
        <div class="navbarlinks">
            <li><a href="#" id="HighlightNavbar">หน้าแรก</a></li>
            <li><a href="javascript:void(0)" onclick="Settings()">การตั้งค่า</a></li>
            <li><a href="./logout.php">ออกจากระบบ</a></li>
        </div>
    </div>
</nav>