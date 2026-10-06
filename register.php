<?php 
include 'config/db.php';

$msg = "";

if(isset($_POST['reg'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if($name == "" || $email == "" || $pass == ""){
        $msg = "All fields are required!";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $conn->query("INSERT INTO users(name,email,password) VALUES('$name','$email','$hash')");
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Velvet Vogue - Register</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body{
        margin:0;
        padding:0;
        font-family: Arial, sans-serif;

        background-image: url('images/bg-fashion_5.jpg'); /* your image path */
        background-size: cover;        /* make image cover whole page */
        background-position: center;   /* center the image */
        background-repeat: no-repeat;  /* no repeating */
        background-attachment: fixed;  /* stay fixed when scrolling */
        }
    </style>
</head>
<body>

<header>
<header style="background:#add8e6; padding:15px; text-align:center;">
    <div style="float:center;">
    <img src="images/velvet_vogue_logo_8.png" alt="Velvet Vogue Logo" style="height:150px;">
    </div>
</header>

<div style="width:350px; margin:40px auto; background:#add8e6; padding:20px; border-radius:10px;">
    <h2 style="text-align:center;">Create Your Account</h2>

    <?php if($msg != ""){ ?>
        <p style="color:red; text-align:center;"><?php echo $msg; ?></p>
    <?php } ?>

    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required style="width:95%; padding:8px;"><br><br>
        <input type="email" name="email" placeholder="Email Address" required style="width:95%; padding:8px;"><br><br>
        <input type="password" name="password" placeholder="Password" required style="width:95%; padding:8px;"><br><br>

        <button name="reg" style="width:100%;">Register</button>
    </form>

    <p style="text-align:center;">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div><br><br><br>

<div style="width:1510px; background:#add8e6; padding:09px; border-radius:10px;">
<footer>
    <p style="text-align:center;">© <?php echo date('Y'); ?> Velvet Vogue. All Rights Reserved.</p>
</footer>
</div>

</body>
</html>

