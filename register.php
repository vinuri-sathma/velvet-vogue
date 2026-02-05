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
</head>
<body>

<header>
    <h1>Velvet Vogue</h1>
    <p>EMBRACE THE ELEGANCE WITHIN YOU </p>
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

