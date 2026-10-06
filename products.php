<?php
session_start();
include 'config/db.php';

$highlightId = isset($_GET['highlight']) ? $_GET['highlight'] : 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Products - Velvet Vogue</title>
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
.products{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    justify-content:center;
}
.product{
    background:#fff;
    padding:15px;
    width:220px;
    text-align:center; 
    border-radius:8px;
    border:2px solid #ddd;
}
.highlight{
    border:3px solid #ff69b4;
    background:#fff0f5;
}
.product img{
    max-width:100%;
    height:150px;
    object-fit:cover;
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
<a href="cart.php">Cart</a> |
<a href="contact.php">Contact Us</a> | 
<a href="logout.php">Logout</a> </nav>
</header>
<br><br>

<form method="get" style="text-align:center; margin-bottom:20px;">
    <input type="text" name="search" placeholder="Search category (Men, Women...)" style="padding:8px;width:250px;border-radius:6px;border:1px solid #aaa;">
    <button style="padding:8px 15px;border-radius:6px;">Search</button>
</form>

<h2 style="text-align:center;">Our Products</h2>

<div class="products">

<?php
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if($search != ''){
    $res = $conn->query("SELECT * FROM products WHERE category LIKE '$search%'");
} else {
    $res = $conn->query("SELECT * FROM products");
}

while($row = $res->fetch_assoc()){
    $class = ($row['id'] == $highlightId) ? "product highlight" : "product";
?>
    <div class="<?php echo $class; ?>">

        <h3><?php echo $row['name']; ?></h3>
        <p><b>Category:</b> <?php echo $row['category']; ?></p>
        <p><b>Description:</b> <?php echo $row['description']; ?></p>
        <p><b>Price:</b> Rs <?php echo $row['price']; ?></p>

        <img src="images/<?php echo $row['image']; ?>">

        <br><br>

        <!-- SIZE & COLOR SELECT FORM -->
        <form method="post" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">

            <label>Size:</label><br>
            <select name="size" required>
                <option value="">Select Size</option>
                <option>S</option>
                <option>M</option>
                <option>L</option>
                <option>XL</option>
            </select>

            <br><br>

            <label>Color:</label><br>
            <select name="color" required>
                <option value="">Select Color</option>
                <option>Black</option>
                <option>White</option>
                <option>Red</option>
                <option>Blue</option>
            </select>

            <br><br>

            <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>

    </div>
<?php } ?>

</div>

<br><br><br><br><br><br><br><br><br><br><br>

<div style="width:1510px; background:#add8e6; padding:09px; border-radius:10px;">
<footer>
    <p style="text-align:center;">© <?php echo date('Y'); ?> Velvet Vogue. All Rights Reserved.</p>
</footer>
</div>

</body>
</html>
