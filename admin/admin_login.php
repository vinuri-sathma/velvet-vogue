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
<header style="background:#add8e6; padding:15px; text-align:center;">
    <div style="float:center;">
    <img src="../images/velvet_vogue_logo_8.png" alt="Velvet Vogue Logo" style="height:150px;">
    </div>
</header>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    body{
        margin:0;
        padding:0;
        font-family: Arial, sans-serif;

        /* ADMIN page background image */
        background-image: url('../images/bg-fashion_3.jpg');
        background-size: cover;        /* cover whole screen */
        background-position: center;   /* center image */
        background-repeat: no-repeat;  /* no repeat */
        background-attachment: fixed;  /* fixed on scroll */
    }
    </style>

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
