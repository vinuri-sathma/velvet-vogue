<?php
session_start();
include 'config/db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user'];

if(isset($_POST['add_to_cart'])){
    $pid = $_POST['product_id'];
    $size = $_POST['size'];
    $color = $_POST['color'];

    $check = $conn->query("SELECT * FROM cart 
        WHERE user_id=$uid AND product_id=$pid AND size='$size' AND color='$color'");

    if($check->num_rows > 0){
        $conn->query("UPDATE cart SET quantity = quantity + 1 
            WHERE user_id=$uid AND product_id=$pid AND size='$size' AND color='$color'");
    } else {
        $conn->query("INSERT INTO cart(user_id,product_id,quantity,size,color) 
            VALUES($uid,$pid,1,'$size','$color')");
    }
}

if(isset($_POST['update'])){
    foreach($_POST['qty'] as $cart_id => $qty){
        if($qty <= 0){
            $conn->query("DELETE FROM cart WHERE id=$cart_id");
        } else {
            $conn->query("UPDATE cart SET quantity=$qty WHERE id=$cart_id");
        }
    }
}

if(isset($_GET['remove'])){
    $rid = $_GET['remove'];
    $conn->query("DELETE FROM cart WHERE id=$rid");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Velvet Vogue - Cart</title>
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

<header style="background:#add8e6; padding:15px; text-align:center;">
    <div style="float:center;">
    <img src="images/velvet_vogue_logo_8.png" alt="Velvet Vogue Logo" style="height:150px;">
    </div>
    <nav><a href="index.php">Home</a> |
    <a href="contact.php">Contact Us</a> | 
    <a href="logout.php">Logout</a></nav> 
</header>

<h2 style="text-align:center;">Your Shopping Cart</h2>

<form method="post">
<table border="1" width="80%" align="center" style="background:#fdf6fa;">
<tr style="background:#add8e6;">
    <th>Product</th>
    <th>Size</th>
    <th>Color</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Sub Total</th>
    <th>Remove</th>
</tr>

<?php
$total = 0;

$res = $conn->query("
SELECT cart.id, products.name, products.price, cart.quantity, cart.size, cart.color
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id = $uid
");

while($row = $res->fetch_assoc()){
    $sub = $row['price'] * $row['quantity'];
    $total += $sub;

    echo "
    <tr>
        <td>{$row['name']}</td>
        <td>{$row['size']}</td>
        <td>{$row['color']}</td>
        <td>Rs {$row['price']}</td>
        <td>
            <input type='number' name='qty[{$row['id']}]' value='{$row['quantity']}' min='1'>
        </td>
        <td>Rs $sub</td>
        <td>
            <a href='cart.php?remove={$row['id']}'>Delete</a>
        </td>
    </tr>
    ";
}
?>

<tr>
    <td colspan="5" align="right"><b>Total</b></td>
    <td colspan="2"><b>Rs <?php echo $total; ?></b></td>
</tr>

</table>

<br>
<center>
    <button name="update"><b>Update Cart</b></button>
    <a href="products.php"><button type="button"><b>Continue Shopping</b></button></a>
    <a href="checkout.php"><button type="button"><b>Proceed to Checkout</b></button></a>
</center>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

</form>

<div style="width: 1520px; background:#add8e6; padding:09px; border-radius:10px;">
<footer>
    <p style="text-align:center;">© <?php echo date('Y'); ?> Velvet Vogue. All Rights Reserved.</p>
</footer>
</div>

</body>
</html>
