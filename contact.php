<?php
include 'config/db.php'; 

$msg = "";

if(isset($_POST['send'])){

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sub   = mysqli_real_escape_string($conn, $_POST['subject']);
    $mes   = mysqli_real_escape_string($conn, $_POST['message']);

    if($name && $email && $sub && $mes){

        $sql = "INSERT INTO contact(name, email, subject, message)
                VALUES('$name','$email','$sub','$mes')";

        if($conn->query($sql)){
            $msg = "<p style='color:green;'>Your message has been sent successfully!</p>";
        } else {
            $msg = "<p style='color:red;'>Database Error: ".$conn->error."</p>";
        }

    } else {
        $msg = "<p style='color:red;'>Please fill all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - Velvet Vogue</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    .contact-container{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:70vh;
    }

    .form-box{
    margin:auto;
    }
    </style>

</head>
<body>

<header>
    <h1>Velvet Vogue</h1>
    <a href="index.php">Home</a> |
    <a href="products.php">All Products</a> |
    <a href="cart.php">Cart</a>
</header>

<div class="form-box">
<h2>Contact Us</h2>
<?php echo $msg; ?>

<form method="post">

    <label>Your Name</label>
    <input type="text" name="name" required>

    <label>Email Address</label>
    <input type="email" name="email" required>

    <label>Subject</label>
    <input type="text" name="subject" required>

    <label>Message</label>
    <textarea name="message" required></textarea>

    <br><br>
    
    <button type="submit" name="send">Send Message</button>

</form>
</div>

<footer style="background:#add8e6; padding:10px; margin-top:40px;">
    <p style="text-align:center;">© <?php echo date('Y'); ?> Velvet Vogue. All Rights Reserved.</p>
</footer>

</body>
</html>
