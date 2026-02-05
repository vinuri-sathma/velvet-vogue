<?php
session_start();
include '../config/db.php';

$msg = "";

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    if ($u == "vinu" && $p == "vinu112233") {
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $msg = "Invalid admin login";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<header>
    <h1>Velvet Vogue</h1>
    <p>EMBRACE THE ELEGANCE WITHIN YOU </p>
    <nav>
        <?php if(!isset($_SESSION['user'])){ ?>
            <a href="login.php">Login</a> |
            <a href="products.php" target="_blank">All Products</a> |
            <a href="contact.php" target="_blank">Contact Us</a>
        <?php } ?>
    </nav>
</header>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body><br><br>

<div style="width:300px; margin:50px auto; background:#add8e6; padding:20px; border-radius:10px;">
    <h2 style="text-align:center;">Admin Login</h2>

    <?php echo "<p style='color:red'>$msg</p>"; ?>

    <form method="post" onsubmit="return validateLogin();">
        <input type="text" name="username" placeholder="Admin Username" required style="width:95%; padding:8px;"><br><br>
        <input type="password" name="password" placeholder="Password" required style="width:95%; padding:8px;"><br><br>

        <button name="login" style="width:100%;">Login</button>

    </form>

</div><br><br><br><br>

<div style="width: 1520px; background:#add8e6; padding:09px; border-radius:10px;">
<footer>
    <p style="text-align:center;">© <?php echo date('Y'); ?> Velvet Vogue. All Rights Reserved.</p>
</footer>
</div>

</body>
</html>
