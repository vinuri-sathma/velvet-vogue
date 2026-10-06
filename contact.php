<?php
include 'config/db.php'; 

$msg = "";

if(isset($_POST['send'])){

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sub   = mysqli_real_escape_string($conn, $_POST['subject']);
    $mes   = mysqli_real_escape_string($conn, $_POST['message']);

    if($name && $email && $sub && $mes){

        /* Insert Data */
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
    .contact-container{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:70vh;
    }

    .form-box{
     max-width:540px;
     margin:40px auto;
     padding:20px 24px;
     border-radius:8px;   
    }
    </style>

</head>
<body>

<header>
    <header style="background:#add8e6; padding:15px; text-align:center;">
    <div style="float:center;">
    <img src="images/velvet_vogue_logo_8.png" alt="Velvet Vogue Logo" style="height:150px;">
    </div>

    <nav><a href="index.php">Home</a> |
    <a href="products.php">All Products</a> |
    <a href="cart.php">Cart</a></nav>
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

<div style="width:1520px; background:#add8e6; padding:09px; border-radius:10px;">
<footer>
    <p style="text-align:center;">© <?php echo date('Y'); ?> Velvet Vogue. All Rights Reserved.</p>
</footer>
</div>

</body>
</html>
