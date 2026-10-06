<?php
session_start();
include 'config/db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user'];

// Process order
if(isset($_POST['pay'])){
    $sum = 0;

    $items = $conn->query("
    SELECT products.price, cart.quantity
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = $uid
    ");

    while($row = $items->fetch_assoc()){
        $sum += $row['price'] * $row['quantity'];
    }

    $conn->query("INSERT INTO orders(user_id,total) VALUES($uid,$sum)");
    $conn->query("DELETE FROM cart WHERE user_id = $uid");

    header("Location: order_success.php");
    exit();
}

// Get cart items
$res = $conn->query("
SELECT products.name, products.price, cart.quantity
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id = $uid
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
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
<nav><a href="index.php">Home</a> |
<a href="contact.php">Contact Us</a> | 
<a href="logout.php">Logout</a> </nav>
</header>

<h2 style="text-align:center;">Order Summary</h2>

<table border="1" width="70%" align="center">
<tr style="background:#add8e6;">
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
</tr>

<?php
$total = 0;
while($row = $res->fetch_assoc()){
    $sub = $row['price'] * $row['quantity'];
    $total += $sub;
    echo "<tr>
    <td>{$row['name']}</td>
    <td>Rs {$row['price']}</td>
    <td>{$row['quantity']}</td>
    <td>Rs $sub</td>
    </tr>";
}

// Save checkout total in session so payment page can use it when session cart isn't set
$_SESSION['checkout_total'] = $total;
?>

<tr>
<td colspan="3" align="right"><b>Grand Total</b></td>
<td><b>Rs <?php echo $total; ?></b></td>
</tr>
</table>

<form method="post" style="text-align:center;margin-top:20px;">
<a href="payment.php">
        <button type="button"><b>Confirm Order</b></button>
    </a>
<a href="products.php">
        <button type="button"><b>Cancel</b></button>
    </a>
</form><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<div style="width:1520px; background:#add8e6; padding:09px; border-radius:10px;">
<footer>
    <p style="text-align:center;">© <?php echo date('Y'); ?> Velvet Vogue. All Rights Reserved.</p>
</footer>
</div>

</body>
</html>
