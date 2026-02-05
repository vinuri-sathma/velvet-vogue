<?php
session_start();
include 'config/db.php';

$error = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    if($email == "" || $pass == ""){
        $error = "All fields are required!";
    } else {
        $q = $conn->query("SELECT * FROM users WHERE email='$email'");
        
        if($q->num_rows > 0){
            $u = $q->fetch_assoc();

            if(password_verify($pass, $u['password'])){
                $_SESSION['user'] = $u['id'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "Email not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Velvet Vogue - Login</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/validation.js"></script>
</head>
<body>

<header>
    <h1>Velvet Vogue</h1>
    <p>EMBRACE THE ELEGANCE WITHIN YOU </p>
</header>

<div style="width:300px; margin:50px auto; background:#add8e6; padding:20px; border-radius:10px;">
    <h2 style="text-align:center;">Login</h2>

    <?php if($error != ""){ ?>
        <p style="color:red; text-align:center;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="post" onsubmit="return validateLogin();">
        <input type="email" name="email" id="email" placeholder="Email" required style="width:95%; padding:8px;"><br><br>
        <input type="password" name="password" id="password" placeholder="Password" required style="width:95%; padding:8px;"><br><br>

        <button name="login" style="width:100%;">Login</button>
    </form>

    <p style="text-align:center;">
        Don’t have an account? <a href="register.php">Register</a>
    </p>
</div><br><br><br>

<div style="width:1520px; background:#add8e6; padding:09px; border-radius:10px;">
<footer>
    <p style="text-align:center;">© <?php echo date('Y'); ?> Velvet Vogue. All Rights Reserved.</p>
</footer>
</div>

</body>
</html>

